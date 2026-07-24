<?php

use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SetLocale;
use App\Livewire\Public\HomePage;
use App\Livewire\Public\HouseDetailPage;
use App\Livewire\Public\HouseListPage;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/hr');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::prefix('{locale}')
    ->where(['locale' => implode('|', SetLocale::SUPPORTED_LOCALES)])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', HomePage::class)->name('home');

        Route::get('/houses', HouseListPage::class)->name('houses.index');
        Route::get('/houses/{house:slug}', HouseDetailPage::class)->name('houses.show');

        Route::view('/about', 'pages.about')->name('pages.about');
        Route::view('/location', 'pages.location')->name('pages.location');
        Route::view('/contact', 'pages.contact')->name('pages.contact');
        Route::view('/faq', 'pages.faq')->name('pages.faq');
        Route::view('/legal', 'pages.legal')->name('pages.legal');
    });
