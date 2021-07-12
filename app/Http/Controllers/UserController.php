<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $user = new User();

        $user->nombre = $request->input('nombre');
        $user->correo = $request->input('correo');
        $user->pass = $request->input('pass');

        DB::select('CALL spInsertarUsuario(?, ?, ?)', [$user->nombre, $user->correo, $user->pass]);

        return json_encode([
            'message' => 'User created successfully!',
            'user_data' => $user
        ]);
    }
}
