<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MesinFotocopy extends BaseController
{

    public function index()
    {
        //Memanggil Model dari BaseController
        $mesinFotocopy = $this->mesinFotocopyModel->getMesinFotocopy();
        // dd($mesinFotocopy);
        // $dataStok = $this->persewaanModel->getDataStok();
        // $mesinfotocopy = $this->mesinFotocopyModel->getmesinfotocopy();

        $data = [
            'title' => 'mesinfotocopy',
            'mesinfotocopy' => $mesinFotocopy
        ];

        return view('mesinfotocopy/data', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Tambah Data Mesin',
            'validation' => \Config\Services::validation()
        ];

        return view('mesinfotocopy/create', $data);
    }

    public function save()
    {
        //0. dd($this->request->getVar()); //GetData semua input dari Form 

        //1. Validation Process
        if (!$this->validate([
            'input_nama' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Nama mesinfotocopy harus diisi',
                    'max_length' => 'Nama mesinfotocopy terlalu panjang, maks 10 karakter'
                ]
            ],
            'input_stok' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Stok mesinfotocopy harus diisi',
                    'max_length' => 'Stok mesinfotocopy terlalu panjang, maks 150 karakter'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            //dd($validation);
            return redirect()->to('/mesinfotocopy/create')->withInput()->with('validation', $validation->getErrors());

            //return redirect()->to('/mesinfotocopy/create');
        }

        //2. Create Data Process
        $this->mesinFotocopyModel->save([
            'nama_mesin' => $this->request->getVar('input_nama'),
            'stok_mesin' => $this->request->getVar('input_stok')
        ]);

        //3. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        //4. Redirect
        return redirect()->to('/mesinfotocopy');
    }

    public function delete($id)
    {
        //1. Delete Data
        //$this->mesinFotocopyModel->delete(['id_mesinsewa' => $id]);
        $this->mesinFotocopyModel->delete(['id_mesin' => $id]);

        //2. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil Dihapus.');

        //3. Redirect
        return redirect()->to('/mesinfotocopy');
    }

    public function restrict()
    {
        return redirect()->to('/mesinfotocopy');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Ubah Data mesinfotocopy',
            'validation' => \Config\Services::validation(),
            'mesinfotocopy' => $this->mesinFotocopyModel->getMesinFotocopy($id)
        ];

        return view('mesinfotocopy/edit', $data);
    }

    public function update($id)
    {
        //GetData semua input dari Form 
        //dd($this->request->getVar());

        //1. Validation Process
        if (!$this->validate([
            //name_inputform => rules (lihat di dokumentasi codeIgniter)
            //'input_namamesinfotocopy' => 'required|is_unique[tbl_mesinfotocopy.nama_mesinfotocopy]'
            'input_nama' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Nama mesinfotocopy harus diisi',
                    'max_length' => 'Nama mesinfotocopy terlalu panjang, maks 10 karakter'
                ]
            ],
            'input_stok' => [
                'rules' => 'required|max_length[250]',
                'errors' => [
                    'required' => 'Stok mesinfotocopy harus diisi',
                    'max_length' => 'Stok mesinfotocopy terlalu panjang, maks 150 karakter'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            //dd($validation);
            return redirect()->to('/mesinfotocopy/edit/' . $id)->withInput()->with('validation', $validation->getErrors());
        }

        //2. Update Data Process
        $this->mesinFotocopyModel->save([
            'id_mesin' => $id,
            'nama_mesin' => $this->request->getVar('input_nama'),
            'stok_mesin' => $this->request->getVar('input_stok')
        ]);

        //3. Membuat FlashData
        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        //4. Redirect
        return redirect()->to('/mesinfotocopy');
    }

    public function ExportExcel()
    {
        // Deklarasi spreadsheet
        $spreadsheet = new Spreadsheet();

        // Ambil data
        $datamesinfotocopy = $this->mesinFotocopyModel->findAll();

        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID mesinfotocopy')
            ->setCellValue('B1', 'Nama mesinfotocopy')
            ->setCellValue('C1', 'Alamat mesinfotocopy')
            ->setCellValue('D1', 'No. Telp mesinfotocopy');

        $column = 2;
        // tulis data mobil ke cell
        foreach ($datamesinfotocopy as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['id_mesinfotocopy'])
                ->setCellValue('B' . $column, $data['nama_mesinfotocopy'])
                ->setCellValue('C' . $column, $data['alamat_mesinfotocopy'])
                ->setCellValue('D' . $column, $data['notelp_mesinfotocopy']);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data mesinfotocopy';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
