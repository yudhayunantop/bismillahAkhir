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
        // return $this->where('persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL')
        //             ->findAll($id);
    }

    public function getUpdate($id)
    {
        $sql = "SELECT * FROM `persewaan_detail` WHERE ID_PERSEWAAN_DETAIL=$id";
        return $this->query($sql)->getResultArray();
    }

    public function getDataRamal($id)
    {
        $sql = "SELECT 
                    CASE
                        WHEN LENGTH(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR)) >= 7 
                            THEN SUBSTR(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR),1,4)
                        ELSE SUBSTR(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR),1,3)
                    END AS tagihanFix
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
    
    // Data Full
    // SELECT JUMLAH_TAGIHAN
    //             FROM persewaan_detail, persewaan
    //             WHERE persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL
    //             AND persewaan.ID_PERUSAHAAN=$id

    // SELECT 
    //                 CASE
    //                     WHEN LENGTH(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR)) >= 7 
    //                         THEN SUBSTR(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR),1,4)
    //                     ELSE SUBSTR(CAST(persewaan_detail.JUMLAH_TAGIHAN as CHAR),1,3)
    //                 END AS tagihanFix
    //             FROM persewaan_detail, persewaan
    //             WHERE persewaan.ID_PERSEWAAN_DETAIL = persewaan_detail.ID_PERSEWAAN_DETAIL
    //             AND persewaan.ID_PERUSAHAAN=$id
}
