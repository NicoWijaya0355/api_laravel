<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index() {
        $order = order::all(); // mengambil semua data order

        if (count($order) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'order' => $order
            ], 200);
        } // return data semua order dalam bentuk json

        return response([
            'message' => 'Empty',
            'order' => null
        ], 400); // return message data order kosong
    }

    // method untuk menampilkan 1 data order (search)
    public function show($id) {
        $order = order::find($id); // mencari data order berdasarkan id

        if(!is_null($order)) {
            return response([
                'message' => 'Retrieve Order Success',
                'order' => $order
            ], 200);
        } // return data order yang ditemukan dalam bentuk json

        return response([
            'message' => 'Order Not Found',
            'order' => null
        ], 404); // return message saat data order tidak ditemukan
    }

    // method untuk menambah 1 data order baru (create)
    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required|max:60',
            'telepon' => 'required|numeric',
            'alamat' => 'required',
            'total' => 'required|numeric'
        ]); // membuat rule validasi input

        if ($validate->fails()) 
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $order = order::create($storeData);
        return response([
            'message' => 'Pemesanan Berhasil',
            'order' => $order
        ], 200); // return data order baru dalam bentuk json
    }
}
