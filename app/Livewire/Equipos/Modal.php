<?php

namespace App\Livewire\Equipos;

use Livewire\Component;
use Livewire\Attributes\On;

class Modal extends Component
{
    public bool     $modal        = false;
    public string   $titleModal   = 'Nuevo Usuario';
    public array    $state        = [];
    
    public int $editingId = 1;
    
    public function mount(){}
    
    #[On('equipos-modal:open')]
    public function handleOpen(int $id=0, string $title){
        
        $this->titleModal   = $title;
        $this->modal        = true;
    }
    
    public function initialState(){
        $state = [
            'id'            => null,
            'empresa_id'    => null,
            'empresa_id'    => null,
            'name'          => null,
            'email'         => null,
            'username'      => null,
            'password'      => null,
            'estado'        => null,
            'avatar'        => null,
            
        ];
    }
    
    public function render()
    {
        return view('livewire.equipos.modal');
    }
}
