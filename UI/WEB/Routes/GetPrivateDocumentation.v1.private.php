<?php

use App\Containers\Vendor\Documentation\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

if (config('vendor-documentation.types.private.url')) {
    Route::domain(Config::get('app.domain'))
        ->withoutMiddleware(['WebLocaleRedirect'])
        ->group(function () {
            if (config('vendor-documentation.protect-private-docs')) {
                Route::get(config('vendor-documentation.types.private.url'), [Controller::class, 'showPrivateDocs'])
                    ->name('private_docs')
                    ->middleware('auth:web');
            } else {
                Route::get(config('vendor-documentation.types.private.url'), [Controller::class, 'showPrivateDocs'])
                    ->name('private_docs');
            }
        });
}
