<?php

namespace App\Livewire\Categorias;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoTablaBase;

class Tabla extends CatalogoTablaBase
{
    protected function config(): array
    {
        return CatalogoConfig::categorias();
    }
}
