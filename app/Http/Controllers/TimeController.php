<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Character;
use App\Services\PokeApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TimeController extends Controller
{
    protected $pokeApiService;

    public function __construct(PokeApiService $pokeApiService)
    {
        $this->pokeApiService = $pokeApiService;
    }

    public function index()
    {
        return Auth::user()->Time()->with('pokemon')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pokemon' => 'required|array|max:5',
            'pokemon.*' => 'required|string',
        ]);

        $Time = Auth::user()->Time()->create([
            'name' => $request->name,
        ]);

        foreach ($request->pokemon as $pokemonId) {
            $pokemonData = $this->pokeApiService->getPokemonDetails($pokemonId);
            
            if ($pokemonData) {
                $Time->pokemon()->create($pokemonData);
            }
        }

        return response()->json($Time->load('pokemon'), 201);
    }

    public function show(Time $Time)
    {
        $this->authorize('view', $Time);
        return $Time->load('pokemon');
    }

    public function destroy(Time $Time)
    {
        $this->authorize('delete', $Time);
        $Time->delete();
        return response()->noContent();
    }
}