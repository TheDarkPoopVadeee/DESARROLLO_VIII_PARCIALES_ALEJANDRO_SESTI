<?php

function contar_palabras($texto) {
    $palabras = explode(' ', $texto);
    $contador = 0;
    foreach ($palabras as $palabra) {
        // Verifica que la palabra no esté vacía
        if (trim($palabra) !== '') {
            $contador++;
        }
    }
    return $contador;
}

function contar_vocales($texto) {
    $texto = strtolower($texto); // Convertir a minúsculas
    $vocales = ['a', 'e', 'i', 'o', 'u'];
    $contador = 0;
    
    // Recorre cada carácter en el texto
    for ($i = 0; $i < strlen($texto); $i++) {
        if (in_array($texto[$i], $vocales)) {
            $contador++;
        }
    }
    
    return $contador;
}


function invertir_palabras($texto) {
    $palabras = explode(' ', $texto);
    $resultado = '';
    
    // Recorre el array de palabras desde el final hasta el principio
    for ($i = count($palabras) - 1; $i >= 0; $i--) {
        if (trim($palabras[$i]) !== '') {
            $resultado .= $palabras[$i] . ' ';
        }
    }
    
    // Eliminar el último espacio extra
    return trim($resultado);
}

?>
