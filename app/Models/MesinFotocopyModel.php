<?php

namespace App\Models;

use CodeIgniter\Model;

class MesinFotocopyModel extends Model
{
    protected $table = 'mesin_fotocopy';
    protected $primaryKey = 'id_mesin';
    protected $allowedFields = ['nama_mesin', 'stok_mesin'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getMesinFotocopy($id_mesin = false)
    {
        if ($id_mesin==false) {
            $sql="SELECT mesin_fotocopy.NAMA_MESIN, 
                            mesin_fotocopy.ID_MESIN, 
                            mesin_fotocopy.STOK_MESIN, 
                            count(perusahaan.ID_MESIN) as JUMLAH 
                FROM mesin_fotocopy LEFT JOIN perusahaan 
                ON perusahaan.ID_MESIN=mesin_fotocopy.ID_MESIN 
                WHERE mesin_fotocopy.DELETED_AT IS NULL
                GROUP BY mesin_fotocopy.id_mesin";    
            return $this->query($sql)->getResultArray();

            // return $this
            // ->from('persewaan')
            // ->selectCount('persewaan.ID_MESIN')
            // ->where('persewaan.ID_MESIN=mesin_fotocopy.ID_MESIN ')
            // ->groupBy("mesin_fotocopy.id_mesin")
            // ->findAll();
        }
        return $this->where(['id_mesin' => $id_mesin])->first();
    }

    // public function getMesinFotocopy($id_mesin = false)
    // {
    //     if ($id_mesin==false) {
    //         $sql="SELECT * AS Jumlah FROM persewaan GROUP BY id_mesin";    
    //         return $this->query($sql)->getResultArray();
    //     }
    //     return $this->where(['id_mesin' => $id_mesin])->first();
    // }

}
