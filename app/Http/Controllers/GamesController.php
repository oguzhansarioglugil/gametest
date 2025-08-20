<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GamesController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();

        // Arama fonksiyonu
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Sıralama - varsayılan olarak en yeni oyunlar önce
        $query->orderBy('created_at', 'desc');

        // Sayfalama - sayfa başına 12 oyun
        $games = $query->paginate(12);

        // Arama terimi varsa sayfalama linklerine ekle
        if ($request->has('search')) {
            $games->appends(['search' => $request->search]);
        }

        return view('games.index', compact('games'));
    }

    public function show($id)
    {
        $game = Game::with(['requirements.cpus', 'requirements.gpus'])->findOrFail($id);
        return view('games.show', compact('game'));
    }
}
