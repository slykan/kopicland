<?php

use App\Http\Middleware\SetLocale;
use App\Livewire\Public\HomePage;
use App\Livewire\Public\HouseDetailPage;
use App\Livewire\Public\HouseListPage;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/hr');

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
        Route::view('/booking-rules', 'pages.booking-rules')->name('pages.booking-rules');
        Route::view('/terms', 'pages.terms')->name('pages.terms');
        Route::view('/privacy', 'pages.privacy')->name('pages.privacy');
        Route::view('/cookies', 'pages.cookies')->name('pages.cookies');
    });
