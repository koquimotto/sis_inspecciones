<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    public function listaUsuarios(){ return User::where('estado',1)->get(); }
}
