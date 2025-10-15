<?php

namespace App\Enum;

enum Tipo: string
{
    case ENTRADA = 'ENTRADA';
    case SALIDA = 'SALIDA';
    case AJUSTE = 'AJUSTE';
}