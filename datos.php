<?php
include 'conexion.php';

$totales = isset($_POST['totales']) ? $_POST['totales'] : "";

if ($totales !== "") {
    $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_fac
        INNER JOIN encabezado_fac ON detalle_fac.codigo=encabezado_fac.codigo
        GROUP BY YEAR(fecha)
        HAVING SUM(venta)  >= $totales
        ORDER BY year ASC";
} else {
    $consulta = "SELECT SUM(venta) as venta, YEAR(fecha) as year FROM detalle_fac
        INNER JOIN encabezado_fac ON detalle_fac.codigo=encabezado_fac.codigo
        ORDER BY year ASC";
}

$ejecucion = mysqli_query($conexion, $consulta);
$chartData = array('aniosArray' => array(), 'ventasArray' => array());

while ($seleccion = mysqli_fetch_assoc($ejecucion)) {
    $chartData['aniosArray'][] = $seleccion['year'];
    $chartData['ventasArray'][] = (float) $seleccion['venta'];
}

echo json_encode($chartData);
?>
