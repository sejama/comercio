<?php

namespace App\Enum;

enum VentaFormaPago: string
{
    case EFECTIVO = 'EFECTIVO';
    case TARJETA = 'TARJETA';
    case TRANSFERENCIA = 'TRANSFERENCIA';
    case OTRO = 'OTRO';
}