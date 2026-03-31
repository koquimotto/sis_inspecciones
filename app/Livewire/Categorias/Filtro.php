<?php

namespace App\Livewire\Categorias;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoFiltroBase;

class Filtro extends CatalogoFiltroBase
{
    protected function config(): array
    {
        return CatalogoConfig::categorias();
    }
}
