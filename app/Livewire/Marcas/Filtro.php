<?php

namespace App\Livewire\Marcas;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoFiltroBase;

class Filtro extends CatalogoFiltroBase
{
    protected function config(): array
    {
        return CatalogoConfig::marcas();
    }
}
