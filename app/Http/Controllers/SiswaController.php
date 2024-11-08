<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Siswa::all();
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal mengambil data siswa'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'umur' => 'required|integer'
        ]);

        try {
            $siswa = Siswa::create($validateData);

            return response()->json(
                $siswa,
                201
            );
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal menyimpan data'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            return Siswa::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Siswa tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $validateData = $request->validate([
                'nama' => 'sometimes|required|string|max:255',
                'kelas' => 'sometimes|required|string|max:10',
                'umur' => 'sometimes|required|integer'
            ]);

            $siswa->update($validateData);

            return response()->json($siswa);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal memperbarui data'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $siswa->delete();

            return response()->json([
                null,
                204
            ]);
        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Gagal menghapus data'
            ]);
        }
    }
}
