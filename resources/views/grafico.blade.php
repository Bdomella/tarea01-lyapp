{{-- git add . AGREGAR
git commit -m "MENSAJE" HACER COMMIT PARA SUBIR
git push LO ENVIA A GIT Y GIHUB --}}
@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Rangos de fechas para editar</h1>
        @foreach ($rango as $item)
            <div class="card my-2">
                <div class="list-group">

                    <a href="{{ route('grafico.detalle', $item->rangoFecha) }}"
                        class="list-group-item list-group-item-action">{{ $item->rangoFecha }}</a>
                </div>
            </div>

        @endforeach
        <a href="{{ route('volver2') }}">
            <button class="btn btn-success">VOLVER</button>
        </a>
    </div>

@endsection
