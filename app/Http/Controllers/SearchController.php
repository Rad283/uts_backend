<?php

namespace App\Http\Controllers;

use App\Models\patients;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    // untuk mencari data berdasarkan nama pasien
    public function search(patients $patients, string $name)
    {
        // mencari nama pasien
        $getPatients = patients::where('name', $name)->get();

        // jika data ditemukan
        if ($getPatients->isNotEmpty()) {

            $data = [
                'message' => "search | berhasil menemukan nama: $name",
                'data' => $getPatients
            ];

            return response()->json($data, 200);
        }

        // jika data tidak ditemukan
        else {
            $data = [
                'message' => "search | gagal menemukan nama: $name"
            ];

            return response()->json($data, 404);
        }
    }


    // mendapatkan pasien berdasarkan status
    public function status(patients $patients, string $status)
    {
        // mencari data pasien 
        $getPatients = patients::where('status', $status)->get();

        // jika data ditemukan
        if ($getPatients->isNotEmpty()) {

            $data = [
                'message' => "status $status| menampilkan pasien dengan status $status",
                'data' => $getPatients
            ];

            return response()->json($data, 200);
        }

        // jika data tidak ditemukan
        else {
            $data = [
                'message' => "status $status | status not found"
            ];

            return response()->json($data, 404);
        }
    }
}
