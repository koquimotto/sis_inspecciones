<?php

namespace App\Livewire\Servicios;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoTablaBase;

class Tabla extends CatalogoTablaBase
{
    protected function config(): array
    {
        return CatalogoConfig::servicios();
    }
}
