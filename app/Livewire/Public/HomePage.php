<?php

namespace App\Livewire\Public;

use App\Models\Amenity;
use App\Models\Article;
use App\Models\House;
use App\Models\Review;
use App\Models\ReviewSetting;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $featuredHouses = House::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('photos')
            ->limit(6)
            ->get();

        $amenities = Amenity::query()->orderBy('sort_order')->get();

        $articles = Article::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get();

        $reviews = Review::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(9)
            ->get();

        return view('livewire.public.home-page', [
            'featuredHouses' => $featuredHouses,
            'amenities' => $amenities,
            'articles' => $articles,
            'reviews' => $reviews,
            'reviewSetting' => ReviewSetting::current(),
        ]);
    }
}
