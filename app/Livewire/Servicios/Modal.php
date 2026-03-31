<?php

namespace App\Livewire\Servicios;

use App\Livewire\Catalogos\CatalogoConfig;
use App\Livewire\Catalogos\CatalogoModalBase;

class Modal extends CatalogoModalBase
{
    protected function config(): array
    {
        return CatalogoConfig::servicios();
    }
}
