<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function carga_cis(Request $request)
    {
        return back()->withStatus('Archivo cargado con exito');
    }
}
