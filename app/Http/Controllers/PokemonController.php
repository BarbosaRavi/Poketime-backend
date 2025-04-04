<?php

namespace App\Http\Controllers;

use App\Services\PokeApiService;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    protected $pokeApiService;

    public function __construct(PokeApiService $pokeApiService)
    {
        $this->pokeApiService = $pokeApiService;
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $limit = $request->query('limit', 20);
        $offset = $request->query('offset', 0);

        $pokemon = $this->pokeApiService->getpokemon($limit, $offset);

        if ($search) {
            $pokemon = array_filter($pokemon, function ($character) use ($search) {
                return stripos($character['name'], $search) !== false;
            });
        }

        return response()->json(array_values($pokemon));
    }
}