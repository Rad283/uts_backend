<?php

namespace App\Http\Controllers;

use App\Models\patients;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientsController extends Controller
{
    /**
     * menampilkan list semua pasien
     */
    public function index(patients $patients)
    {

        $getPatients = $patients->all();

        // jika data pasien tidak kosong
        if ($getPatients->isNotEmpty()) {

            $data = [
                "message" => "Index | menampilkan semua data pasien",
                "data" => $getPatients
            ];

            // mengirim respon berhasil
            return response()->json($data, 200);
        }

        // jika data pasien kosong
        else {
            $data = [
                'message' => "Index | data pasien kosong"
            ];

            return response()->json($data, 404);
        }
    }


    /**
     * Menambahkan data pasien
     */
    public function store(Request $request)
    {
        // memvalidasi inputan 
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'status' => [
                'required', Rule::in(["positive", "recovered", "dead"])
            ],
            'in_date_at' => 'required|date',
            'out_date_at' => 'required|date'
        ]);

        // membuat data pasien dari data yang sudah divalidasi
        patients::create($validated);

        $data = [
            'message' => "Store | Resource berhasil ditambahkan",
            'data' => $validated
        ];
        // mengirim respon 201 berhasil dan data yang telah dibuat
        return response()->json($data, 201);
    }

    /**
     *menampilkan detail dari pasien
     */
    public function show(patients $patients, $id)
    {
        // mencari data pasien berdasarkan id
        $getPatients = patients::find($id);

        // jika data pasien ditemukan
        if ($getPatients) {

            $data = [
                'message' => "Show | detail dari pasien dengan id: $id",
                "data" => $getPatients
            ];

            return response()->json($data, 200);
        }

        // jika data pasien tidak ditemukan
        else {
            $data = [
                "message" => "Show | Data Not found"
            ];

            return response()->json($data, 404);
        }
    }



    /**
     * Mengupdate data pasien dari id
     */
    public function update(Request $request, patients $patients, $id)
    {
        // mencari data pasien berdasarkan id
        $getPatients = patients::find($id);

        // jika ditemukan
        if ($getPatients) {

            // memvalidasi inputan 
            $validated = $request->validate([
                'name' => 'string',
                'phone' => 'string',
                'address' => 'string',
                'status' => [
                    '', Rule::in(["positive", "recovered", "dead"])
                ],
                'in_date_at' => 'date',
                'out_date_at' => 'date'
            ]);

            // mengupdate data pasien. jika ada field yang kosong, maka diisi dengan data lama
            $getPatients->update([
                'name' => $validated['name'] ?? $getPatients->name,
                'phone' => $validated['phone'] ?? $getPatients->phone,
                'address' => $validated['address'] ?? $getPatients->address,
                'status' => $validated['status'] ?? $getPatients->status,
                'in_date_at' => $validated['in_date_at'] ?? $getPatients->in_date_at,
                'out_date_at' => $validated['out_date_at'] ?? $getPatients->out_date_at,
            ]);

            $data = [
                'message' => "Update | berhasil mengupdate data",
                "data" => $getPatients
            ];

            return response()->json($data, 200);
        }

        // jika pasien tidak ditemukan
        else {
            $data = [
                "message" => "Update | Data not found"
            ];

            return response()->json($data, 404);
        }
    }

    /**
     * menghapus data pasien.
     */
    public function destroy(patients $patients, $id)
    {
        // mencari data berdasarkan id
        $getPatients = patients::find($id);

        // jika data ditemukan
        if ($getPatients) {

            // menghapus data pasien
            $getPatients->delete();

            $data = [
                "message" => "destroy | Data id: $id Berhasil dihapus"
            ];

            return response()->json($data, 200);
        }

        // jika data tidak ditemukan
        else {
            $data = [
                "message" => "Destroy | Data not Found!"
            ];

            return response()->json($data, 404);
        }
    }
}
