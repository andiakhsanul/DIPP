<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestFormController extends Controller
{
    public function show()
    {
        return view('test-form');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'universitas' => 'required|string|max:255',
            'nidn' => 'required|numeric',
            'nomor_hp' => 'required|numeric',
            'email' => 'required|email',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'npwp_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'surat_tugas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'required|string'
        ]);

        $uploads = [];

        if ($request->hasFile('bukti_transfer')) {
            $uploads['bukti_transfer'] = $request->file('bukti_transfer')->store('public/uploads');
        }
        if ($request->hasFile('npwp_ktp')) {
            $uploads['npwp_ktp'] = $request->file('npwp_ktp')->store('public/uploads');
        }
        if ($request->hasFile('surat_tugas')) {
            $uploads['surat_tugas'] = $request->file('surat_tugas')->store('public/uploads');
        }

        // You can store the data to database here. For now we'll just flash success.
        return redirect()->route('test.show')->with('success', 'Form berhasil dikirim!');
    }
}
