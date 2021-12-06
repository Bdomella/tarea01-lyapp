@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="GET" action="{{ route('ver') }}">
            @csrf
            TIPO MONEDA:
            <select name="moneda">
                <option value="uf">UF</option>
                <option value="dolar">DOLAR</option>
                <option value="euro">EURO</option>
                <option value="utm">UTM</option>
            </select>
            FECHA DESDE: <input type="date" name="desde">
            FECHA HASTA: <input type="date" name="hasta">
            <button class="btn btn-primary btn-block" type="submit">Ver valores</button>
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

                            data += pi + ", ";

                            let resultado = document.querySelector('#resultado');
                            resultado.innerHTML += '<li>NOMBRE: ' + moneda + ' VALOR:' + pi + ' - ' + 'FECHA: ' + item +
                                '</li>';

                            Highcharts.chart('container', {

                                title: {
                                    text: 'Solar Employment Growth by Sector, 2010-2016'
                                },

                                subtitle: {
                                    text: 'Source: thesolarfoundation.com'
                                },

                                yAxis: {
                                    title: {
                                        text: 'Number of Employees'
                                    }
                                },

                                xAxis: {
                                    accessibility: {
                                        rangeDescription: 'Range: 2010 to 2017'
                                    }
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
                                        pointStart: 2010
                                    }
                                },

                                series: [{
                                    name: moneda,
                                    data: [213]
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
                        console.log(data);
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
