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
            $python = system('python C:\xampp\htdocs\web\bismillahAkhir\app\Controllers\autoarima.py');
            echo $python;

            return redirect()->to('/peramalan');
        }
        
    }

    public function tanggalRamal($id){
        // Cek Jumlah data
        $jumlahData =  $this->persewaanDetailModel->getJumlahData($id);

        if ($jumlahData[0]['BanyakTransaksi'] < 24) {

            $_SESSION['pesan'] = 'Peramalan gagal! jumlah data yang dimiliki ('.$jumlahData[0]['BanyakTransaksi'].') kurang dari 24 bulan!';
            $session = session();
            $session->markAsFlashdata('pesan');
            
            return redirect()->to('/peramalan');
        }
        else{
            $file = fopen('C:\xampp\htdocs\web\bismillahAkhir\public\dataRamal.csv',"r");
            $perusahaan = $this->perusahaanModel->getNamaPerusahaan($id);
    
            $dataJadi=[];
            $bulanBaru=[];
            $tahunBaru=[];
            
    
            for ($i=0; $i < 12; $i++) { 
                $data=fgetcsv($file);
                $data= implode($data);
                $data = str_replace(".", "", $data);
                
                if ($data[0]=='1') {
                    $dataJadi[]=substr($data, 0, 7);
                }
                else if ($data[0]=='2') {
                    $dataJadi[]=substr($data, 0, 7);
                }
                else {
                    $dataJadi[]=substr($data, 0, 6);
                }
            }
            fclose($file);
    
            // Ambil tanggal terakhir
            $tanggalTerakhir = $this->persewaanDetailModel->getTanggalTerakhir($id)[0];
            $bulanTerakhir = substr($tanggalTerakhir['tanggalTerakhir'], 5, 2);
            $tahunTerakhir = substr($tanggalTerakhir['tanggalTerakhir'], 0, 4);
            
            $bulanTerakhir = (int)$bulanTerakhir;
            $tahunTerakhir = (int)$tahunTerakhir;
            $counterBulan = $bulanTerakhir+1;
            $counter = 1;
    
            for ($i=$tahunTerakhir; $i <= $tahunTerakhir+1; $i++) { 
                
                for ($j=$counterBulan; $j <= 12; $j++) { 
                    
                    if ($j<=12) {
                        $bulanBaru[]=$j;
                        $tahunBaru[]=$i;
                        $counter++;
                    } 
                    if ($counter>=13) {
                        break;
                    }        
                }
                $counterBulan=1;
            }
    
            $data = [
                'perusahaan'=>$perusahaan[0]['NAMA_PERUSAHAAN'],
                'dataJadi' => $dataJadi,
                'bulanBaru' => $bulanBaru,
                'tahunBaru' => $tahunBaru
            ];
    
            return view('peramalan/detail', $data);
        }

        
    }
    
}