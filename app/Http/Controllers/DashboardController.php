<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Periodo;

class DashboardController extends Controller
{

    public function principal(Request $request)
    {
        $periodos=Periodo::whereRaw('f_inicio<=now()')
                           ->orderBy('id','desc')
                           ->get()
                           ->take(8);
        if(!session()->has('periodo'))
        {
            $ciclo=1;
            foreach($periodos as $periodo)
            {
                if($ciclo==1)
                {session()->put('periodo', $periodo->id);}
                $ciclo=$ciclo+1;
            }
        }
        return view('dashboard',['periodos'=>$periodos]);        
    }
}
