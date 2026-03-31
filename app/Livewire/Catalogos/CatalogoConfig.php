<?php

namespace App\Livewire\Catalogos;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Servicio;
use App\Models\Tipo;

class CatalogoConfig
{
    public static function servicios(): array
    {
        return [
            'module' => 'servicios',
            'title' => 'Servicios',
            'singular' => 'servicio',
            'description' => 'Catalogo base de servicios ofrecidos por las empresas.',
            'model' => Servicio::class,
            'name_field' => 'descripcion',
            'modal_width' => 'max-w-md',
            'search_fields' => ['descripcion'],
            'fields' => [
                [
                    'name' => 'descripcion',
                    'label' => 'Descripcion',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Ej: Inspeccion operativa',
                    'rules' => ['string', 'max:120'],
                ],
            ],
            'events' => [
                'filter' => 'servicios-filtrar',
                'refresh' => 'servicios:refresh',
                'open_modal' => 'servicios-modal:open',
                'delete' => 'servicios:confirmar-eliminar',
            ],
        ];
    }

    public static function tipos(): array
    {
        return [
            'module' => 'tipos',
            'title' => 'Tipos',
            'singular' => 'tipo',
            'description' => 'Tipos generales de equipo o vehiculo para la inspeccion.',
            'model' => Tipo::class,
            'name_field' => 'tipo',
            'modal_width' => 'max-w-md',
            'search_fields' => ['tipo'],
            'fields' => [
                [
                    'name' => 'tipo',
                    'label' => 'Tipo',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Ej: Camioneta',
                    'rules' => ['string', 'max:255'],
                ],
            ],
            'events' => [
                'filter' => 'tipos-filtrar',
                'refresh' => 'tipos:refresh',
                'open_modal' => 'tipos-modal:open',
                'delete' => 'tipos:confirmar-eliminar',
            ],
        ];
    }

    public static function marcas(): array
    {
        return [
            'module' => 'marcas',
            'title' => 'Marcas',
            'singular' => 'marca',
            'description' => 'Marcas homologadas para equipos y vehiculos inspeccionados.',
            'model' => Marca::class,
            'name_field' => 'marca',
            'modal_width' => 'max-w-xl',
            'search_fields' => ['codigo', 'marca'],
            'fields' => [
                [
                    'name' => 'codigo',
                    'label' => 'Codigo',
                    'type' => 'text',
                    'required' => false,
                    'placeholder' => 'Ej: TOY',
                    'rules' => ['string', 'max:255'],
                ],
                [
                    'name' => 'marca',
                    'label' => 'Marca',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Ej: Toyota',
                    'rules' => ['string', 'max:255'],
                ],
            ],
            'events' => [
                'filter' => 'marcas-filtrar',
                'refresh' => 'marcas:refresh',
                'open_modal' => 'marcas-modal:open',
                'delete' => 'marcas:confirmar-eliminar',
            ],
        ];
    }

    public static function categorias(): array
    {
        return [
            'module' => 'categorias',
            'title' => 'Categorias',
            'singular' => 'categoria',
            'description' => 'Categorias de equipo o vehiculo usadas para filtrar preguntas.',
            'model' => Categoria::class,
            'name_field' => 'categoria',
            'modal_width' => 'max-w-xl',
            'search_fields' => ['codigo', 'categoria'],
            'fields' => [
                [
                    'name' => 'codigo',
                    'label' => 'Codigo',
                    'type' => 'text',
                    'required' => false,
                    'placeholder' => 'Ej: VEH-PIC',
                    'rules' => ['string', 'max:255'],
                ],
                [
                    'name' => 'categoria',
                    'label' => 'Categoria',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Ej: Vehiculo - Pickup',
                    'rules' => ['string', 'max:255'],
                ],
            ],
            'events' => [
                'filter' => 'categorias-filtrar',
                'refresh' => 'categorias:refresh',
                'open_modal' => 'categorias-modal:open',
                'delete' => 'categorias:confirmar-eliminar',
            ],
        ];
    }

    public static function modelos(): array
    {
        return [
            'module' => 'modelos',
            'title' => 'Modelos',
            'singular' => 'modelo',
            'description' => 'Modelos homologados para el parque de equipos y vehiculos.',
            'model' => Modelo::class,
            'name_field' => 'modelo',
            'modal_width' => 'max-w-xl',
            'search_fields' => ['modelos', 'modelo'],
            'fields' => [
                [
                    'name' => 'modelos',
                    'label' => 'Codigo',
                    'type' => 'text',
                    'required' => false,
                    'placeholder' => 'Ej: HILUX',
                    'rules' => ['string', 'max:255'],
                ],
                [
                    'name' => 'modelo',
                    'label' => 'Modelo',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Ej: Hilux',
                    'rules' => ['string', 'max:255'],
                ],
            ],
            'events' => [
                'filter' => 'modelos-filtrar',
                'refresh' => 'modelos:refresh',
                'open_modal' => 'modelos-modal:open',
                'delete' => 'modelos:confirmar-eliminar',
            ],
        ];
    }
}



