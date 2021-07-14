<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $user = new User();

        $user->nombre = $request->nombre;
        $user->correo = $request->correo;
        $user->pass = $request->pass;

        DB::insert('CALL spInsertarUsuario(?, ?, ?)', [$user->nombre, $user->correo, $user->pass]);

        return response()->json([
            'message' => 'User created successfully!',
            'user_data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $user = new User();

        $user->correo = $request->correo;
        $user->pass = $request->pass;

        $response = DB::select('CALL login(?, ?)', [$user->correo, $user->pass]);

        if(sizeof($response) == 1)
        {
            return response()->json([
                'message' => 'User loged in successfully!',
                'user_data' => $response
            ]);
        }

        return response()->json([
            'error' => 'User does not exists.'
        ]);
    }
}