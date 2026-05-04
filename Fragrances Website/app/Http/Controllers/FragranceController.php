<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FragranceController extends Controller
{
    public function collections()
    {
        $fragrances = $this->fragrances();
        $categories = ['All', 'Fresh', 'Woody', 'Sweet', 'Oriental'];

        return view('pages.collections', [
            'fragrances' => $fragrances,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug)
    {
        $fragrances = $this->fragrances();
        $fragrance = $fragrances->firstWhere('slug', $slug);

        abort_if(!$fragrance, 404);

        $related = $fragrances
            ->where('slug', '!=', $fragrance['slug'])
            ->take(3)
            ->values();

        $barMap = [
            'soft' => 35,
            'intimate' => 45,
            'moderate' => 65,
            'persistent' => 82,
            'strong' => 90,
        ];

        $longevityWidth = $barMap[strtolower($fragrance['longevity'])] ?? 60;
        $sillageWidth = $barMap[strtolower($fragrance['sillage'])] ?? 55;

        return view('pages.detail', [
            'fragrance' => $fragrance,
            'related' => $related,
            'longevityWidth' => $longevityWidth,
            'sillageWidth' => $sillageWidth,
        ]);
    }

    public function featured()
    {
        $first = $this->fragrances()->first();

        abort_if(!$first, 404);

        return redirect()->route('fragrances.show', ['slug' => $first['slug']]);
    }

    private function fragrances(): Collection
    {
        $rows = json_decode(file_get_contents(resource_path('data/fragrances.json')), true) ?? [];

        return collect($rows)->map(function (array $item): array {
            $item['slug'] = $item['slug'] ?? Str::slug($item['name'] ?? 'fragrance');

            return $item;
        })->values();
    }
}