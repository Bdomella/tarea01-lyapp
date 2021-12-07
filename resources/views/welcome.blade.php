@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('mensaje'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form method="GET" action="{{ route('ver') }}">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">TIPO MONEDA</label>
                <div class="mb-3">
                    <select class="form-select" name="moneda">
                        <option value="uf">UF</option>
                        <option value="dolar">DOLAR</option>
                        <option value="euro">EURO</option>
                        <option value="utm">UTM</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 form-check-inline">
                <label class="form-label">FECHA DESDE:</label>
                <input required type="date" class="form-control" name="desde">

                <label class="form-label">FECHA HASTA:</label>
                <input required type="date" class="form-control" name="hasta">
            </div>
            <div>
                <label class="form-label">Color grafico</label>
                <input type="color" class="form-control form-control-color" name="color" value="{{ $color }}"
                    title="Choose your color">
            </div>
            <button type="submit" class="btn btn-primary my-3">VER GRAFICO</button>
            <a href="{{ route('lista.rangos') }}" class="btn btn-warning my-3">VER RANGOS GUARDADOS</a>
        </form>
    </div>

    <div class="container">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>

        <form method="GET" action="{{ route('grafico.guardar') }}">
            @csrf
            <input type="hidden" value="{{ $valorInicial }}" name="desde2">
            <input type="hidden" value="{{ $valorFinal }}" name="hasta2">
            <input type="hidden" value="{{ $moneda }}" name="moneda2">
            <input type="hidden" value="{{ $cadena }}" name="cadena2">
            <input id="resultado" type="hidden" name="valor2">
            <button type="submit" class="btn btn-success mt-3">GUARDAR RANGO DE FECHAS</button>
        </form>

    </div>

    <script>

    </script>



    <script>
        if (window.attachEvent) {
            window.attachEvent('onload', obtenerDatos);
        } else {
            if (window.onload) {
                var curronload = window.onload;
                var newonload = function(evt) {
                    curronload(evt);
                    yourFunctionName(evt);
                };
                window.onload = newonload;
            } else {
                window.onload = obtenerDatos;
            }
        }

        function obtenerDatos() {

            // var x = document.getElementById("nombre").value;

            const fechas = @json($array);
            var moneda = @json($moneda);
            var data = "";

            var valorInicial = @json($valorInicial);
            var valorFinal = @json($valorFinal);

            var colorGrafico = @json($color);
            fechas.forEach(myFunction);

            function myFunction(item, index) {
                let url = 'https://mindicador.cl/api/' + moneda + '/' + item;

                const api = new XMLHttpRequest();
                api.open('GET', url, true);
                api.send();

                api.onreadystatechange = function() {
                    if (this.status == 200 && this.readyState == 4) {

                        let datos = JSON.parse(this.responseText);
                        let xd = datos.serie

                        for (let item2 of datos.serie) {

                            pi = item2.valor;
                            data += pi + ",";

                            const data2 = data.substr(0, data.length - 1);
                            console.log(data2);

                            let arr = data2.split(',').map(Number);
                            let arr2 = data2.split(',');
                            console.log(arr2);

                            let resultado = document.querySelector('#resultado');

                            var text = "Valores del " + moneda + " rango de fechas:"
                            var text = text.toUpperCase()

                            var text2 = "rango de fechas desde: " + valorInicial + " - hasta: " + valorFinal
                            var text2 = text2.toUpperCase()

                            Highcharts.chart('container', {

                                title: {
                                    text: text
                                },

                                subtitle: {
                                    text: text2
                                },

                                yAxis: {
                                    title: {
                                        text: 'Valor de la unidad'
                                    }
                                },

                                xAxis: {
                                    categories: @json($array)
                                },

                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle'
                                },

                                plotOptions: {
                                    series: {
                                        label: {
                                            connectorAllowed: false
                                        },
                                    }
                                },

                                series: [{
                                    name: moneda,
                                    data: arr,
                                    color: colorGrafico
                                }],

                                responsive: {
                                    rules: [{
                                        condition: {
                                            maxWidth: 500
                                        },
                                        chartOptions: {
                                            legend: {
                                                layout: 'horizontal',
                                                align: 'center',
                                                verticalAlign: 'bottom'
                                            }
                                        }
                                    }]
                                }

                            });
                            resultado.value = arr2;
                        }

                        // console.log("Fecha: " + item + " valor: " + pi);

                    }

                }

            }
            // console.log("xd" + data);

        }

        // ---------------------------------------------------------------------------------------------

        // document.getElementById("fecha").addEventListener("change", obtenerDatos);

        // function obtenerDatos() {

        //     var x = document.getElementById("nombre").value;
        //     var date = document.getElementById("fecha").value;

        //     var info = date.split('-').reverse().join('-');
        //     let url = 'https://mindicador.cl/api/' + x + '/' + info;

        //     const api = new XMLHttpRequest();
        //     api.open('GET', url, true);
        //     api.send();

        //     api.onreadystatechange = function() {
        //         if (this.status == 200 && this.readyState == 4) {

        //             let datos = JSON.parse(this.responseText);
        //             console.log(datos.serie);
        //             let resultado = document.querySelector('#resultado');
        //             resultado.innerHTML = '';

        //             for (let item of datos.serie)

        //                 resultado.innerHTML += `<li class="list-group-item">`+x+` | ${item.fecha} |  ${item.valor}</li>`;
        //         }
        //     }
        // }
    </script>
@endsection
