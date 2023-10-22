<?php
include 'conexion.php';

$totales = isset($_POST['totales']) ? $_POST['totales'] : "";

if (isset($_POST["anios"]) && !empty($_POST["anios"])) {
    $anios = $_POST['anios'];
    sort($anios);
    $aniosArray = $anios;
} else {
    $aniosArray = range(2014, 2022);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="estilo.css">
    <title>Parcial 2</title>
</head>

<body>
    <label for="">Ventas totales anuales mayor o igual que </label>
    <input type="text" name="totales" id="totales" value="<?php echo isset($_POST['totales']) ? $_POST['totales'] : '' ?>"><br><br>

    <div id="container"></div>

    <script>
        $(document).ready(function() {
            
            $("#totales").on("keyup", function() {
                var totales = $(this).val();
                loadChart(totales);
            });

            
            function loadChart(totales) {
                
                $.ajax({
                    method: "POST",
                    url: "datos.php", 
                    data: {
                        totales: totales
                    },
                    success: function(data) {
                        
                        var chartData = JSON.parse(data);
                        updateChart(chartData);
                    }
                });
            }

            
            function updateChart(chartData) {
                Highcharts.chart('container', {
                    title: {
                        text: 'Empresa XYZ',
                        align: 'center'
                    },
                    subtitle: {
                        text: 'Total de ventas anuales de los últimos 10 años',
                        align: 'center'
                    },
                    yAxis: {
                        title: {
                            text: 'Ventas en dolares'
                        }
                    },
                    xAxis: {
                        categories: chartData.aniosArray,
                        accessibility: {
                            rangeDescription: 'Desde 2013 al 2022'
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
                            }
                        }
                    },
                    series: [{
                        name: 'Ventas anuales',
                        data: chartData.ventasArray
                    }],
                });
            }
        });
    </script>
</body>

</html>
