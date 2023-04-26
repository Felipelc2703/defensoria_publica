<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsuarios(){
        try {
            $user = Auth::user();

            if ($user->rol_id == 5) {
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('juzgado_id', '!=', null)->get();

                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                    $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                    $objectUsuario->rol_id = $usuario->rol_id;
                    $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                    $objectUsuario->juez_id = $usuario->juez->id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            } else {
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->get();
                 
                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    $objectUsuario->rol_id = $usuario->rol_id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            }

            return response()->json([
                "status" => "ok",
                "message" => "Usuarios obtenidos con éxito",
                "usuarios" => $array_usuario
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de usuarios",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function getUsuariosConsejeros(){
        try {
            $user = Auth::user();

            if ($user->rol_id == 7) {
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 4)->where('id', '!=', 27)->where('consejero_id', '!=', null)->get();

                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    // $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                    // $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                    $objectUsuario->rol_id = $usuario->rol_id;
                    // $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                    $nombre = $usuario->consejero->nombre;
                    $apellidop = $usuario->consejero->apellido_paterno;
                    $apellidom = $usuario->consejero->apellido_materno;
                    $objectUsuario->consejero = $nombre.' '.$apellidop.' '.$apellidom;
                    $objectUsuario->consejero_id = $usuario->consejero_id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            } 
            // else {
            //     $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 4)->where('id', '!=', 27)->where('consejero_id', '!=', null)->get();
                 
            //     $array_usuario = array();
            //     $cont = 1;
            //     foreach ($usuarios as $usuario) {
            //         $objectUsuario = new \stdClass();
            //         $objectUsuario->id = $usuario->id;
            //         $objectUsuario->numero_registro = $cont;
            //         $objectUsuario->nombre = $usuario->name;
            //         $objectUsuario->clave = $usuario->clave;
            //         $objectUsuario->contrasena = $usuario->password;
            //         $objectUsuario->email = $usuario->email;
            //         // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
            //         $objectUsuario->rol_id = $usuario->rol_id;
    
            //         array_push($array_usuario, $objectUsuario);
            //         $cont++;
            //     }
            // }

            return response()->json([
                "status" => "ok",
                "message" => "Usuarios obtenidos con éxito",
                "usuarios" => $array_usuario
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de usuarios",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    
    public function guardarNuevoUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $usuario = new User;
            $usuario->name = $request->nombre;
            $usuario->clave = $request->clave;
            $usuario->email = $request->email;
            $usuario->password = $request->contrasena;
            // $usuario->rol_id = $request->rol_id;
            /////////
            if($user->rol_id == 7){
                $usuario->rol_id = 6;
                $usuario->consejero_id = $request->consejero_id;
            }else{
                $usuario->rol_id = $request->rol_id;
                if ($request->centro_atencion) {
                    $usuario->centro_atencion_id = $request->centro_atencion;
                } else if ($request->juzgado_id) {
                    $usuario->juzgado_id = $request->juzgado_id;
                    $usuario->juez_id = $request->juez_id;
                }
            }
            ////////
            // if ($request->centro_atencion) {
            //     $usuario->centro_atencion_id = $request->centro_atencion;
            // } else if ($request->juzgado_id) {
            //     $usuario->juzgado_id = $request->juzgado_id;
            //     $usuario->juez_id = $request->juez_id;
            // }
            $usuario->save();


            // $user = Auth::user();
            if($user->rol_id == 7)
            {
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 4)->where('id', '!=', 27)->where('consejero_id', '!=', null)->get();

                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    // $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                    // $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                    $objectUsuario->rol_id = $usuario->rol_id;
                    // $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                    $nombre = $usuario->consejero->nombre;
                    $apellidop = $usuario->consejero->apellido_paterno;
                    $apellidom = $usuario->consejero->apellido_materno;
                    $objectUsuario->consejero = $nombre.' '.$apellidop.' '.$apellidom;
                    $objectUsuario->consejero_id = $usuario->consejero_id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            }
            else{
                if ($user->rol_id == 5) {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('juzgado_id', '!=', null)->get();
    
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                        $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                        $objectUsuario->rol_id = $usuario->rol_id;
                        $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                        $objectUsuario->juez_id = $usuario->juez->id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                } else {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->get();
                     
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->rol_id = $usuario->rol_id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                }
    
            }



           

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar al nuevo usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Usuario guardado con éxito.",
                "usuarios" => $array_usuario
            ], 200);
        }
    }

    public function actualizarUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $usuario = User::find($request->id);
            $usuario->name = $request->nombre;
            $usuario->clave = $request->clave;
            $usuario->email = $request->email;
            $usuario->password = $request->contrasena;
            if($user->rol_id == 7){
                $usuario->rol_id = 6;
                $usuario->consejero_id = $request->consejero_id;
            }
            else{
                $usuario->rol_id = $request->rol_id;
                if ($request->centro_atencion) {
                    $usuario->centro_atencion_id = $request->centro_atencion;
                } else if ($request->juzgado_id) {
                    $usuario->juzgado_id = $request->juzgado_id;
                    $usuario->juez_id = $request->juez_id;
                }
            }
           
            $usuario->save();

            
            // $user = Auth::user();
            if($user->rol_id == 7){
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 4)->where('id', '!=', 27)->where('consejero_id', '!=', null)->get();

                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    // $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                    // $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                    $objectUsuario->rol_id = $usuario->rol_id;
                    // $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                    $nombre = $usuario->consejero->nombre;
                    $apellidop = $usuario->consejero->apellido_paterno;
                    $apellidom = $usuario->consejero->apellido_materno;
                    $objectUsuario->consejero = $nombre.' '.$apellidop.' '.$apellidom;
                    $objectUsuario->consejero_id = $usuario->consejero_id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            }
            else{
                if ($user->rol_id == 5) {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('juzgado_id', '!=', null)->get();
    
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                        $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                        $objectUsuario->rol_id = $usuario->rol_id;
                        $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                        $objectUsuario->juez_id = $usuario->juez->id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                } else {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->get();
                     
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->rol_id = $usuario->rol_id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                }
            }
                       
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Usuario actualizado con éxito.",
                "usuarios" => $array_usuario
            ], 200);
        }
    }
    
    public function eliminarUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $Usuario = User::find($request->id);
            $Usuario->status = false;
            $Usuario->save();

            $user = Auth::user();

            if($user->rol_id == 7){
                $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 4)->where('id', '!=', 27)->where('consejero_id', '!=', null)->get();

                $array_usuario = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->nombre = $usuario->name;
                    $objectUsuario->clave = $usuario->clave;
                    $objectUsuario->contrasena = $usuario->password;
                    $objectUsuario->email = $usuario->email;
                    // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                    // $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                    // $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                    $objectUsuario->rol_id = $usuario->rol_id;
                    // $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                    $nombre = $usuario->consejero->nombre;
                    $apellidop = $usuario->consejero->apellido_paterno;
                    $apellidom = $usuario->consejero->apellido_materno;
                    $objectUsuario->consejero = $nombre.' '.$apellidop.' '.$apellidom;
                    $objectUsuario->consejero_id = $usuario->consejero_id;
    
                    array_push($array_usuario, $objectUsuario);
                    $cont++;
                }
            }
            else{
                if ($user->rol_id == 5) {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('juzgado_id', '!=', null)->get();
    
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        // $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->juzgado = $usuario->juez->juzgado->nombre;
                        $objectUsuario->juez = $usuario->juez->nombre . ' ' . $usuario->juez->apellido_paterno . ' ' . $usuario->juez->apellido_materno;
                        $objectUsuario->rol_id = $usuario->rol_id;
                        $objectUsuario->juzgado_id = $usuario->juez->juzgado->id;
                        $objectUsuario->juez_id = $usuario->juez->id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                } else {
                    $usuarios = User::where('status', 1)->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->get();
                     
                    $array_usuario = array();
                    $cont = 1;
                    foreach ($usuarios as $usuario) {
                        $objectUsuario = new \stdClass();
                        $objectUsuario->id = $usuario->id;
                        $objectUsuario->numero_registro = $cont;
                        $objectUsuario->nombre = $usuario->name;
                        $objectUsuario->clave = $usuario->clave;
                        $objectUsuario->contrasena = $usuario->password;
                        $objectUsuario->email = $usuario->email;
                        $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                        $objectUsuario->rol_id = $usuario->rol_id;
        
                        array_push($array_usuario, $objectUsuario);
                        $cont++;
                    }
                }
            }

           

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Usuario eliminado con éxito.",
                "usuarios" => $array_usuario
            ], 200);
        }
    }
}
