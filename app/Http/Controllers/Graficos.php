<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Graficos extends Controller
{
    //

    public function apiIndicador(Request $request){

        $valorInicial = $request->desde;
        $valorFinal = $request->hasta;
        $moneda = $request->moneda;

        $cadena = "";

        $fechaInicio = strtotime($valorInicial);
        $fechaFin = strtotime($valorFinal);
        for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
    
            $cadena .= date("d-m-Y", $i) . ",";
        }
    
        $cadena = substr($cadena, 0, -1);
        $array = explode(",", $cadena);
    
        return view('welcome', compact('array', 'moneda'));
    }


}
