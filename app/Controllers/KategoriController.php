<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\HTTP\ResponseTrait;

class KategoriController extends BaseController
{
    use ResponseTrait;

    private $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel;
    }

    public function datatable()
    {
    }

    public function index()
    {
        $data['title'] = 'Kategori';
        $data['listKategori'] = $this->kategori->selectData();

        return view('contents/kategori/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $simpanData = $this->kategori->createData($data['namaKategori']);

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

        $kategori = $this->kategori->selectData($id);

        if ($kategori) {
            $dataPass = [
                'namaKategori' => $kategori->nama
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

        $updateData = $this->kategori->updateData($data['id'], $data['namaKategori']);

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
        $hapusData = $this->kategori->deleteData($id);

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

    public function listKategori()
    {
        $search = $this->request->getPost('search');
        $kategori = $this->kategori->selectDataSearch($search);

        if ($kategori) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'data ditemukan',
                'data' => $kategori,
                'code' => 200
            ], 200);
        } else {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'data tidak ditemukan',
                'data' => null,
                'code' => 404
            ], 404);
        }
    }
}
