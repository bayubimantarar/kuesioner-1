<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Http\Requests\MatkulRequest;
use Illuminate\Http\Request;

class MatkulController extends Controller
{
	// Index
    public function index()
    {
    	$title = 'Data Mata Kuliah';

    	$mataKuliah = Matkul::orderBy('kode')->get();

    	return view('matkul.index', compact('title', 'mataKuliah'));
    }

    // Create Matkul View
    public function create()
    {
    	$title = 'Tambah Data Mata Kuliah';

    	$mataKuliah = new Matkul();

        $jurusan = Jurusan::all();

    	return view('matkul.create', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Create Matkul
    public function store(MatkulRequest $matkulReq)
    {
    	$mataKuliah = Matkul::create($matkulReq->only('kode', 'mata_kuliah'));

        $mataKuliah->jurusan()->sync($matkulReq->jurusan);

    	return redirect('/master/mata-kuliah')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    // Show Matkul
    public function show(Matkul $mataKuliah)
    {
    	$title = 'Mata Kuliah: ' . $mataKuliah->mata_kuliah;

        $kelas = Kelas::whereNotIn('id', $mataKuliah->studi->pluck('kelas_id'))->get();

        $dosen = Dosen::all();

    	return view('matkul.show', compact('title', 'mataKuliah', 'kelas', 'dosen'));
    }

    // Edit Matkul
    public function edit(Matkul $mataKuliah)
    {
    	$title = 'Ubah Data Mata Kuliah: ' . $mataKuliah->mata_kuliah;

        $jurusan = Jurusan::all();

    	return view('matkul.edit', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Update Matkul
    public function update(MatkulRequest $matkulReq, Matkul $mataKuliah)
    {
    	$mataKuliah->update($matkulReq->only('kode', 'mata_kuliah'));

        $mataKuliah->jurusan()->sync($matkulReq->jurusan);

    	return redirect('/master/mata-kuliah/' . $mataKuliah->id)->with('success', 'Data mata kuliah berhasil diubah.');
    }

    // Delete Matkul
    public function destroy(Matkul $mataKuliah)
    {
        $mataKuliah->jurusan()->detach();

        $mataKuliah->studi()->delete();

    	$mataKuliah->delete();

    	return redirect('/master/mata-kuliah')->with('success', 'Data mata kuliah berhasil dihapus.');
    }

    // Peserta Didik
    public function pesertaDidik(Matkul $mataKuliah)
    {
        $title = 'Kelola Peserta Didik';

        $jurusan = $mataKuliah->jurusan;

        return view('matkul.peserta', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Store Studi
    public function storeStudi(Matkul $mataKuliah, Request $request)
    {
        $request->request->add([
            'kelas_id' => $request->kelas,
            'dosen_id' => $request->dosen
        ]);

        $mataKuliah->studi()->create($request->only('kelas_id', 'dosen_id'));

        return redirect('/master/mata-kuliah/' . $mataKuliah->id)->with('success', 'Data kelas & dosen berhasil diubah.');
    }

    // Store Peserta Didik
    public function storePeserta(Matkul $mataKuliah, Request $request)
    {
        $mataKuliah->mahasiswa()->sync($request->mahasiswa);

        return redirect('/master/mata-kuliah/' . $mataKuliah->id . '/peserta-didik')->with('success', 'Data peserta didik berhasil diubah.');
    }

    // Get Jurusan API
    public function getJurusan(Matkul $mataKuliah)
    {
        $res = $mataKuliah->jurusan;

        return response()->json($res, 200);
    }
}