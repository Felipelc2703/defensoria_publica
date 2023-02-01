<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully'
        ];

        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        // Verificamos si un usuario esta eliminado(inactivo)
        $user_inactivo = User::where('clave', $request->usuario)->where('password', $request->password)->where('status', 0)->exists();
        if ($user_inactivo) {
            $response = [
                'status' => 'error',
                'success' => false,
                'message' => 'Usuario no encontrado'
            ];

            return response()->json($response);
        }

        $user = User::where('clave', $request->usuario)->where('password', $request->password)->where('status', 1)->first();

        // if (Auth::attempt(['clave' => $request->usuario, 'password' => $request->password])) {
        if ($user){
            $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json([
                "status" => "ok",
                "message" => "Usuario logueado con exito",
                "session" => $response
            ], 200);
        } else {
            $response = [
                'status' => 'error',
                'success' => false,
                'message' => 'Usuario y/o contraseña invalidos'
            ];

            return response()->json($response);
        }
    }
}
