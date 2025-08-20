import os
import subprocess
import sys

def build_exe():
    """Build the executable file"""

    print("Building Game Compatibility Analyzer...")

    # PyInstaller command
    cmd = [
        'pyinstaller',
        '--onefile',  # Create a single executable file
        '--windowed',  # No console window (GUI only)
        '--name=GameCompatibilityAnalyzer',
        '--icon=icon.ico',  # Add icon if available
        '--add-data=icon.ico;.',  # Include icon in the build
        'system_analyzer.py'
    ]

    try:
        # Run PyInstaller
        result = subprocess.run(cmd, check=True, capture_output=True, text=True)
        print("Build successful!")
        print(f"Executable created in: {os.path.abspath('dist')}")

        # Copy the exe to a more accessible location
        exe_path = os.path.join('dist', 'GameCompatibilityAnalyzer.exe')
        if os.path.exists(exe_path):
            print(f"Executable size: {os.path.getsize(exe_path) / 1024 / 1024:.2f} MB")

    except subprocess.CalledProcessError as e:
        print(f"Build failed: {e}")
        print(f"Error output: {e.stderr}")
        return False

    return True

if __name__ == "__main__":
    if build_exe():
        print("\n✓ Build completed successfully!")
        print("You can find the executable in the 'dist' folder.")
        print("You can now upload this to your website for download.")
    else:
        print("\n✗ Build failed!")
        sys.exit(1)
