<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\Puesto;

class PlantillaController extends Controller
{
    public function show_nuevo(Request $request)
    {
        $sucursales=Sucursal::where('estatus',1)->orderBy('pdv','asc')->get();
        $puestos=Puesto::where('estatus',1)->orderBy('nombre','asc')->get();
        return(view('plantilla.nuevo',['sucursales'=>$sucursales,'puestos'=>$puestos]));
    }
    public function save_nuevo(Request $request)
    {
        $request->validate([
            'user' => 'required|unique:users|numeric',
            'nombre' => 'required',
            'f_ingreso'=>'required|date_format:Y-m-d',
            'estatus'=>'required',
            'puesto' => 'required',
            'sucursal' => 'required',
            'email' => 'email|required|unique:users',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos'
        ]);
        $usuario=new User;      
        $usuario->user=$request->user;
        $usuario->name=$request->nombre;
        $usuario->puesto=$request->puesto;
        $usuario->sucursal=$request->sucursal;
        $usuario->email=$request->email;
        $usuario->f_ingreso=$request->f_ingreso;
        $usuario->estatus=$request->estatus;
        $usuario->attuid=$request->boolean('attuid');
        $usuario->vpn=$request->boolean('vpn');
        $usuario->avs=$request->boolean('avs');
        $usuario->pb=$request->boolean('pb');
        $usuario->noe=$request->boolean('noe');
        $usuario->asd=$request->boolean('asd');
        $usuario->password=Hash::make('cir');

        $usuario->save();
        return(back()->withStatus('Registro de '.$request->nombre.' creado con exito, numero empleado y usuario de sistema = '.$request->user.''));
    }
    public function show_update(Request $request)
    {
        $sucursales=Sucursal::where('estatus',1)->orderBy('pdv','asc')->get();
        $puestos=Puesto::where('estatus',1)->orderBy('nombre','asc')->get();
        return(view('plantilla.update',['sucursales'=>$sucursales,'puestos'=>$puestos]));
    }
    public function consulta(Request $request)
    {
        return(User::where('user',$request->user)->get()->first());
    }
    public function save_update(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'nombre' => 'required',
            'f_ingreso'=>'required|date_format:Y-m-d',
            'estatus'=>'required',
            'puesto' => 'required',
            'sucursal' => 'required',
            'email' => 'email|required',
        ],
        [
            'required' => 'Campo requerido.',
            'numeric'=>'Debe ser un numero',
            'email'=>'Indique una direccion de correo valida',
            'unique'=>'Valor duplicado en base de datos'
        ]);
        User::where('user', $request->user)
        ->update(['name' => $request->nombre,
                  'puesto' => $request->puesto,
                  'email' => $request->email,
                  'sucursal' => $request->sucursal,
                  'f_ingreso'=>$request->f_ingreso,
                  'estatus'=>$request->estatus,
                  'attuid'=>$request->boolean('attuid'),
                  'avs'=>$request->boolean('avs'),
                  'vpn'=>$request->boolean('vpn'),
                  'pb'=>$request->boolean('pb'),
                  'noe'=>$request->boolean('noe'),
                  'asd'=>$request->boolean('asd'),
                ]);

                return(back()->withStatus('La actualizacion del empleado '.$request->nombre.' fue realizada con exito'));
    }
}
