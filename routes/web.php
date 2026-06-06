<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/book', [ConsultationController::class, 'create'])->name('book');
Route::get('/book/slots', [ConsultationController::class, 'slots'])->name('book.slots');
Route::post('/book', [ConsultationController::class, 'store'])->name('book.store');
Route::get('/book/confirm/{consultation}', [ConsultationController::class, 'confirm'])->name('book.confirm');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
