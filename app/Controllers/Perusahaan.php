<?php

namespace App\Controllers;

class Perusahaan extends BaseController
{

    public function index()
    {
        //Memanggil Model dari BaseController
        $perusahaan = $this->perusahaanModel->getPerusahaan();
        // $perusahaan = $this->perusahaanModel->getPerusahaan();
        // dd($perusahaan);
        
        $data = [
            'title' => 'Perusahaan',
            'perusahaan' => $perusahaan
        ];
        // dd($data);
        return view('perusahaan/data', $data);
    }
    
    public function create()
    {
        $StokMesin = $this->mesinFotocopyModel->findAll();
        
        $data = [
            'title' => 'Tambah Data Perusahaan',
            'validation' => \Config\Services::validation(),
            'StokMesin' =>$StokMesin
        ];

        return view('perusahaan/create', $data);
    }

    public function save()
    {
        //0. dd($this->request->getVar()); //GetData semua input dari Form 

        //1. Validation Process
        if (!$this->validate([
            'input_nama' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Nama Perusahaan harus diisi',
                    'max_length' => 'Nama Perusahaan terlalu panjang, maks 50 karakter'
                ]
            ],
            'input_alamat' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Alamat Perusahaan harus diisi',
                    'max_length' => 'Alamat Perusahaan terlalu panjang, maks 150 karakter'
                ]
            ],
            'input_notelp' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'No Hp Perusahaan harus diisi',
                    'is_natural' => 'No Hp Perusahaan harus berupa angka',
                    'max_length' => 'No Hp Perusahaan terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_limit' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Limit harus diisi',
                    'is_natural' => 'Limit harus berupa angka',
                    'max_length' => 'Limit terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_hargaover' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Harga Over harus diisi',
                    'is_natural' => 'Harga Over harus berupa angka',
                    'max_length' => 'Harga Over terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_biayasewa' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'Biaya Sewa harus diisi',
                    'is_natural' => 'Biaya Sewa harus berupa angka',
                    'max_length' => 'Biaya Sewa terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_mesin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mesin Fotocopy harus diisi'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            //dd($validation);
            return redirect()->to('/perusahaan/create')->withInput()->with('validation', $validation->getErrors());

            //return redirect()->to('/perusahaan/create');
        }

        //2. Create Data Process
        $this->perusahaanModel->save([
            'NAMA_PERUSAHAAN' => $this->request->getVar('input_nama'),
            'ALAMAT' => $this->request->getVar('input_alamat'),
            'NO_TELP' => $this->request->getVar('input_notelp'),
            'LIMIT_PERUSAHAAN' => $this->request->getVar('input_limit'),
            'HARGA_OVER' => $this->request->getVar('input_hargaover'),
            'BIAYA_SEWA' => $this->request->getVar('input_biayasewa'),
            'ID_MESIN' => $this->request->getVar('input_mesin')
        ]);

        //3. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        //4. Redirect
        return redirect()->to('/perusahaan');
    }

    public function delete($id)
    {
        //1. Delete Data
        //$this->perusahaanModel->delete(['id_mesinsewa' => $id]);
        $this->perusahaanModel->delete(['id_perusahaan' => $id]);

        //2. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil Dihapus.');

        //3. Redirect
        return redirect()->to('/perusahaan');
    }

    public function restrict()
    {
        return redirect()->to('/perusahaan');
    }

    public function edit($id)
    {
        $StokMesin = $this->mesinFotocopyModel->findAll();

        $data = [
            'title' => 'Form Ubah Data Perusahaan',
            'validation' => \Config\Services::validation(),
            'perusahaan' => $this->perusahaanModel->getPerusahaan($id),
            'StokMesin' =>$StokMesin
        ];
        // dd($data);

        return view('perusahaan/edit', $data);
    }

    public function update($id)
    {
        //GetData semua input dari Form 
        //dd($this->request->getVar());

        //Cek Kondisi Judul apakah diupdate atau tidak
        $perusahaanLama = $this->perusahaanModel->getPerusahaan($this->request->getVar('input_idperusahaan'));
        if ($perusahaanLama['NAMA_PERUSAHAAN'] == $this->request->getVar('input_nama')) {
            $ruleNamaPerusahaan = 'required|max_length[50]';
        } else {

            $ruleNamaPerusahaan = 'required|is_unique[perusahaan.nama_perusahaan]|max_length[50]';
        }

        //1. Validation Process
        if (!$this->validate([
            //name_inputform => rules (lihat di dokumentasi codeIgniter)
            //'input_namaperusahaan' => 'required|is_unique[tbl_perusahaan.nama_perusahaan]'
            'input_nama' => [
                'rules' => $ruleNamaPerusahaan,
                'errors' => [
                    'required' => 'Nama Perusahaan harus diisi',
                    'max_length' => 'Nama Perusahaan terlalu panjang, maks 50 karakter'
                ]
            ],
            'input_alamat' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Alamat Perusahaan harus diisi',
                    'max_length' => 'Alamat Perusahaan terlalu panjang, maks 150 karakter'
                ]
            ],
            'input_notelp' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'No Hp Perusahaan harus diisi',
                    'is_natural' => 'No Hp Perusahaan harus berupa angka',
                    'max_length' => 'No Hp Perusahaan terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_limit' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'No Hp Perusahaan harus diisi',
                    'is_natural' => 'No Hp Perusahaan harus berupa angka',
                    'max_length' => 'No Hp Perusahaan terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_hargaover' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'No Hp Perusahaan harus diisi',
                    'is_natural' => 'No Hp Perusahaan harus berupa angka',
                    'max_length' => 'No Hp Perusahaan terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_biayasewa' => [
                'rules' => 'required|is_natural|max_length[20]',
                'errors' => [
                    'required' => 'No Hp Perusahaan harus diisi',
                    'is_natural' => 'No Hp Perusahaan harus berupa angka',
                    'max_length' => 'No Hp Perusahaan terlalu panjang, maks 20 karakter'
                ]
            ],
            'input_mesin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mesin Fotocopy harus diisi'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            //dd($validation);
            return redirect()->to('/perusahaan/edit/' . $id)->withInput()->with('validation', $validation->getErrors());
        }

        //2. Update Data Process
        $this->perusahaanModel->save([
            'ID_PERUSAHAAN' => $id,
            'NAMA_PERUSAHAAN' => $this->request->getVar('input_nama'),
            'ALAMAT' => $this->request->getVar('input_alamat'),
            'NO_TELP' => $this->request->getVar('input_notelp'),
            'LIMIT_PERUSAHAAN' => $this->request->getVar('input_limit'),
            'HARGA_OVER' => $this->request->getVar('input_hargaover'),
            'BIAYA_SEWA' => $this->request->getVar('input_biayasewa'),
            'ID_MESIN' => $this->request->getVar('input_mesin')
        ]);

        //3. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        //4. Redirect
        return redirect()->to('/perusahaan');
    }

}
