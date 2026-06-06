<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = route('sitemap');

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            "Sitemap: {$sitemap}",
            '',
        ]);

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
