@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('ver') }}">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">TIPO MONEDA</label>
                <div class="mb-3">
                    <select class="form-select" name="moneda">
                        <option value="">UNIDAD A GRAFICAR</option>
                        <option value="uf">UF</option>
                        <option value="dolar">DOLAR</option>
                        <option value="euro">EURO</option>
                        <option value="utm">UTM</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 form-check-inline">
                <label class="form-label">FECHA DESDE:</label>
                <input type="date" class="form-control" name="desde" value="{{ $valorInicial }}">

                <label class="form-label">FECHA HASTA:</label>
                <input type="date" class="form-control" name="hasta" value="{{ $valorFinal }}">
            </div>
            <div>
                <label class="form-label">Color grafico</label>
                <input type="color" class="form-control form-control-color" name="color" value="{{ $color }}"
                    title="Choose your color">
            </div>
            <button type="submit" class="btn btn-primary mt-3">VER GRAFICO</button>
        </form>
        <ul id="resultado" class="list-group">
            {{-- @foreach ($array as $item)
                <li>{{$item}}</li>
            @endforeach --}}
        </ul>
    </div>

    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>

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
            console.log(colorGrafico);

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
                            console.log(arr);

                            let resultado = document.querySelector('#resultado');
                            // resultado.innerHTML += '<li>NOMBRE: ' + moneda + ' VALOR:' + pi + ' - ' + 'FECHA: ' + item +
                            //     '</li>';

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
