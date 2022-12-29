<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsuarios(){
        try {
            $usuarios = User::where('status', 1)->get();
             
            $array_usuario = array();
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->nombre = $usuario->name;
                $objectUsuario->clave = $usuario->clave;
                $objectUsuario->contrasena = $usuario->password;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                $objectUsuario->rol_id = $usuario->rol_id;
                array_push($array_usuario, $objectUsuario);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Usuarios obtenidos con exito",
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
    
    public function store(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $usuario = new User;
            $usuario->name = $request->nombre;
            $usuario->clave = $request->clave;
            $usuario->email = $request->email;
            $usuario->password = $request->contrasena;
            $usuario->rol_id = $request->rol_id;
            $usuario->centro_atencion_id = $request->centro_atencion;
            $usuario->save();


            $usuarios = User::where('status', 1)->get();
             
            $array_usuario = array();
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->nombre = $usuario->name;
                $objectUsuario->clave = $usuario->clave;
                $objectUsuario->contrasena = $usuario->password;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                $objectUsuario->rol_id = $usuario->rol_id;
                array_push($array_usuario, $objectUsuario);
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
                "message" => "Nuevo Usuario guardado con exito.",
                "usuarios" => $array_usuario
            ], 200);
        }
    }

    public function actualizarUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $usuario = User::find($request->id);
            $usuario->name = $request->nombre;
            $usuario->clave = $request->clave;
            $usuario->email = $request->email;
            $usuario->password = $request->contrasena;
            $usuario->rol_id = $request->rol_id;
            $usuario->centro_atencion_id = $request->centro_atencion;
            $usuario->save();

            
            $usuarios = User::where('status', 1)->get();

            $array_usuario = array();
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->nombre = $usuario->name;
                $objectUsuario->clave = $usuario->clave;
                $objectUsuario->contrasena = $usuario->password;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                $objectUsuario->rol_id = $usuario->rol_id;
                array_push($array_usuario, $objectUsuario);
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
                "message" => "Usuario actualizado con exito.",
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

            $usuarios = User::where('status', 1)->get();

            $array_usuario = array();
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->nombre = $usuario->name;
                $objectUsuario->clave = $usuario->clave;
                $objectUsuario->contrasena = $usuario->password;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->centro_atencion = $usuario->centroAtencion->nombre;
                $objectUsuario->rol_id = $usuario->rol_id;
                array_push($array_usuario, $objectUsuario);
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
                "message" => "Usuario eliminado con exito.",
                "usuarios" => $array_usuario
            ], 200);
        }
    }
}
