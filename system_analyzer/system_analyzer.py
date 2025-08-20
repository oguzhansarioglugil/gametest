import platform
import psutil
import cpuinfo
import requests
import json
import tkinter as tk
from tkinter import ttk, messagebox, scrolledtext
import threading
import webbrowser
from PIL import Image, ImageTk
import io
import base64
import subprocess
import re

class SystemAnalyzer:
    def __init__(self):
        self.root = tk.Tk()
        self.root.title("Game Compatibility Analyzer")
        self.root.geometry("800x600")
        self.root.resizable(True, True)

        # API URL - Change this to your website URL
        self.api_url = "http://localhost:8000/api/analyze-system"

        self.setup_gui()

    def setup_gui(self):
        # Create main frame
        main_frame = ttk.Frame(self.root, padding="10")
        main_frame.grid(row=0, column=0, sticky=(tk.W, tk.E, tk.N, tk.S))

        # Configure grid weights
        self.root.columnconfigure(0, weight=1)
        self.root.rowconfigure(0, weight=1)
        main_frame.columnconfigure(1, weight=1)
        main_frame.rowconfigure(4, weight=1)

        # Title
        title_label = ttk.Label(main_frame, text="Game Compatibility Analyzer",
                               font=('Arial', 16, 'bold'))
        title_label.grid(row=0, column=0, columnspan=2, pady=(0, 20))

        # System info display
        ttk.Label(main_frame, text="System Information:",
                 font=('Arial', 12, 'bold')).grid(row=1, column=0, columnspan=2, sticky=tk.W)

        self.system_info_text = scrolledtext.ScrolledText(main_frame, height=8, width=70)
        self.system_info_text.grid(row=2, column=0, columnspan=2, pady=(5, 10), sticky=(tk.W, tk.E))

        # Buttons
        button_frame = ttk.Frame(main_frame)
        button_frame.grid(row=3, column=0, columnspan=2, pady=10)

        self.scan_button = ttk.Button(button_frame, text="Scan System",
                                     command=self.scan_system)
        self.scan_button.pack(side=tk.LEFT, padx=(0, 10))

        self.analyze_button = ttk.Button(button_frame, text="Analyze Games",
                                        command=self.analyze_games, state=tk.DISABLED)
        self.analyze_button.pack(side=tk.LEFT, padx=(0, 10))

        self.website_button = ttk.Button(button_frame, text="Visit Website",
                                        command=self.open_website)
        self.website_button.pack(side=tk.LEFT)

        # Results display
        ttk.Label(main_frame, text="Game Compatibility Results:",
                 font=('Arial', 12, 'bold')).grid(row=4, column=0, columnspan=2, sticky=tk.W, pady=(20, 5))

        # Create treeview for results
        columns = ('Game', 'Compatibility', 'Score', 'Status')
        self.results_tree = ttk.Treeview(main_frame, columns=columns, show='headings', height=10)

        # Define headings
        for col in columns:
            self.results_tree.heading(col, text=col)
            self.results_tree.column(col, width=150)

        self.results_tree.grid(row=5, column=0, columnspan=2, pady=(5, 10), sticky=(tk.W, tk.E, tk.N, tk.S))

        # Scrollbar for treeview
        scrollbar = ttk.Scrollbar(main_frame, orient=tk.VERTICAL, command=self.results_tree.yview)
        scrollbar.grid(row=5, column=2, sticky=(tk.N, tk.S))
        self.results_tree.configure(yscrollcommand=scrollbar.set)

        # Progress bar
        self.progress = ttk.Progressbar(main_frame, mode='indeterminate')
        self.progress.grid(row=6, column=0, columnspan=2, sticky=(tk.W, tk.E), pady=(10, 0))

        # Initialize system info
        self.system_data = {}

    def get_gpu_info_windows(self):
        """Get GPU information using Windows WMI"""
        try:
            # Try using wmic command
            result = subprocess.run(['wmic', 'path', 'win32_VideoController', 'get', 'name', '/value'],
                                  capture_output=True, text=True, timeout=10)

            if result.returncode == 0:
                lines = result.stdout.strip().split('\n')
                for line in lines:
                    if line.startswith('Name='):
                        gpu_name = line.replace('Name=', '').strip()
                        if gpu_name and gpu_name != '':
                            return gpu_name, 0  # Memory will be 0 for now

            # Fallback to dxdiag
            result = subprocess.run(['dxdiag', '/t', 'temp_dxdiag.txt'],
                                  capture_output=True, timeout=15)

            if result.returncode == 0:
                try:
                    with open('temp_dxdiag.txt', 'r', encoding='utf-8', errors='ignore') as f:
                        content = f.read()

                    # Look for display devices
                    gpu_match = re.search(r'Card name:\s*(.+)', content)
                    if gpu_match:
                        gpu_name = gpu_match.group(1).strip()

                        # Try to find memory info
                        memory_match = re.search(r'Dedicated Memory:\s*(\d+)\s*MB', content)
                        gpu_memory = 0
                        if memory_match:
                            gpu_memory = int(memory_match.group(1)) // 1024  # Convert MB to GB

                        return gpu_name, gpu_memory

                except Exception:
                    pass
                finally:
                    # Clean up temp file
                    try:
                        import os
                        if os.path.exists('temp_dxdiag.txt'):
                            os.remove('temp_dxdiag.txt')
                    except:
                        pass

        except Exception as e:
            print(f"GPU detection error: {e}")

        return "Unknown GPU", 0

    def get_gpu_info_alternative(self):
        """Alternative GPU detection method"""
        try:
            # Try using PowerShell
            ps_command = "Get-WmiObject -Class Win32_VideoController | Select-Object Name, AdapterRAM"
            result = subprocess.run(['powershell', '-Command', ps_command],
                                  capture_output=True, text=True, timeout=10)

            if result.returncode == 0:
                lines = result.stdout.strip().split('\n')
                for line in lines:
                    if 'Name' in line and 'AdapterRAM' in line:
                        continue  # Skip header
                    if line.strip() and not line.startswith('---'):
                        parts = line.strip().split()
                        if len(parts) > 0:
                            gpu_name = ' '.join(parts[:-1]) if len(parts) > 1 else parts[0]
                            if gpu_name and 'Microsoft' not in gpu_name:
                                return gpu_name, 0

        except Exception as e:
            print(f"PowerShell GPU detection error: {e}")

        return "Unknown GPU", 0

    def get_system_info(self):
        """Collect system information"""
        try:
            # CPU Information
            cpu_info = cpuinfo.get_cpu_info()
            cpu_name = cpu_info.get('brand_raw', 'Unknown CPU')
            cpu_cores = psutil.cpu_count(logical=False)
            cpu_threads = psutil.cpu_count(logical=True)

            # GPU Information - Try multiple methods
            gpu_name = "Unknown GPU"
            gpu_memory_gb = 0

            # Try Windows-specific methods first
            if platform.system() == 'Windows':
                gpu_name, gpu_memory_gb = self.get_gpu_info_windows()

                # If that fails, try alternative method
                if gpu_name == "Unknown GPU":
                    gpu_name, gpu_memory_gb = self.get_gpu_info_alternative()

            # If still unknown, use basic processor info
            if gpu_name == "Unknown GPU":
                gpu_name = platform.processor() or "Integrated Graphics"

            # Memory Information
            memory = psutil.virtual_memory()
            ram_gb = int(memory.total / (1024**3))  # Convert bytes to GB

            # Disk Information
            disk = psutil.disk_usage('/')
            disk_free_gb = int(disk.free / (1024**3))  # Convert bytes to GB

            # OS Information
            os_info = f"{platform.system()} {platform.release()}"

            system_data = {
                'cpu_name': cpu_name,
                'gpu_name': gpu_name,
                'ram_gb': ram_gb,
                'disk_free_gb': disk_free_gb,
                'os': os_info,
                'cpu_cores': cpu_cores,
                'cpu_threads': cpu_threads,
                'gpu_memory_gb': gpu_memory_gb
            }

            return system_data

        except Exception as e:
            messagebox.showerror("Error", f"Failed to get system information: {str(e)}")
            return None

    def scan_system(self):
        """Scan system and display information"""
        def scan_worker():
            self.progress.start()
            self.scan_button.configure(state=tk.DISABLED)

            try:
                self.system_data = self.get_system_info()

                if self.system_data:
                    # Display system info
                    info_text = f"""CPU: {self.system_data['cpu_name']}
Cores: {self.system_data['cpu_cores']} / Threads: {self.system_data['cpu_threads']}
GPU: {self.system_data['gpu_name']}
GPU Memory: {self.system_data['gpu_memory_gb']} GB
RAM: {self.system_data['ram_gb']} GB
Free Disk Space: {self.system_data['disk_free_gb']} GB
Operating System: {self.system_data['os']}"""

                    self.system_info_text.delete(1.0, tk.END)
                    self.system_info_text.insert(1.0, info_text)

                    self.analyze_button.configure(state=tk.NORMAL)
                    messagebox.showinfo("Success", "System scan completed successfully!")

            except Exception as e:
                messagebox.showerror("Error", f"System scan failed: {str(e)}")

            finally:
                self.progress.stop()
                self.scan_button.configure(state=tk.NORMAL)

        threading.Thread(target=scan_worker, daemon=True).start()

    def analyze_games(self):
        """Send system data to API and get game compatibility results"""
        if not self.system_data:
            messagebox.showwarning("Warning", "Please scan your system first!")
            return

        def analyze_worker():
            self.progress.start()
            self.analyze_button.configure(state=tk.DISABLED)

            try:
                # Send request to API
                response = requests.post(self.api_url,
                                       json=self.system_data,
                                       headers={'Content-Type': 'application/json'},
                                       timeout=30)

                if response.status_code == 200:
                    result = response.json()

                    if result['success']:
                        self.display_results(result)
                        messagebox.showinfo("Success",
                                          f"Analysis completed!\n\n"
                                          f"Total Games: {result['summary']['total_games']}\n"
                                          f"Fully Compatible: {result['summary']['fully_compatible']}\n"
                                          f"Partially Compatible: {result['summary']['partially_compatible']}\n"
                                          f"Incompatible: {result['summary']['incompatible']}")
                    else:
                        messagebox.showerror("Error", f"API Error: {result.get('message', 'Unknown error')}")
                else:
                    messagebox.showerror("Error", f"HTTP Error: {response.status_code}")

            except requests.exceptions.ConnectionError:
                messagebox.showerror("Connection Error",
                                   "Could not connect to the server. Please check your internet connection.")
            except requests.exceptions.Timeout:
                messagebox.showerror("Timeout Error",
                                   "Request timed out. Please try again.")
            except Exception as e:
                messagebox.showerror("Error", f"Analysis failed: {str(e)}")

            finally:
                self.progress.stop()
                self.analyze_button.configure(state=tk.NORMAL)

        threading.Thread(target=analyze_worker, daemon=True).start()

    def display_results(self, result):
        """Display game compatibility results"""
        # Clear existing results
        for item in self.results_tree.get_children():
            self.results_tree.delete(item)

        # Add new results
        for game in result['games']:
            compatibility = game['compatibility'].capitalize()
            score = f"{game['percentage']}%"

            # Color coding
            if game['compatibility'] == 'excellent':
                status = "✓ Excellent"
                tags = ('excellent',)
            elif game['compatibility'] == 'good':
                status = "✓ Good"
                tags = ('good',)
            elif game['compatibility'] == 'fair':
                status = "⚠ Fair"
                tags = ('fair',)
            else:
                status = "✗ Poor"
                tags = ('poor',)

            self.results_tree.insert('', tk.END,
                                   values=(game['name'], compatibility, score, status),
                                   tags=tags)

        # Configure tags
        self.results_tree.tag_configure('excellent', background='#d4edda')
        self.results_tree.tag_configure('good', background='#d1ecf1')
        self.results_tree.tag_configure('fair', background='#fff3cd')
        self.results_tree.tag_configure('poor', background='#f8d7da')

    def open_website(self):
        """Open the website in default browser"""
        webbrowser.open('http://localhost:8000')  # Change this to your website URL

    def run(self):
        """Start the application"""
        self.root.mainloop()

if __name__ == "__main__":
    try:
        app = SystemAnalyzer()
        app.run()
    except Exception as e:
        print(f"Error starting application: {e}")
        input("Press Enter to exit...")
