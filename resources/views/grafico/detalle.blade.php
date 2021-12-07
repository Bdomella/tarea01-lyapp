@extends('layouts.app')

@section('content')

    <div class="container">
        @if (session('mensaje'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($fechaRango as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->unidad }}</td>
                        <td>{{ $item->fecha }}</td>
                        <form method="GET" action="{{ route('grafico.editar', $item->id) }}">
                            @csrf
                            <td><input type="text" value="{{ $item->valor }}" name="valorNuevo"></td>
                            <td>

                                <button type="submit" class="btn btn-warning btn-sm">Editar Valor</button>
                        </form>

                        <form action="{{ route('grafico.eliminar', $item->id) }}" class="d-inline" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar Registro</button>
                        </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <a href="{{ route('volver') }}">
            <button class="btn btn-success">VOLVER</button>
        </a>
    </div>

@endsection
