<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $locales = SetLocale::SUPPORTED_LOCALES;

        $staticRoutes = [
            'home',
            'houses.index',
            'pages.about',
            'pages.location',
            'pages.contact',
            'pages.faq',
            'pages.legal',
        ];

        $urls = [];

        foreach ($staticRoutes as $routeName) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route($routeName, ['locale' => $locale]),
                    'changefreq' => $routeName === 'home' ? 'daily' : 'weekly',
                    'priority' => $routeName === 'home' ? '1.0' : '0.7',
                ];
            }
        }

        $houses = House::query()->where('status', 'published')->get();

        foreach ($houses as $house) {
            foreach ($locales as $locale) {
                $urls[] = [
                    'loc' => route('houses.show', ['locale' => $locale, 'house' => $house->slug]),
                    'changefreq' => 'weekly',
                    'priority' => '0.9',
                ];
            }
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
