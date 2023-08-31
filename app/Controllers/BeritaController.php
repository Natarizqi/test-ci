<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use CodeIgniter\HTTP\ResponseTrait;

class BeritaController extends BaseController
{
    use ResponseTrait;

    private $berita;

    public function __construct()
    {
        $this->berita = new BeritaModel;
    }

    public function datatable()
    {
    }

    public function index()
    {
        $data['title'] = 'Berita';
        $data['listBerita'] = $this->berita->selectData();

        return view('contents/berita/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $simpanData = $this->berita->createData($data['judulBerita'], $data['deskripsi'], $data['kategoriId']);

        if ($simpanData) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'berhasil simpan data',
                'data' => $simpanData
            ], 200);
        } else {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'gagal simpan data',
                'data' => null
            ], 400);
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');

        $berita = $this->berita->selectData($id);

        if ($berita) {
            $dataPass = [
                'judulBerita' => $berita->judul,
                'deskripsi' => $berita->deskripsi,
                'kategoriId' => $berita->kategori_id,
                'namaKategori' => $berita->nama_kategori
            ];

            return $this->response->setJSON([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $dataPass
            ], 200);
        } else {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'data tidak ditemukan',
                'data' => null
            ], 404);
        }
    }

    public function update()
    {
        $data = $this->request->getPost();

        $updateData = $this->berita->updateData($data['id'], $data['judulBerita'], $data['deskripsi'], $data['kategoriId']);

        if ($updateData) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'berhasil update data',
                'data' => $updateData
            ], 200);
        } else {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'gagal update data',
                'data' => null
            ], 400);
        }
    }

    public function destroy()
    {
        $id = $this->request->getPost('id');
        $hapusData = $this->berita->deleteData($id);

        if ($hapusData) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'berhasil hapus data',
                'data' => $hapusData
            ], 200);
        } else {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'gagal hapus data',
                'data' => null
            ], 400);
        }
    }
}
