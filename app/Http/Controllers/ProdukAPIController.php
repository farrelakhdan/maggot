<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File; 

class ProdukAPIController extends Controller
{
    public function index($UID_Produk) {
        $data = [
            'status' => 401,
            'success' => false,
            'message' => 'Unauthorized'
        ];
        $header = FacadesRequest::header('Authorization');

        if ($header) {
            $dt = explode(' ', $header);
            if ($dt[0] == 'Bearer') {
                $token = $dt[1];
                if ($token != "") {
                    $user = $token == "a8F5h72kL9dG2eX3mQ0pZ4rC6vN1jT7bY8wU5sV9xD2gK1oL0tR4qW3mF7yH2uI8zO5pJ1vM3nE0cR6aQ9lX5r";

                    if ($user) {
                        $data = Produk::all();
                        // foreach ($data1 as $dt) {
                        //     $dts = [
                        //         'id_user' => $user->ID_User,
                        //         'detak' => $dt->Detak,
                        //         'gula' => $dt->Gula,
                        //         'kolesterol' => $dt->Kolesterol,
                        //         'timestamp' => $dt->timestamp
                        //     ];
                        //     array_push($data, $dts);
                        // }

                        $data2 = [
                            'success' => true,
                            'status' => 200,
                            'message' => 'success',
                            'data' => $data
                        ];
                    }
                }
            }
        }
        return response()->json($data2);
    }

    public function getAll() {
        $data = [
            'status' => 401,
            'success' => false,
            'message' => 'Unauthorized'
        ];
        $header = FacadesRequest::header('Authorization');

        if ($header) {
            $dt = explode(' ', $header);
            if ($dt[0] == 'Bearer') {
                $token = $dt[1];
                if ($token != "") {
                    $user = $token == "a8F5h72kL9dG2eX3mQ0pZ4rC6vN1jT7bY8wU5sV9xD2gK1oL0tR4qW3mF7yH2uI8zO5pJ1vM3nE0cR6aQ9lX5r";

                    if ($user) {
                        $data = Produk::all();
                        // foreach ($data1 as $dt) {
                        //     $dts = [
                        //         'id_user' => $user->ID_User,
                        //         'detak' => $dt->Detak,
                        //         'gula' => $dt->Gula,
                        //         'kolesterol' => $dt->Kolesterol,
                        //         'timestamp' => $dt->timestamp
                        //     ];
                        //     array_push($data, $dts);
                        // }

                        $data = [
                            'success' => true,
                            'status' => 200,
                            'message' => 'success',
                            'data' => $data
                        ];
                    }
                }
            }
        }
        return response()->json($data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $data = [
            'status' => 401,
            'success' => false,
            'message' => 'Unauthorized'
        ];
        $header = FacadesRequest::header('Authorization');

        if ($header) {
            $dt = explode(' ', $header);
            if ($dt[0] == 'Bearer') {
                $token = $dt[1];
                if ($token != "") {
                    $user = User::where('remember_token', $token)->first();

                    if ($user) {
                        
                        $image_path = $request->file('image')->store('image', 'public');
                        if ($file = $request->hasFile('image')) {
                
                            $file = $request->file('image');
                            $destinationPath = public_path() . '/image';
                            $file->move($destinationPath, $image_path);
                        }
                        $user = Produk::firstOrCreate(['UID_Produk' => Str::orderedUuid(),
                                                            'Nama' => $request->nama,
                                                            'Deskripsi' => $request->desc,
                                                            'Gambar' => $image_path,
                                                            'Harga' => $request->harga,
                                                            'created_at' => Carbon::now(),
                                                            'updated_at' => carbon::now()]);
                        $data = [
                            'success' => true,
                            'status' => 200,
                            'message' => 'success',
                            'data' => $user
                            //'user' => $dts
                        ];
                    }
                }
            }
        }
        return response()->json($data);
    }

    public function update(Request $request, $UID_Produk) {
        $data = [
            'status' => 401,
            'success' => false,
            'message' => 'Unauthorized'
        ];
        $header = FacadesRequest::header('Authorization');

        if ($header) {
            $dt = explode(' ', $header);
            if ($dt[0] == 'Bearer') {
                $token = $dt[1];
                if ($token != "") {
                    $user = User::where('remember_token', $token)->first();

                    if ($user) {

                        $request->validate([
                            'nama' => 'nullable|string|max:255',
                            'desc' => 'nullable|string',
                            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            'harga' => 'nullable|numeric',
                        ]);

                        if ($request->hasFile('image')) {
                            
                            File::delete($product->Gambar);

                            $image_path = $request->file('image')->store('image', 'public');
                            $file = $request->file('image');
                            $destinationPath = public_path() . '/image';
                            $file->move($destinationPath, $image_path);

                            Produk::where('UID_Produk', $UID_Produk)->update(['Gambar' => $image_path]);                            
                        }

                        if ($request->has('nama')) {
                            Produk::where('UID_Produk', $UID_Produk)->update(['Nama' => $request->nama]);                            
                        }
                        if ($request->has('desc')) {
                            Produk::where('UID_Produk', $UID_Produk)->update(['Deskripsi' => $request->desc]);                         
                        }
                        if ($request->has('harga')) {
                            Produk::where('UID_Produk', $UID_Produk)->update(['Harga' => $request->harga]);
                        }

                        Produk::where('UID_Produk', $UID_Produk)->update(['updated_at' => Carbon::now()]);

                        $product = Produk::where('UID_Produk', $UID_Produk)->firstOrFail();
                        
                        $data = [
                            'success' => true,
                            'status' => 200,
                            'message' => 'success',
                            'data' => $product
                            //'user' => $dts
                        ];
                    }
                }
            }
        }
        return response()->json($data);
    }

    public function delete($UID_Produk) {
        $data = [
            'status' => 401,
            'success' => false,
            'message' => 'Unauthorized'
        ];
        $header = FacadesRequest::header('Authorization');

        if ($header) {
            $dt = explode(' ', $header);
            if ($dt[0] == 'Bearer') {
                $token = $dt[1];
                if ($token != "") {
                    $user = User::where('remember_token', $token)->first();

                    if ($user) {
                        
                        Produk::where('UID_Produk', $UID_Produk)->delete();

                        $data = [
                            'success' => true,
                            'status' => 200,
                            'message' => 'success',
                        ];
                    }
                }
            }
        }
        return response()->json($data);
    }
}
