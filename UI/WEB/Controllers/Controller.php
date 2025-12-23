<?php

namespace App\Containers\Vendor\Documentation\UI\WEB\Controllers;

use App\Containers\Vendor\Documentation\UI\WEB\Requests\GetPrivateDocumentationRequest;
use App\Containers\Vendor\Documentation\UI\WEB\Requests\GetPublicDocumentationRequest;
use App\Ship\Parents\Controllers\WebController as AbstractWebController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class Controller extends AbstractWebController
{
    public function showPrivateDocs(GetPrivateDocumentationRequest $request)
    {
        // Try view approach first (v13 compatible)
        if (View::exists('vendor@documentation::documentation.private.index')) {
            return view('vendor@documentation::documentation.private.index');
        }

        // Fallback to direct file serving
        $path = app_path('Containers/Vendor/Documentation/UI/WEB/Views/documentation/private/index.html');

        if (!File::exists($path)) {
            abort(404, 'Documentation not found. Please run: php artisan apiato:apidoc');
        }

        return response()->file($path);
    }

    public function showPublicDocs(GetPublicDocumentationRequest $request)
    {
        // Try view approach first (v13 compatible)
        if (View::exists('vendor@documentation::documentation.public.index')) {
            return view('vendor@documentation::documentation.public.index');
        }

        // Fallback to direct file serving
        $path = app_path('Containers/Vendor/Documentation/UI/WEB/Views/documentation/public/index.html');

        if (!File::exists($path)) {
            abort(404, 'Documentation not found. Please run: php artisan apiato:apidoc');
        }

        return response()->file($path);
    }
}
