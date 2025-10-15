<?php

namespace App\Enum;

enum VentaEstado: string
{
    case PENDIENTE = 'PENDIENTE';
    case PAGADA = 'PAGADA';
    case ANULADA = 'ANULADA';
}