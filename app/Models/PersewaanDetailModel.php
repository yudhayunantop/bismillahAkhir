<?php

namespace App\Models;

use CodeIgniter\Model;

class PersewaanDetailModel extends Model
{
    protected $table = 'persewaan_detail';
    protected $primaryKey = 'ID_PERSEWAAN_DETAIL';
    protected $allowedFields = ['TANGGAL_TAGIH', 
                                'TANGGAL_BAYAR', 
                                'JUMLAH_TAGIHAN',
                                'COUNTER_BULAN_LALU', 
                                'COUNTER_BULAN_INI', 
                                'SELISIH_COUNTER', 
                                'KERTAS_RUSAK', 
                                'NETTO', 
                                'KELEBIHAN_PEMAKAIAN'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'CREATED_AT';
    protected $updatedField  = 'UPDATED_AT';
    protected $deletedField = 'DELETED_AT';
    
    public function getPersewaanDetail($id)
    {
        $sql = "SELECT persewaan_detail.ID_PERSEWAAN_DETAIL,
                        persewaan_detail.TANGGAL_TAGIH, 
                        persewaan_detail.TANGGAL_BAYAR, 
                        persewaan_detail.JUMLAH_TAGIHAN,
                        persewaan_detail.COUNTER_BULAN_LALU,
                        persewaan_detail.COUNTER_BULAN_INI,
                        persewaan_detail.SELISIH_COUNTER,
                        persewaan_detail.KERTAS_RUSAK,
                        persewaan_detail.NETTO,
                        persewaan_detail.KELEBIHAN_PEMAKAIAN
                FROM persewaan_detail, persewaan
                WHERE persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL
                AND persewaan.ID_PERUSAHAAN=$id 
                AND persewaan_detail.DELETED_AT IS NULL
                GROUP BY persewaan_detail.ID_PERSEWAAN_DETAIL";
        return $this->query($sql)->getResultArray();
    }

    public function getUpdate($id)
    {
        $sql = "SELECT * FROM `persewaan_detail` WHERE ID_PERSEWAAN_DETAIL=$id";
        return $this->query($sql)->getResultArray();
    }

    public function getDataRamal($id)
    {
        $sql = "SELECT 
                persewaan_detail.JUMLAH_TAGIHAN
                FROM persewaan_detail, persewaan
                WHERE persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL 
                AND persewaan_detail.DELETED_AT IS null
                AND persewaan.ID_PERUSAHAAN=$id";
        return $this->query($sql)->getResultArray();
    }

    public function getJumlahData($id)
    {
        $sql = "SELECT 
                COUNT(persewaan_detail.JUMLAH_TAGIHAN) AS BanyakTransaksi
                FROM persewaan_detail, persewaan
                WHERE persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL
                AND persewaan.ID_PERUSAHAAN=$id";
        return $this->query($sql)->getResultArray();
    }

    public function getJumlahTagihan($id)
    {
        $sql = "SELECT `JUMLAH_TAGIHAN` FROM `persewaan_detail` WHERE `ID_PERSEWAAN_DETAIL` = $id";
        return $this->query($sql)->getResultArray();
    }

    public function getPersewaan($id)
    {
        $sql = "SELECT * FROM `persewaan_detail` WHERE `ID_PERSEWAAN_DETAIL` = $id";
        return $this->query($sql)->getResultArray();
    }

    public function cekTanggalDuplikat($tanggal, $id)
    {
        $sql = "SELECT COUNT(persewaan_detail.TANGGAL_TAGIH) AS JumlahTanggal
        FROM persewaan_detail, persewaan 
        WHERE 
        persewaan_detail.TANGGAL_TAGIH = $tanggal AND 
        persewaan.ID_PERSEWAAN_DETAIL=persewaan_detail.ID_PERSEWAAN_DETAIL AND
        persewaan.ID_PERUSAHAAN = $id";
        return $this->query($sql)->getResultArray();
    }

    public function getTanggalTerakhir($id)
    {
        $sql = " SELECT MAX(persewaan_detail.TANGGAL_TAGIH) AS tanggalTerakhir
        FROM persewaan_detail, persewaan 
        WHERE persewaan.ID_PERSEWAAN_DETAIL=persewaan_detail.ID_PERSEWAAN_DETAIL AND
        persewaan.ID_PERUSAHAAN=$id AND
        persewaan_detail.DELETED_AT IS NULL";
        
        return $this->query($sql)->getResultArray();
    }

}
