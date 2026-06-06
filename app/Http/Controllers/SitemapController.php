<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('book'), 'priority' => '0.9'],
            ['loc' => route('contact'), 'priority' => '0.8'],
        ];

        foreach (config('zynx-services') as $slug => $service) {
            $urls[] = ['loc' => route('services.show', $slug), 'priority' => '0.8'];
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
