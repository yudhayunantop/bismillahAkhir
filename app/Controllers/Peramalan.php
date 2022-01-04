<?php 

namespace App\Controllers;

header("Access-Control-Allow-Origin: *");

class Peramalan extends BaseController
{
    public function index()
    {
        //Memanggil Model dari BaseController
        $perusahaan = $this->perusahaanModel->getPerusahaan();
        // $perusahaan = $this->perusahaanModel->getPerusahaan();
        // dd($perusahaan);

        $data = [
            'title' => 'Peramalan',
            'perusahaan' => $perusahaan
        ];

        return view('peramalan/data', $data);
        
    }

    public function ramal($id)
    {
        // Cek Jumlah data
        $jumlahData =  $this->persewaanDetailModel->getJumlahData($id);
        // dd($jumlahData);
        if ($jumlahData[0]['BanyakTransaksi'] < 24) {

            $_SESSION['pesan'] = 'Peramalan gagal! jumlah data yang dimiliki ('.$jumlahData[0]['BanyakTransaksi'].') kurang dari 24 bulan!';
            $session = session();
            $session->markAsFlashdata('pesan');
            
            return redirect()->to('/peramalan');
        }
        else {            
            // Ambil data
            $dataPerusahaan = $this->persewaanDetailModel->getDataRamal($id);
            
            // buat csv
            $file = fopen("data.csv","w");
            foreach ($dataPerusahaan as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            
            // Jalankan peramalan
            set_time_limit(600);
            $python = system('python C:\xampp\htdocs\bismillahAkhir\app\Controllers\autoarima.py');
            echo $python;

            return redirect()->to('/peramalan');
        }
        
    }
    
}