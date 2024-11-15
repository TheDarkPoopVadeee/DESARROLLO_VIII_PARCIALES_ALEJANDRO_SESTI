<?php


include 'funciones_tienda.php';

// Array productos
$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Array carrito de compras
$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

// Calcular el subtotal del carrito
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    if (isset($productos[$producto]) && $cantidad > 0) {
        
        $subtotal += $productos[$producto] * $cantidad;
    }
}

// Calcular descuento, impuesto y total
$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal);
$total = calcular_total($subtotal, $descuento, $impuesto);

// Mostrar resultados en formato HTML
echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Resumen de Compra</title>";
echo "</head>";
echo "<body>";
echo "<h1>Resumen de Compra</h1>";
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>Producto</th>";
echo "<th>Precio Unitario</th>";
echo "<th>Cantidad</th>";
echo "<th>Total</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Mostrar detalles de cada producto en el carrito
foreach ($carrito as $producto => $cantidad) {
    if (isset($productos[$producto]) && $cantidad > 0) {
        $precio_unitario = $productos[$producto];
        $total_producto = $precio_unitario * $cantidad;
        echo "<tr>";
        echo "<td>" . htmlspecialchars($producto) . "</td>";
        echo "<td>$" . $precio_unitario . "</td>";
        echo "<td>" . $cantidad . "</td>";
        echo "<td>$" . $total_producto . "</td>";
        echo "</tr>";
    }
}

echo "</tbody>";
echo "<tfoot>";
echo "<tr><td colspan='3'>Subtotal</td><td>$" . $subtotal . "</td></tr>";
echo "<tr><td colspan='3'>Descuento</td><td>-$" . $descuento . "</td></tr>";
echo "<tr><td colspan='3'>Impuesto</td><td>+$" . $impuesto . "</td></tr>";
echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>$" . $total . "</strong></td></tr>";
echo "</tfoot>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
