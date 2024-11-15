<?php

// Calcular el descuento
function calcular_descuento($total_compra) {
    if ($total_compra < 100) {
        return 0; //No hay descuento.
    } elseif ($total_compra >= 100 && $total_compra <= 500) {
        return $total_compra * 0.05;  //5% de descuento  
    } elseif ($total_compra >= 501 && $total_compra <= 1000) {
        return $total_compra * 0.10;  // 10% de descuento
    } else {
        return $total_compra * 0.15;  // 15% de descuento
    }
}

// Impuesto del 7% al subtotal
function aplicar_impuesto($subtotal) {
    return $subtotal * 0.07;  // 7% de impuesto
}

// Calcular el total a pagar
function calcular_total($subtotal, $descuento, $impuesto) {
    return $subtotal - $descuento + $impuesto;
}

