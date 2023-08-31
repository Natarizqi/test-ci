<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function selectData($id = null)
    {
        if ($id) {
            return $this->db->query('CALL `select data kategori by id`("' . $id . '");')->getRow();
        } else {
            return $this->db->query('CALL `select data kategori all`')->getResult();
        }
    }

    public function selectDataSearch($search)
    {
        return $this->db->query('CALL `select data kategori search nama`("' . $search . '");')->getResult();
    }

    public function createData($nama)
    {
        $createdAt = date('Y-m-d H:i:s');

        return $this->db->query('CALL `create data kategori`("' . $nama . '", "' . $createdAt . '")');
    }

    public function updateData($id, $nama)
    {
        $updatedAt = date('Y-m-d H:i:s');

        return $this->db->query('CALL `edit data kategori`("' . $id . '", "' . $nama . '", "' . $updatedAt . '")');
    }

    public function deleteData($id)
    {
        return $this->db->query('CALL `delete data kategori`("' . $id . '")');
    }
}
