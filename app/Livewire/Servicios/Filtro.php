<?php

namespace App\Livewire\Servicios;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoFiltroBase;

class Filtro extends CatalogoFiltroBase
{
    protected function config(): array
    {
        return CatalogoConfig::servicios();
    }
}
