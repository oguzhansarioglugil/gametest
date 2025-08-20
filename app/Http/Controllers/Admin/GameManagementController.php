<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameRequirement;
use App\Models\HardwareModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Game::with(['requirements']);

        // Arama filtresi
        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $games = $query->orderBy('created_at', 'desc')->paginate(10);

        // Pagination'da search parametresini koru
        $games->appends($request->all());

        // İstatistikler için ayrı sorgular
        $totalGames = Game::count();
        $averageScore = Game::whereNotNull('score')->avg('score');
        $gamesWithRequirements = Game::whereHas('requirements')->count();

        return view('admin.games.index', compact('games', 'totalGames', 'averageScore', 'gamesWithRequirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cpuModels = HardwareModel::with('brand')
            ->where('type', 'cpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        $gpuModels = HardwareModel::with('brand')
            ->where('type', 'gpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        return view('admin.games.create', compact('cpuModels', 'gpuModels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'score' => 'nullable|numeric|min:0|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Dynamic requirements structure
            'requirements' => 'required|array|min:1',
            'requirements.*.type' => 'required|in:minimum,recommended',
            'requirements.*.ram' => 'required|integer|min:1|max:256',
            'requirements.*.disk' => 'required|integer|min:1|max:10000',
            'requirements.*.cpus' => 'required|array|min:1',
            'requirements.*.cpus.*' => 'exists:hardware_models,id',
            'requirements.*.gpus' => 'required|array|min:1',
            'requirements.*.gpus.*' => 'exists:hardware_models,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Oyunu oluştur
        $gameData = [
            'name' => $request->name,
            'description' => $request->description,
            'score' => $request->score,
        ];

        // Resim yükleme
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('games', 'public');
            $gameData['image'] = $imagePath;
        }

        $game = Game::create($gameData);

        // Gereksinimleri işle
        foreach ($request->requirements as $requirementData) {
            $requirement = GameRequirement::create([
                'game_id' => $game->id,
                'type' => $requirementData['type'],
                'ram' => $requirementData['ram'],
                'disk' => $requirementData['disk'],
            ]);

            // CPU'ları ekle
            if (isset($requirementData['cpus']) && is_array($requirementData['cpus'])) {
                $cpuIds = array_filter($requirementData['cpus'], function($id) {
                    return !empty($id);
                });
                if (!empty($cpuIds)) {
                    $requirement->cpus()->attach($cpuIds);
                }
            }

            // GPU'ları ekle
            if (isset($requirementData['gpus']) && is_array($requirementData['gpus'])) {
                $gpuIds = array_filter($requirementData['gpus'], function($id) {
                    return !empty($id);
                });
                if (!empty($gpuIds)) {
                    $requirement->gpus()->attach($gpuIds);
                }
            }
        }

        return redirect()->route('admin.games.index')->with('success', 'Oyun başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = Game::with(['requirements.cpus.brand', 'requirements.gpus.brand'])->findOrFail($id);
        return view('admin.games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $game = Game::with(['requirements.cpus', 'requirements.gpus'])->findOrFail($id);

        $cpuModels = HardwareModel::with('brand')
            ->where('type', 'cpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        $gpuModels = HardwareModel::with('brand')
            ->where('type', 'gpu')
            ->orderBy('brand_id')
            ->orderBy('name')
            ->get();

        return view('admin.games.edit', compact('game', 'cpuModels', 'gpuModels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $game = Game::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'score' => 'nullable|numeric|min:0|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $gameData = [
            'name' => $request->name,
            'description' => $request->description,
            'score' => $request->score,
        ];

        // Resim yükleme
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('games', 'public');
            $gameData['image'] = $imagePath;
        }

        $game->update($gameData);

        return redirect()->route('admin.games.index')->with('success', 'Oyun başarıyla güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);

        // İlişkili gereksinimleri sil
        foreach ($game->requirements as $requirement) {
            $requirement->cpus()->detach();
            $requirement->gpus()->detach();
            $requirement->delete();
        }

        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Oyun başarıyla silindi!');
    }

    /**
     * Bulk delete selected games
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'selected_games' => 'required|array|min:1',
            'selected_games.*' => 'exists:games,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.games.index')
                ->with('error', 'Geçersiz oyun seçimi!');
        }

        $selectedGameIds = $request->selected_games;
        $games = Game::whereIn('id', $selectedGameIds)->with('requirements')->get();

        $deletedCount = 0;

        foreach ($games as $game) {
            // İlişkili gereksinimleri sil
            foreach ($game->requirements as $requirement) {
                $requirement->cpus()->detach();
                $requirement->gpus()->detach();
                $requirement->delete();
            }

            $game->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.games.index')
            ->with('success', "{$deletedCount} oyun başarıyla silindi!");
    }

    /**
     * CPU autocomplete endpoint
     */
    public function searchCpus(Request $request)
    {
        $query = $request->get('q', '');

        $cpus = HardwareModel::with('brand')
            ->where('type', 'cpu')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('brand', function($brandQuery) use ($query) {
                      $brandQuery->where('name', 'LIKE', '%' . $query . '%');
                  });
            })
            ->orderBy('brand_id')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($cpus->map(function ($cpu) {
            return [
                'id' => $cpu->id,
                'name' => $cpu->brand->name . ' ' . $cpu->name,
                'full_name' => $cpu->brand->name . ' ' . $cpu->name,
                'benchmark_score' => $cpu->benchmark_score
            ];
        }));
    }

    /**
     * GPU autocomplete endpoint
     */
    public function searchGpus(Request $request)
    {
        $query = $request->get('q', '');

        $gpus = HardwareModel::with('brand')
            ->where('type', 'gpu')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('brand', function($brandQuery) use ($query) {
                      $brandQuery->where('name', 'LIKE', '%' . $query . '%');
                  });
            })
            ->orderBy('brand_id')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($gpus->map(function ($gpu) {
            return [
                'id' => $gpu->id,
                'name' => $gpu->brand->name . ' ' . $gpu->name,
                'full_name' => $gpu->brand->name . ' ' . $gpu->name,
                'benchmark_score' => $gpu->benchmark_score
            ];
        }));
    }
}
