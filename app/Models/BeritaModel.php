<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function selectData($id = null)
    {
        if ($id == null) {
            return $this->db->query('CALL `select all data`()')->getResult();
        } else {
            return $this->db->query('CALL `select data by id`("' . $id . '")')->getRow();
        }
    }

    public function createData($judul, $deskripsi, $kategoriId)
    {
        $createdAt = date('Y-m-d H:i:s');

        return $this->db->query('CALL `create data`("' . $judul . '", "' . $deskripsi . '", "' . $kategoriId . '", "' . $createdAt . '")');
    }

    public function updateData($id, $judul, $deskripsi, $kategoriId)
    {
        $updatedAt = date('Y-m-d H:i:s');

        return $this->db->query('CALL `edit data`("' . $id . '", "' . $judul . '", "' . $deskripsi . '", "' . $kategoriId . '", "' . $updatedAt . '")');
    }

    public function deleteData($id)
    {
        return $this->db->query('CALL `delete data`("' . $id . '")');
    }
}
