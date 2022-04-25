<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\KategoriModel;
use App\Models\Admin\ProdukModel;
use App\Models\Admin\SatuanModel;
use Config\Services;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Reader\Exception;

use function PHPUnit\Framework\isNan;

class Produk extends BaseController
{
    public function index()
    {
        $data['title'] = 'Produk';
        return view('admin/produk', $data);
    }

    public function tambah()
    {
        $request = Services::request();
        $model = new ProdukModel($request);
        $satuan = new SatuanModel($request);
        $kategori = new KategoriModel($request);

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Tambah Produk';
            $data['kategori'] = $kategori->findAll();
            $data['satuan'] = $satuan->findAll();
            $data['validation'] = \Config\Services::validation();
            return view('admin/produk_tambah', $data);
        } else {
            if (!$this->validate('produk')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/produk/tambah')->withInput()->with('validation', $validation);
            }
            $req = [
                'barcode' => $this->request->getPost('barcode'),
                'nama' => $this->request->getPost('nama'),
                'kategori' => $this->request->getPost('kategori'),
                'satuan' => $this->request->getPost('satuan'),
                'harga_beli' => $this->request->getPost('harga_beli'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok')
            ];
            $model->insert($req);
            session()->setFlashdata('success', 'Berhasil menambahkan data produk.');
            return redirect('admin/produk');
        }
    }

    public function edit($barcode)
    {
        $request = Services::request();
        $satuan = new SatuanModel($request);
        $kategori = new KategoriModel($request);
        $model = new ProdukModel($request);

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Ubah Produk';
            $data['kategori'] = $kategori->findAll();
            $data['satuan'] = $satuan->findAll();
            $data['produk'] = $model->find($barcode);
            $data['validation'] = \Config\Services::validation();
            return view('admin/produk_edit', $data);
        } else {
            if ($barcode === $this->request->getPost('barcode')) {
                if (!$this->validate('produkEdit')) {
                    $validation = \Config\Services::validation();
                    // dd($validation);
                    return redirect()->to('admin/produk/edit/' . $barcode)->withInput()->with('validation', $validation);
                }
            } else {
                if (!$this->validate('produk')) {
                    $validation = \Config\Services::validation();
                    // dd($validation);
                    return redirect()->to('admin/produk/edit/' . $barcode)->withInput()->with('validation', $validation);
                }
            }
            $req = [
                'barcode' => $barcode,
                'nama' => $this->request->getPost('nama'),
                'kategori' => $this->request->getPost('kategori'),
                'satuan' => $this->request->getPost('satuan'),
                'harga_beli' => $this->request->getPost('harga_beli'),
                'harga_jual' => $this->request->getPost('harga_jual'),
                'stok' => $this->request->getPost('stok')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil mengubah data produk.');
            return redirect('admin/produk');
        }
    }

    public function hapus($id)
    {
        $request = Services::request();
        $model = new ProdukModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data produk.');
        return redirect()->to('admin/produk');
    }

    public function importExcel()
    {
        $file = $this->request->getFile('fileexcel');
        if ($file) {
            $request = Services::request();
            $model = new ProdukModel($request);
            $kategoriModel = new KategoriModel($request);
            $satuanModel = new SatuanModel($request);
            // Identifikasi jenis file
            $inputFileType = IOFactory::identify($file);
            // Buat reader sesuai jenis file
            $reader = IOFactory::createReader($inputFileType);
            // Ambil data saja
            $reader->setReadDataOnly(true);
            // Simpan hasil bacaan ke object spreadsheet
            $spreadsheet = $reader->load($file);
            $sheetdata = $spreadsheet->getActiveSheet()->toArray();
            unset($sheetdata[0]);

            $tambah = [];
            $ubah = [];
            $galat = [];

            foreach ($sheetdata as $value) {
                $barcode = $value[1];
                $nama_produk = $value[2];
                $kategori = $value[6];
                $satuan = $value[7];
                $harga_beli = $value[3];
                $harga_jual = $value[4];
                $stok = $value[5];

                $row = [
                    'barcode' => $barcode,
                    'nama' => $nama_produk,
                    'kategori' => $kategori,
                    'satuan' => $satuan,
                    'harga_beli' => $harga_beli,
                    'harga_jual' => $harga_jual,
                    'stok' => $stok,
                ];

                $cekbarcode = $model->find($barcode);
                if ($cekbarcode) {
                    if (
                        is_numeric($kategori) &&
                        is_numeric($satuan) &&
                        is_numeric($harga_beli) &&
                        is_numeric($harga_jual) &&
                        is_numeric($stok)
                    ) {
                        $cekkategori = $kategoriModel->find($kategori);
                        if ($cekkategori) {
                            $ceksatuan = $satuanModel->find($satuan);
                            if ($ceksatuan) {
                                $ubah[] = $row;
                            } else {
                                $row['error'] = 'Satuan dengan ID yang dimasukkan tidak ditemukan';
                                $galat[] = $row;
                            }
                        } else {
                            $row['error'] = 'Kategori dengan ID yang dimasukkan tidak ditemukan';
                            $galat[] = $row;
                        }
                    } else {
                        $row['error'] = 'Nilai Kategori, Satuan, Harga Beli, Harga Jual, dan Stok harus berupa angka';
                        $galat[] = $row;
                    }
                } else {
                    if (
                        is_numeric($kategori) &&
                        is_numeric($satuan) &&
                        is_numeric($harga_beli) &&
                        is_numeric($harga_jual) &&
                        is_numeric($stok)
                    ) {
                        $cekkategori = $kategoriModel->find($kategori);
                        if ($cekkategori) {
                            $ceksatuan = $satuanModel->find($satuan);
                            if ($ceksatuan) {
                                $tambah[] = $row;
                            } else {
                                $row['error'] = 'Satuan dengan ID yang dimasukkan tidak ditemukan';
                                $galat[] = $row;
                            }
                        } else {
                            $row['error'] = 'Kategori dengan ID yang dimasukkan tidak ditemukan';
                            $galat[] = $row;
                        }
                    } else {
                        $row['error'] = 'Nilai Kategori, Satuan, Harga Beli, Harga Jual, dan Stok harus berupa angka';
                        $galat[] = $row;
                    }
                }
            }

            if ($galat) {
                $data['galat'] = $galat;
            } else {
                $data['galat'] = $galat;
                if ($tambah) {
                    $model->batchInsert($tambah);
                }
                if ($ubah) {
                    $model->batchUpdate($ubah);
                }
                $data['tambah'] = count($tambah);
                $data['ubah'] = count($ubah);
            }

            $msg = [
                'data' => view('admin/tabel_excelproduk', $data)
            ];

            return json_encode($msg);
        }
    }

    public function listProduk()
    {
        $request = Services::request();
        $datatable = new ProdukModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->barcode;
                $row[] = $list->nama;
                $row[] = $list->kategori;
                $row[] = $list->satuan;
                $row[] = number_format($list->harga_beli, 2, ',', '.');
                $row[] = number_format($list->harga_jual, 2, ',', '.');
                $row[] = number_format($list->stok, 0, ',', '.');
                $row[] = "<a class=\"btn btn-warning btn-xs\" href=\"" . base_url('admin/produk/edit') . '/' . $list->barcode . "\" title=\"Edit\"><i class=\"fas fa-edit mr-1\"></i>Edit</a>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->id', '$list->nama')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAllData(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            return json_encode($output);
        }
    }
}
