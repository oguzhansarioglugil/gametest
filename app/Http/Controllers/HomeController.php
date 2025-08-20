<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function index(Request $request)
    {
        $query = Game::with(['minimumRequirements', 'recommendedRequirements']);

        // Arama işlevi
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
        }

        // En fazla 10 oyun göster
        $games = $query->orderBy('score', 'desc')
                      ->orderBy('name', 'asc')
                      ->limit(10)
                      ->get();

        return view('home', compact('games'));
    }

    /**
     * AJAX ile canlı arama
     */
    public function liveSearch(Request $request)
    {
        $searchTerm = $request->get('search', '');

        if (strlen($searchTerm) < 1) {
            // Boş arama - tüm oyunları göster
            $games = Game::with(['minimumRequirements', 'recommendedRequirements'])
                        ->orderBy('score', 'desc')
                        ->orderBy('name', 'asc')
                        ->limit(10)
                        ->get();
        } else {
            // Arama terimi var - filtrele
            $games = Game::with(['minimumRequirements', 'recommendedRequirements'])
                        ->where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                        ->orderBy('score', 'desc')
                        ->orderBy('name', 'asc')
                        ->limit(10)
                        ->get();
        }

        return response()->json([
            'games' => $games,
            'count' => $games->count(),
            'search_term' => $searchTerm
        ]);
    }
}
