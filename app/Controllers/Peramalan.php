<?php namespace App\Controllers;

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
        // Ambil data
        $dataPerusahaan = $this->persewaanDetailModel->getDataRamal($id);

        // dd($dataPerusahaan);
        $file = fopen("data.csv","w");

        foreach ($dataPerusahaan as $line) {
            fputcsv($file, $line);
        }

        fclose($file);

        set_time_limit(600);
        $python = system('python C:\xampp\htdocs\web\bismillahAkhir\app\Controllers\autoarima.py');
        
        echo $python;
        return redirect()->to('/peramalan');
    }

    
}