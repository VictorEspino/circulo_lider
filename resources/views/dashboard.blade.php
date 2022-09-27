<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard General') }}
    </x-slot>
    <div class="w-full px-8 flex flex-col">
        <div class="w-full bg-gray-700 text-white rounded py-2 px-5">
            MOVIMIENTOS
        </div>
        <div class="w-full flex flex-col pt-4 pb-8">
            <div class="w-full flex flex-row">
                <div class="w-1/2 px-6 font-bold text-gray-700">
                    ACTIVACIONES
                </div>
                <div class="w-1/2 px-6 font-bold text-gray-700">
                    RENOVACIONES
                </div>
            </div>
            <div class="w-full flex flex-row space-x-5">
                <div class="w-1/2">
                    <canvas id="chartActivaciones" width="200" height="300"></canvas>
                </div>
                <div class="w-1/2">
                    <canvas id="chartRenovaciones" width="200" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="w-full bg-gray-700 text-white rounded py-2 px-5">
            EFECTIVIDAD
        </div>
        <div class="w-full pt-4 pb-4">
            <div class="w-full flex flex-row">
                <div class="w-1/4 px-6 font-bold text-gray-700 flex justify-center">
                    TIENDA
                </div>
                <div class="w-1/4 px-6 font-bold text-gray-700 flex justify-center">
                    ZONA INFLUENCIA
                </div>
                <div class="w-1/4 px-6 font-bold text-gray-700 flex justify-center">
                    CONTACTO DIGITAL
                </div>
                <div class="w-1/4 px-6 font-bold text-gray-700 flex justify-center">
                    REFERIDOS
                </div>
            </div>
            <div class="w-full flex flex-row space-x-5">
                <div class="w-1/4 flex flex-col">
                    <div class="w-full pb-3">                    
                        <div class="flex justify-center" id="chart_div" style="width: 400px; height: 120px;"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2 flex justify-end text-sm font-bold">
                            VISITAS
                        </div>
                        <div class="w-1/2  px-3 flex justify-center text-sm">
                            1,465
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2  flex justify-end text-sm font-bold">
                            C/Intencion de compra
                        </div>
                        <div class="w-1/2 px-3  flex justify-center text-sm">
                            398
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2  flex justify-end text-sm font-bold">
                            Movimientos
                        </div>
                        <div class="w-1/2 px-3  flex justify-center  text-sm">
                            175
                        </div>
                    </div>
                </div>
                <div class="w-1/4 flex flex-col">
                    <div class="w-full pb-3">                    
                        <div class="flex justify-center" id="chart_div_2" style="width: 400px; height: 120px;"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2 flex justify-end text-sm font-bold">
                            ENCUESTAS
                        </div>
                        <div class="w-1/2  px-3 flex justify-center text-sm">
                            35
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2  flex justify-end text-sm font-bold">
                            Movimientos
                        </div>
                        <div class="w-1/2 px-3  flex justify-center  text-sm">
                            8
                        </div>
                    </div>
                </div>
                <div class="w-1/4 flex flex-col">
                    <div class="w-full pb-3">                    
                        <div class="flex justify-center" id="chart_div_3" style="width: 400px; height: 120px;"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2 flex justify-end text-sm font-bold">
                            CONTACTOS
                        </div>
                        <div class="w-1/2  px-3 flex justify-center text-sm">
                            85
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2  flex justify-end text-sm font-bold">
                            Movimientos
                        </div>
                        <div class="w-1/2 px-3  flex justify-center  text-sm">
                            15
                        </div>
                    </div>
                </div>
                <div class="w-1/4 flex flex-col">
                    <div class="w-full pb-3">                    
                        <div class="flex justify-center" id="chart_div_4" style="width: 400px; height: 120px;"></div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2 flex justify-end text-sm font-bold">
                            REFERIDOS
                        </div>
                        <div class="w-1/2  px-3 flex justify-center text-sm">
                            25
                        </div>
                    </div>
                    <div class="w-full flex flex-row">
                        <div class="w-1/2  flex justify-end text-sm font-bold">
                            Movimientos
                        </div>
                        <div class="w-1/2 px-3  flex justify-center  text-sm">
                            8
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="w-full bg-gray-700 text-white rounded py-2 px-5">
            DRILL DOWN
        </div>
        <div class="w-full pt-4 pb-4 flex justify-center">
            <table>
                <tr>
                    <td>
                        REGION CENTRO
                    </td>
                    <td class="px-5">
                        <i class="text-orange-500 fas fa-info-circle"></i>
                    </td>
                </tr>
                <tr>
                    <td>
                        REGION PACIFICO
                    </td>
                    <td class="px-5">
                        <i class="text-orange-500 fas fa-info-circle"></i>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['gauge']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);
        google.charts.setOnLoadCallback(drawChart3);
        google.charts.setOnLoadCallback(drawChart4);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['', 44],
            ]);

            var options = {
            width: 400, height: 120,
            redFrom: 0, redTo: 40,
            yellowFrom:40, yellowTo: 60,
            greenFrom:60, greenTo: 100,
            minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
        function drawChart2() {

        var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', 23],
        ]);

        var options = {
        width: 400, height: 120,
        redFrom: 0, redTo: 40,
        yellowFrom:40, yellowTo: 60,
        greenFrom:60, greenTo: 100,
        minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_2'));

        chart.draw(data, options);
        }

        function drawChart3() {

        var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', 18],
        ]);

        var options = {
        width: 400, height: 120,
        redFrom: 0, redTo: 40,
        yellowFrom:40, yellowTo: 60,
        greenFrom:60, greenTo: 100,
        minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_3'));

        chart.draw(data, options);
        }
        function drawChart4() {

        var data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['', 32],
        ]);

        var options = {
        width: 400, height: 120,
        redFrom: 0, redTo: 40,
        yellowFrom:40, yellowTo: 60,
        greenFrom:60, greenTo: 100,
        minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div_4'));

        chart.draw(data, options);
        }
      
        </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.js"></script>   
<script>
var activaciones = document.getElementById("chartActivaciones").getContext('2d');
var renovaciones = document.getElementById("chartRenovaciones").getContext('2d');

new Chart(activaciones, {
type: 'line',
data: {
    labels: ["Ene",	"Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
    datasets: [{
            label: 2022, // Name the series
            data: [ // Specify the data values array
                100,
                130,
                110,
                90,
                110,
                100,
                85,
                  ],
            fill: false,
            borderColor: '#FF0000', // Add custom color border (Line)
            backgroundColor: '#FF0000', // Add custom color background (Points and Fill)
            borderWidth: 1, // Specify bar border width
            tension:0.1
        },
                  {
            label: 2021, // Name the series
            data: [ // Specify the data values array
                    70,
                    80,
                    90,
                    100,
                    100,
                    100,
                    110,
                    110,
                    110,
                    110,
                    130,
                    120,
                  ],
            fill: true,
            borderColor: '#ccf5ff', // Add custom color border (Line)
            backgroundColor: '#ccf5ff', // Add custom color background (Points and Fill)
            borderWidth: 1, // Specify bar border width
            tension_:0.1
        }]
    },
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
      scales: {
        y: {
            min: 0,
        }
        }
    }
});
new Chart(renovaciones, {
type: 'line',
data: {
    labels: ["Ene",	"Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
    datasets: [{
            label: 2022, // Name the series
            data: [ // Specify the data values array
                60,
                30,
                40,
                34,
                45,
                40,
                55,
                  ],
            fill: false,
            borderColor: '#FF0000', // Add custom color border (Line)
            backgroundColor: '#FF0000', // Add custom color background (Points and Fill)
            borderWidth: 1, // Specify bar border width
            tension:0.1
        },
                  {
            label: 2021, // Name the series
            data: [ // Specify the data values array
                    40,
                    50,
                    60,
                    70,
                    70,
                    70,
                    80,
                    80,
                    80,
                    80,
                    70,
                    70,
                  ],
            fill: true,
            borderColor: '#FFd5dd', // Add custom color border (Line)
            backgroundColor: '#FFd5dd', // Add custom color background (Points and Fill)
            borderWidth: 1, // Specify bar border width
            tension_:0.1
        }]
    },
    options: {
      responsive: true, // Instruct chart js to respond nicely.
      maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
      scales: {
        y: {
            min: 0,
        }
        }
    }
});
</script>  
</x-app-layout>