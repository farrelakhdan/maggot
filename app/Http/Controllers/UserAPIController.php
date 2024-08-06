<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\DB;

class UserAPIController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $user = User::where('Username', $request->username)->where('Password', $request->password)->first();
        if ($user) {
            $token = Str::random(100);

            $kkd = DB::select("SELECT * FROM user WHERE Username = ? AND Password = ?", [$request->username, $request->password]);
            DB::select("UPDATE user SET remember_token = ? WHERE ID_User = ?", [$token, $user->ID_User]);
            $dt = [
                'id' => $user->ID_User,
                'nama' => $user->Nama,
            ];
            $datatoken = [
                'access_token' => $token,
                'token_type' => 'Bearer',

                'success' => true,
                'statusCode' => 200,
                'message' => 'success',
                'login' => $dt
            ];
        } else {
            $datatoken = [
                'statusCode' => 401,
                'success' => false,
                'message' => 'Unauthorized'
            ];
        }
        return response()->json($datatoken);
    }
}
