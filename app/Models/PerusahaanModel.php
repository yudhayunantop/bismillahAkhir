<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'ID_PERUSAHAAN';
    protected $allowedFields = ['NAMA_PERUSAHAAN', 'ALAMAT', 'NO_TELP', 'LIMIT_PERUSAHAAN', 'HARGA_OVER', 'BIAYA_SEWA', 'ID_MESIN'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    public function getPerusahaan($id_perusahaan = false)
    {
        if ($id_perusahaan==false) {
            $sql="SELECT
            mesin_fotocopy.ID_MESIN, 
            mesin_fotocopy.NAMA_MESIN,
            perusahaan.ID_PERUSAHAAN,
            perusahaan.NAMA_PERUSAHAAN,
            perusahaan.ALAMAT,
            perusahaan.NO_TELP,
            perusahaan.LIMIT_PERUSAHAAN,
            perusahaan.HARGA_OVER,
            perusahaan.BIAYA_SEWA,
            perusahaan.ID_PERUSAHAAN
            FROM perusahaan LEFT JOIN mesin_fotocopy 
            ON perusahaan.ID_MESIN=mesin_fotocopy.ID_MESIN 
            WHERE mesin_fotocopy.DELETED_AT IS NULL AND perusahaan.DELETED_AT IS NULL
            GROUP BY perusahaan.ID_PERUSAHAAN";    
            return $this->query($sql)->getResultArray();
        }
        return $this->where(['ID_PERUSAHAAN' => $id_perusahaan])->first();
    }

    public function getDataTagihan($idPerusahaan)
    {
            $sql="SELECT
            ID_PERUSAHAAN,
            LIMIT_PERUSAHAAN,
            HARGA_OVER,
            BIAYA_SEWA
            FROM perusahaan 
            WHERE ID_PERUSAHAAN=$idPerusahaan"; 
            return $this->query($sql)->getResultArray();
    }

    public function getNamaPerusahaan($idPerusahaan)
    {
            $sql="SELECT NAMA_PERUSAHAAN FROM perusahaan WHERE ID_PERUSAHAAN=$idPerusahaan"; 
            return $this->query($sql)->getResultArray();
    }
}
