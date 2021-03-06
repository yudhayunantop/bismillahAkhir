<?php

namespace App\Controllers;

class PersewaanDetail extends BaseController
{

    public function index($id)
    {
        //Memanggil Model dari BaseController
        $persewaanDetail = $this->persewaanDetailModel->getPersewaanDetail($id);
        // $perusahaan = $this->perusahaanModel->getPerusahaan();
        // dd($persewaanDetail);

        $data = [
            'title' => 'Perusahaan',
            'persewaanDetail' => $persewaanDetail,
            'idPerusahaan' => $id
        ];

        return view('persewaandetail/data', $data);
    }

    public function create($idPerusahaan)
    {
        $data = [
            'title' => 'Tambah Data Persewaan',
            'validation' => \Config\Services::validation(),
            'idPerusahaan' => $idPerusahaan
        ];

        return view('persewaandetail/create', $data);
    }

    public function save($idPerusahaan)
    {
        //0. dd($this->request->getVar()); //GetData semua input dari Form 

        //1. Validation Process
        if (!$this->validate([
            //name_inputform => rules (lihat di dokumentasi codeIgniter)
            //'input_namaperusahaan' => 'required|is_unique[tbl_perusahaan.nama_perusahaan]'
            'input_tanggaltagih' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Tagih harus diisi',
                ]
            ],
            'input_tanggalbayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Bayar harus diisi',
                ]
            ],
            'input_counterlalu' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Counter Bulan Lalu Perusahaan harus diisi',
                    'is_natural' => 'Counter Bulan Lalu harus berupa angka',
                    'max_length' => 'Counter Bulan Lalu terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_counterini' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Counter Bulan Ini harus diisi',
                    'is_natural' => 'Counter Bulan Ini harus berupa angka',
                    'max_length' => 'Counter Bulan Ini terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_kertasrusak' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Kertas Rusak harus diisi',
                    'is_natural' => 'Kertas Rusak harus berupa angka',
                    'max_length' => 'Kertas Rusak terlalu panjang, maks 20 karakter'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            // dd($validation);
            return redirect()->to('/persewaandetail/create/'.$idPerusahaan)->withInput()->with('validation', $validation->getErrors());

            //return redirect()->to('/perusahaan/create');
        }

        // Inisiasi Data
        $dataTagihan = $this->perusahaanModel->getDataTagihan($idPerusahaan)[0];
        $counterBulanLalu = $this->request->getVar('input_counterlalu');
        $counterBulanIni = $this->request->getVar('input_counterini');
        $kertasRusak = $this->request->getVar('input_kertasrusak');
        $tanggalTagih = $this->request->getVar('input_tanggaltagih');
        // $kelebihanPemakaian = $this->request->getVar('input_kelebihanpemakaian');

        $jumlahKelebihan=0;
        $jumlahTagihan = 0;
        $kelebihanPemakaian = 0;

        // Mulai Perhitungan
        $selisihCounter = $counterBulanIni-$counterBulanLalu;
        $netto = $selisihCounter-$kertasRusak;

        if ($netto > (int) $dataTagihan['LIMIT_PERUSAHAAN']) {
            $kelebihanPemakaian = $netto - (int) $dataTagihan['LIMIT_PERUSAHAAN']; 
            $jumlahKelebihan = $kelebihanPemakaian * (int) $dataTagihan['HARGA_OVER'];
            $jumlahTagihan = $jumlahKelebihan + (int) $dataTagihan['BIAYA_SEWA'];
        }else {
            $jumlahTagihan = (int) $dataTagihan['BIAYA_SEWA'];
        }

        $tanggalDuplikat = $this->persewaanDetailModel->cekTanggalDuplikat($idPerusahaan, $tanggalTagih)[0]['JumlahTanggal'];
        // dd($tanggalDuplikat);
        if((int)$tanggalDuplikat==0){
            //2. Create Data Process
            // Panggil model persewaanDetail + save
            $this->persewaanDetailModel->save([
                'TANGGAL_TAGIH' => $tanggalTagih,
                'TANGGAL_BAYAR' => $this->request->getVar('input_tanggalbayar'),
                'COUNTER_BULAN_LALU' => $this->request->getVar('input_counterlalu'),
                'COUNTER_BULAN_INI' => $this->request->getVar('input_counterini'),
                'SELISIH_COUNTER' => $selisihCounter,
                'KERTAS_RUSAK' => $this->request->getVar('input_kertasrusak'),
                'NETTO' => $netto,
                'KELEBIHAN_PEMAKAIAN' => $kelebihanPemakaian,
                'JUMLAH_TAGIHAN' => $jumlahTagihan
            ]);
        
            $idPersewaanDetail= $this->persewaanDetailModel->getInsertID();
        
            // panggil model persewaan + save
            $this->persewaanModel->save([
                'ID_USER' => session()->get('ID_USER'),
                'ID_PERUSAHAAN' => $this->request->getVar('input_idperusahaan'),
                'ID_PERSEWAAN_DETAIL' => $idPersewaanDetail
            ]);
            //3. Membuat FlashData
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

            //4. Redirect
            return redirect()->to('persewaandetail/'.$idPerusahaan);

        }else{

            $_SESSION['pesan'] = 'Tanggal tagih sudah ada!';
            $session = session();
            $session->markAsFlashdata('pesan');

            return redirect()->to('/persewaandetail/create/'.$idPerusahaan)->withInput();
        }
    }

    public function delete($id, $idPerusahaan)
    {
        //1. Delete Data
        //$this->perusahaanModel->delete(['id_mesinsewa' => $id]);
        $this->persewaanDetailModel->delete(['ID_PERSEWAAN_DETAIL' => $id]);

        //2. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil Dihapus.');

        //3. Redirect
        return redirect()->to('persewaandetail/'.$idPerusahaan);
    }

    public function restrict()
    {
        return redirect()->to('/perusahaan');
    }

    public function edit($id, $idPerusahaan)
    {
        $data = [
            'title' => 'Ubah Data Perusahaan',
            'validation' => \Config\Services::validation(),
            'persewaanDetail' => $this->persewaanDetailModel->getUpdate($id),
            'idPerusahaan' => $idPerusahaan
        ];

        return view('persewaandetail/edit', $data);
    }

    public function update($id, $idPerusahaan)
    {
        //GetData semua input dari Form 
        //dd($this->request->getVar());

        //1. Validation Process
        if (!$this->validate([
            //name_inputform => rules (lihat di dokumentasi codeIgniter)
            //'input_namaperusahaan' => 'required|is_unique[tbl_perusahaan.nama_perusahaan]'
            'input_tanggaltagih' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Tagih harus diisi',
                ]
            ],
            'input_tanggalbayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Bayar harus diisi',
                ]
            ],
            'input_counterlalu' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Counter Bulan Lalu Perusahaan harus diisi',
                    'is_natural' => 'Counter Bulan Lalu harus berupa angka',
                    'max_length' => 'Counter Bulan Lalu terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_counterini' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Counter Bulan Ini harus diisi',
                    'is_natural' => 'Counter Bulan Ini harus berupa angka',
                    'max_length' => 'Counter Bulan Ini terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_kertasrusak' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Kertas Rusak harus diisi',
                    'is_natural' => 'Kertas Rusak harus berupa angka',
                    'max_length' => 'Kertas Rusak terlalu panjang, maks 20 karakter'
                ]
            ]
            // ,
            // 'input_kelebihanpemakaian' => [
            //     'rules' => 'required|is_natural|max_length[20]',
            //     'errors' => [
            //         'required' => 'Kelebihan Pemakaian harus diisi',
            //         'is_natural' => 'Kelebihan Pemakaian harus berupa angka',
            //         'max_length' => 'Kelebihan Pemakaian terlalu panjang, maks 20 karakter'
            //     ]
            // ]
        ])) {
            $validation = \Config\Services::validation();
            //dd($validation);
            return redirect()->to('/persewaandetail/edit/' . $id .'/'. $idPerusahaan)->withInput()->with('validation', $validation->getErrors());
        }

        // Inisiasi Data
        $dataTagihan = $this->perusahaanModel->getDataTagihan($idPerusahaan)[0];
        $counterBulanLalu = $this->request->getVar('input_counterlalu');
        $counterBulanIni = $this->request->getVar('input_counterini');
        $kertasRusak = $this->request->getVar('input_kertasrusak');
        // $kelebihanPemakaian = $this->request->getVar('input_kelebihanpemakaian');

        $jumlahKelebihan=0;
        $jumlahTagihan = 0;
        $kelebihanPemakaian = 0;

        // Mulai Perhitungan
        $selisihCounter = $counterBulanIni-$counterBulanLalu;
        $netto = $selisihCounter-$kertasRusak;

        if ($netto > (int) $dataTagihan['LIMIT_PERUSAHAAN']) {
            $kelebihanPemakaian = $netto - (int) $dataTagihan['LIMIT_PERUSAHAAN']; 
            $jumlahKelebihan = $kelebihanPemakaian * (int) $dataTagihan['HARGA_OVER'];
            $jumlahTagihan = $jumlahKelebihan + (int) $dataTagihan['BIAYA_SEWA'];
        }else {
            $jumlahTagihan = (int) $dataTagihan['BIAYA_SEWA'];
        }

        //2. Create Data Process
        // Panggil model persewaanDetail + save
        $this->persewaanDetailModel->save([
            'ID_PERSEWAAN_DETAIL' => $id,
            'TANGGAL_TAGIH' => $this->request->getVar('input_tanggaltagih'),
            'TANGGAL_BAYAR' => $this->request->getVar('input_tanggalbayar'),
            'COUNTER_BULAN_LALU' => $this->request->getVar('input_counterlalu'),
            'COUNTER_BULAN_INI' => $this->request->getVar('input_counterini'),
            'SELISIH_COUNTER' => $selisihCounter,
            'KERTAS_RUSAK' => $this->request->getVar('input_kertasrusak'),
            'NETTO' => $netto,
            'KELEBIHAN_PEMAKAIAN' => $kelebihanPemakaian,
            'JUMLAH_TAGIHAN' => $jumlahTagihan
        ]);

        //3. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        //4. Redirect
        return redirect()->to('persewaandetail/'.$idPerusahaan);
    }

    public function hitungSSE($id, $idPerusahaan)
    {
        $jumlahTagihan = $this->persewaanDetailModel->getJumlahTagihan($id);
        $sse = $jumlahTagihan[0]['JUMLAH_TAGIHAN'] * 0.05;

        $_SESSION['pesan'] = 'Jumlah SSE Persewaan sebesar : '.$sse;
        $session = session();
        $session->markAsFlashdata('pesan');

        return redirect()->to('persewaandetail/'.$idPerusahaan);
    }

    function cetakTagihan($id,$idPerusahaan){
        $dataPerusahaan = $this->perusahaanModel->getDataTagihan($idPerusahaan);
        $dataPersewaan = $this->persewaanDetailModel->getPersewaan($id);

        // $data = [
        //     'title' => 'Perusahaan',
        //     'dataPerusahaan' => $dataPerusahaan,
        //     'dataPersewaan' => $dataPersewaan
        // ];

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('persewaandetail/tagihan', ["dataPerusahaan" => $dataPerusahaan, 'dataPersewaan' => $dataPersewaan]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('tagihan'.$id.'.pdf');

        return redirect()->to('persewaandetail/'.$idPerusahaan);
    }

    function cetakCounter($id,$idPerusahaan){
        $dataPersewaan = $this->persewaanDetailModel->getPersewaan($id);

        // $data = [
        //     'title' => 'Perusahaan',
        //     'dataPerusahaan' => $dataPerusahaan,
        //     'dataPersewaan' => $dataPersewaan
        // ];

        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('persewaandetail/counter', ['dataPersewaan' => $dataPersewaan]));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('counter'.$id.'.pdf');

        return redirect()->to('persewaandetail/'.$idPerusahaan);
    }
}
