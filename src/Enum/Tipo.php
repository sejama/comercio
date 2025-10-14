<?php

namespace App\Enum;

enum Tipo: string
{
    case VENTA = 'VENTA';
    case COMPRA = 'COMPRA';
    case AJUSTE = 'AJUSTE';
    case TRASLADO = 'TRASLADO';
    case DEVOLUCION = 'DEVOLUCION';
}