<?php

namespace Digitalcloud\MultilingualNova\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class LanguageController extends Controller
{
    public function index()
    {
    }
    public function currentLocal()
    {
        return App::getLocale();
    }

    public function locals()
    {
        return App::getLocale();
    }

    public function removeLocal(Request $request, $locale)
    {
        $resourceClass = Nova::resourceForKey($request->get("resourceName"));
        if (!$resourceClass) {
            abort("Missing resource class");
        }

        $modelClass = $resourceClass::$model;
        $resource = $modelClass::find($request->get("resourceId"));
        if (!$resource) {
            abort("Missing resource");
        }

        if ($resource->forgetAllTranslations($locale)->save()) {
            return response()->json(["status" => true]);
        }

        abort("Error saving");
    }

    public function setLocal(Request $request) {
        session()->put('lang', $request->lang);
        return $request->lang ;
    }
}
