<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\HardwareModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SystemAnalysisController extends Controller
{
    public function analyzeSystem(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'cpu_name' => 'required|string',
            'gpu_name' => 'required|string',
            'ram_gb' => 'required|integer|min:1',
            'disk_free_gb' => 'required|integer|min:1',
            'os' => 'required|string',
            'cpu_cores' => 'nullable|integer',
            'cpu_threads' => 'nullable|integer',
            'gpu_memory_gb' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 400);
        }

        $systemData = $validator->validated();

        // Find matching hardware in database
        $matchedCpu = $this->findMatchingHardware($systemData['cpu_name'], 'cpu');
        $matchedGpu = $this->findMatchingHardware($systemData['gpu_name'], 'gpu');

        // Get all games and analyze compatibility
        $games = Game::with(['requirements.cpus', 'requirements.gpus'])->get();
        $gameResults = [];

        foreach ($games as $game) {
            $compatibility = $this->analyzeGameCompatibility($game, $matchedCpu, $matchedGpu, $systemData);
            $gameResults[] = [
                'id' => $game->id,
                'name' => $game->name,
                'image' => $game->image,
                'compatibility' => $compatibility['status'],
                'percentage' => $compatibility['percentage'],
                'details' => $compatibility['details'],
                'recommendations' => $compatibility['recommendations']
            ];
        }

        // Sort by compatibility percentage
        usort($gameResults, function($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'system_info' => [
                    'cpu' => [
                        'name' => $systemData['cpu_name'],
                        'matched' => $matchedCpu ? $matchedCpu->name : null,
                        'cores' => $systemData['cpu_cores'] ?? null,
                        'threads' => $systemData['cpu_threads'] ?? null,
                    ],
                    'gpu' => [
                        'name' => $systemData['gpu_name'],
                        'matched' => $matchedGpu ? $matchedGpu->name : null,
                        'memory_gb' => $systemData['gpu_memory_gb'] ?? null,
                    ],
                    'ram_gb' => $systemData['ram_gb'],
                    'disk_free_gb' => $systemData['disk_free_gb'],
                    'os' => $systemData['os']
                ],
                'games' => $gameResults,
                'summary' => [
                    'total_games' => count($gameResults),
                    'fully_compatible' => count(array_filter($gameResults, fn($g) => $g['compatibility'] === 'excellent')),
                    'partially_compatible' => count(array_filter($gameResults, fn($g) => $g['compatibility'] === 'good')),
                    'incompatible' => count(array_filter($gameResults, fn($g) => $g['compatibility'] === 'poor')),
                ]
            ]
        ]);
    }

    public function testSingleGame(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'game_id' => 'required|integer|exists:games,id',
            'cpu_name' => 'required|string',
            'gpu_name' => 'required|string',
            'ram_gb' => 'required|integer|min:1',
            'disk_free_gb' => 'required|integer|min:1',
            'os' => 'required|string',
            'cpu_cores' => 'nullable|integer',
            'cpu_threads' => 'nullable|integer',
            'gpu_memory_gb' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 400);
        }

        $systemData = $validator->validated();
        $gameId = $systemData['game_id'];
        unset($systemData['game_id']); // Remove game_id from system data

        // Find matching hardware in database
        $matchedCpu = $this->findMatchingHardware($systemData['cpu_name'], 'cpu');
        $matchedGpu = $this->findMatchingHardware($systemData['gpu_name'], 'gpu');

        // Get the specific game with requirements
        $game = Game::with(['requirements.cpus', 'requirements.gpus'])->findOrFail($gameId);

        // Analyze compatibility for this game
        $compatibility = $this->analyzeGameCompatibility($game, $matchedCpu, $matchedGpu, $systemData);

        return response()->json([
            'success' => true,
            'data' => [
                'game' => [
                    'id' => $game->id,
                    'name' => $game->name,
                    'image' => $game->image,
                ],
                'system_info' => [
                    'cpu' => [
                        'name' => $systemData['cpu_name'],
                        'matched' => $matchedCpu ? $matchedCpu->name : null,
                        'cores' => $systemData['cpu_cores'] ?? null,
                        'threads' => $systemData['cpu_threads'] ?? null,
                    ],
                    'gpu' => [
                        'name' => $systemData['gpu_name'],
                        'matched' => $matchedGpu ? $matchedGpu->name : null,
                        'memory_gb' => $systemData['gpu_memory_gb'] ?? null,
                    ],
                    'ram_gb' => $systemData['ram_gb'],
                    'disk_free_gb' => $systemData['disk_free_gb'],
                    'os' => $systemData['os']
                ],
                'compatibility' => $compatibility['status'],
                'percentage' => $compatibility['percentage'],
                'details' => $compatibility['details'],
                'recommendations' => $compatibility['recommendations']
            ]
        ]);
    }

    private function findMatchingHardware($hardwareName, $type)
    {
        // Clean the hardware name for better matching
        $cleanName = $this->cleanHardwareName($hardwareName);

        $hardwareModels = HardwareModel::whereHas('brand', function($query) use ($type) {
            if ($type === 'cpu') {
                $query->whereIn('name', ['Intel', 'AMD']);
            } else {
                $query->where('name', 'Nvidia');
            }
        })->where('type', $type)->get();

        // Try exact match first
        foreach ($hardwareModels as $model) {
            if (stripos($cleanName, $this->cleanHardwareName($model->name)) !== false) {
                return $model;
            }
        }

        // Try fuzzy matching
        $bestMatch = null;
        $bestScore = 0;

        foreach ($hardwareModels as $model) {
            $score = $this->calculateSimilarity($cleanName, $this->cleanHardwareName($model->name));
            if ($score > $bestScore && $score > 0.6) {
                $bestScore = $score;
                $bestMatch = $model;
            }
        }

        return $bestMatch;
    }

    private function cleanHardwareName($name)
    {
        // Remove common prefixes and clean up the name
        $name = preg_replace('/^(Intel|AMD|NVIDIA|GeForce|Radeon)\s*/i', '', $name);
        
        // Remove Intel/AMD specific patterns
        $name = preg_replace('/\(R\)\s*/i', '', $name);  // Remove (R)
        $name = preg_replace('/\(TM\)\s*/i', '', $name); // Remove (TM)
        $name = preg_replace('/\s+CPU\s+@.*$/i', '', $name); // Remove CPU @ frequency
        
        // Clean up extra spaces and normalize
        $name = preg_replace('/\s+/', ' ', trim($name));
        $name = strtolower($name);
        
        // Extract core processor name (e.g., "core i7-10700f" from various formats)
        if (preg_match('/core\s+(i[3579][-\s]\d+[a-z]*)/i', $name, $matches)) {
            return strtolower($matches[1]);
        }
        
        return $name;
    }

    private function calculateSimilarity($str1, $str2)
    {
        $len1 = strlen($str1);
        $len2 = strlen($str2);

        if ($len1 == 0) return $len2 == 0 ? 1 : 0;
        if ($len2 == 0) return 0;

        $matrix = array();
        for ($i = 0; $i <= $len1; $i++) {
            $matrix[$i][0] = $i;
        }
        for ($j = 0; $j <= $len2; $j++) {
            $matrix[0][$j] = $j;
        }

        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($str1[$i-1] == $str2[$j-1]) ? 0 : 1;
                $matrix[$i][$j] = min(
                    $matrix[$i-1][$j] + 1,
                    $matrix[$i][$j-1] + 1,
                    $matrix[$i-1][$j-1] + $cost
                );
            }
        }

        $distance = $matrix[$len1][$len2];
        return 1 - ($distance / max($len1, $len2));
    }

    private function analyzeGameCompatibility($game, $matchedCpu, $matchedGpu, $systemData)
    {
        $requirements = $game->requirements;
        $details = [];
        $recommendations = [];
        $totalScore = 0;
        $maxScore = 0;

        foreach ($requirements as $requirement) {
            $requirementScore = 0;
            $requirementMax = 100;

            // Check CPU compatibility
            if ($matchedCpu) {
                $cpuCompatible = $requirement->cpus()
                    ->where('benchmark_score', '<=', $matchedCpu->benchmark_score ?? 0)
                    ->exists();

                if ($cpuCompatible) {
                    $requirementScore += 30;
                } else {
                    $recommendations[] = "CPU upgrade recommended for {$requirement->type} settings";
                }
            } else {
                $recommendations[] = "Could not identify your CPU model";
            }

            // Check GPU compatibility
            if ($matchedGpu) {
                $gpuCompatible = $requirement->gpus()
                    ->where('benchmark_score', '<=', $matchedGpu->benchmark_score ?? 0)
                    ->exists();

                if ($gpuCompatible) {
                    $requirementScore += 40;
                } else {
                    $recommendations[] = "GPU upgrade recommended for {$requirement->type} settings";
                }
            } else {
                $recommendations[] = "Could not identify your GPU model";
            }

            // Check RAM
            if ($systemData['ram_gb'] >= $requirement->ram) {
                $requirementScore += 20;
            } else {
                $recommendations[] = "More RAM needed for {$requirement->type} settings ({$requirement->ram}GB required)";
            }

            // Check disk space
            if ($systemData['disk_free_gb'] >= $requirement->disk) {
                $requirementScore += 10;
            } else {
                $recommendations[] = "More disk space needed ({$requirement->disk}GB required)";
            }

            $details[$requirement->type] = [
                'score' => $requirementScore,
                'max_score' => $requirementMax,
                'percentage' => ($requirementScore / $requirementMax) * 100,
                'ram_ok' => $systemData['ram_gb'] >= $requirement->ram,
                'disk_ok' => $systemData['disk_free_gb'] >= $requirement->disk,
                'cpu_ok' => $matchedCpu ? $requirement->cpus()->where('benchmark_score', '<=', $matchedCpu->benchmark_score ?? 0)->exists() : false,
                'gpu_ok' => $matchedGpu ? $requirement->gpus()->where('benchmark_score', '<=', $matchedGpu->benchmark_score ?? 0)->exists() : false,
            ];

            $totalScore += $requirementScore;
            $maxScore += $requirementMax;
        }

        $overallPercentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;

        // Determine compatibility status
        $status = 'poor';
        if ($overallPercentage >= 80) {
            $status = 'excellent';
        } elseif ($overallPercentage >= 60) {
            $status = 'good';
        } elseif ($overallPercentage >= 40) {
            $status = 'fair';
        }

        return [
            'status' => $status,
            'percentage' => round($overallPercentage, 1),
            'details' => $details,
            'recommendations' => array_unique($recommendations)
        ];
    }
}
