<?php

include 'utilidades_texto.php';

// Array con tres frases diferentes
$frases = [
    "El sol es el astro que permite iluminar.",
    "El air force one es uno de los aviones más icónicos del mundo.",
    "PHP es un lenguaje del lado del servidor."
];

// Pagina HTML
echo "<!DOCTYPE html>";
echo "<html lang='es'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Análisis de Texto</title>";
echo "</head>";
echo "<body>";
echo "<h1>Análisis de Texto</h1>";
echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>Frase</th>";
echo "<th>Número de Palabras</th>";
echo "<th>Número de Vocales</th>";
echo "<th>Frase Invertida</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Procesar las frases 
foreach ($frases as $frase) {
    // Funciones para obtener los resultados
    $numero_palabras = contar_palabras($frase);
    $numero_vocales = contar_vocales($frase);
    $frase_invertida = invertir_palabras($frase);

    // Tabla con los resultados
    echo "<tr>";
    echo "<td>$frase</td>";  
    echo "<td>$numero_palabras</td>";
    echo "<td>$numero_vocales</td>";
    echo "<td>$frase_invertida</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
