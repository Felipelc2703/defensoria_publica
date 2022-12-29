<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public fucntion getUsuarios
    public function store(Request $request)
    {
        try {
            $exito = false;

            DB::beginTransaction();

            $usuario = new User;
            $usuario->name  = $request->nombre;
            $usuario->clave = $request->clave;
            $usuario->password = bcrypt($request->contrasena);
            $usuario->centro_atencion_id = $request->centro_atencion;
            $usuario->rol = $request->rol;
            $usuario->save();

            DB::commit();
            $exito = true;

        
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al iniciar el amparo.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Usuario registrado con exito",
                "usuario" => $usuario
            ], 200);
        }
    }
}
