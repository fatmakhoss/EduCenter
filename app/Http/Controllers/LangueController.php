<?php

namespace App\Http\Controllers;

use App\Models\Langue;
use Illuminate\Http\Request;

class LangueController extends Controller
{
    public function index()
    {
        $languages = Langue::with('niveaux')->get();
        return response()->json($languages);
    }

    public function show($nom)
    {
        $language = Langue::with('niveaux')->where('nom', $nom)->firstOrFail();
        return response()->json($language);
    }
}
