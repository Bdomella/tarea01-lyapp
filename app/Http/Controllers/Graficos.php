<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers;
use App\Models\RangoFecha;

class Graficos extends Controller
{
    //

    public function apiIndicador(Request $request)
    {

        $valorInicial = $request->desde;
        $valorFinal = $request->hasta;
        $moneda = $request->moneda;
        $color = $request->color;

        $cadena = "";

        $fechaInicio = strtotime($valorInicial);
        $fechaFin = strtotime($valorFinal);
        for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {

            $cadena .= date("d-m-Y", $i) . ",";
        }

        $cadena = substr($cadena, 0, -1);
        $array = explode(",", $cadena);

        // foreach($array as $cad){
        //  echo $cad;
        // }

        return view('welcome', compact('array', 'moneda', 'valorInicial', 'valorFinal', 'color', 'cadena'));
    }

    public function guardarIndicador(Request $request)
    {

        $valorInicial2 = $request->desde2;
        $valorFinal2 = $request->hasta2;

        $rango = $valorInicial2 . "-" . $valorFinal2;
        $moneda2 = $request->moneda2;

        $cadena2 = $request->cadena2;
        $cadena2 = explode(",", $cadena2);

        $countCandena = count($cadena2);

        $valor2 = $request->valor2;
        $i = -1;

        if (!$valorInicial2) {
            return back()->with('mensaje', 'Aun no se genera el grafico!');
        }
        if (!$valorFinal2) {
            return back()->with('mensaje', 'Aun no se genera el grafico!');
        }
        if (!$moneda2) {
            return back()->with('mensaje', 'Aun no se genera el grafico!');
        }

        
        $valor2 = explode(",", $valor2);



        foreach ($cadena2 as $cad) {
            $nuevoGrafico = new RangoFecha();
            $nuevoGrafico->unidad = $moneda2;
            $nuevoGrafico->rangoFecha = $rango;
            $nuevoGrafico->fecha = $cad;
            $i++;

            $skipped = array($i); // CON ESTO PUEDO SACAR EL INDICE 
            // PARA QUE NO SE VUELVA A AGREGAR EN EL OTRO FOREACH :O GRAN DESCUBRIMIENTO XD

            foreach ($valor2 as $key => $value) {
                if (in_array($key, $skipped)) {
                    $nuevoGrafico->valor = $value;
                }
            }
            $nuevoGrafico->save();
        }

        return back()->with('mensaje', 'Rango Agregado!');
    }

    public function listaIndicador()
    {
        $rango = RangoFecha::distinct()->get('rangoFecha');

        return view('grafico', compact('rango'));
    }

    public function detallesIndicador($rang)
    {
        $fechaRango = RangoFecha::where('rangoFecha', $rang)->get();
        return view('grafico.detalle', compact('fechaRango'));
    }

    public function updateIndicador(Request $request, $id)
    {
        $rangoUpdate = RangoFecha::findOrFail($id);

        $rangoUpdate->valor = $request->valorNuevo;

        $rangoUpdate->save();

        return back()->with('mensaje', 'Nota Actualizada!');
    }

    public function eliminarIndicador($id)
    {

        $rangoEliminar = RangoFecha::findOrFail($id);
        $rangoEliminar->delete();

        return back()->with('mensaje', 'Nota Eliminada');
    }
}
