<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(string $service): View|Response
    {
        $services = config('zynx-services');

        if (! isset($services[$service])) {
            abort(404);
        }

        $data = $services[$service];

        return view('services.show', [
            'title' => $data['title'],
            'description' => $data['description'],
            'service' => $data,
            'slug' => $service,
        ]);
    }
}
