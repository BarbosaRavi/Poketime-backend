<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokeApiService
{
    protected $baseUrl = 'https://pokeapi.co/api/v2/';

    public function getCharacters(int $limit = 100, int $offset = 0)
    {
        return Cache::remember('pokemon.characters.'.$limit.'.'.$offset, now()->addHours(24), function () use ($limit, $offset) {
            $response = Http::get($this->baseUrl.'pokemon', [
                'limit' => $limit,
                'offset' => $offset,
            ]);

            if ($response->successful()) {
                return $response->json()['results'];
            }

            return [];
        });
    }

    public function getCharacterDetails(string $nameOrId)
    {
        return Cache::remember('pokemon.character.'.$nameOrId, now()->addHours(24), function () use ($nameOrId) {
            $response = Http::get($this->baseUrl.'pokemon/'.$nameOrId);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'api_id' => $data['id'],
                    'name' => $data['name'],
                    'image_url' => $data['sprites']['other']['official-artwork']['front_default'],
                    'type' => $data['types'][0]['type']['name'] ?? 'unknown',
                ];
            }

            return null;
        });
    }
}