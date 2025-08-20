<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function index()
    {
        return view('download');
    }

    public function downloadAnalyzer()
    {
        $filePath = public_path('downloads/GameCompatibilityAnalyzer.exe');

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, 'GameCompatibilityAnalyzer.exe', [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="GameCompatibilityAnalyzer.exe"'
        ]);
    }

    public function getSystemInfo()
    {
        // Return system requirements and info about the analyzer
        return response()->json([
            'system_requirements' => [
                'os' => 'Windows 7/8/10/11',
                'ram' => 'Minimum 2GB RAM',
                'disk' => 'Minimum 50MB free space',
                'internet' => 'Internet connection required'
            ],
            'features' => [
                'Automatic hardware detection',
                'CPU, GPU, RAM, and disk analysis',
                'Game compatibility scoring',
                'Detailed compatibility reports',
                'Upgrade recommendations'
            ],
            'version' => '1.0.0',
            'size' => '~15MB',
            'last_updated' => now()->format('Y-m-d')
        ]);
    }
}
