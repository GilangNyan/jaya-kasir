<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\ProdukModel;
use App\Models\Admin\StokModel;
use App\Models\Admin\SupplierModel;
use Config\Services;

class Stok extends BaseController
{
    public function index()
    {
        $data['title'] = 'Stock In/Out';
        return view('admin/stock', $data);
    }

    public function stockIn()
    {
        $data['title'] = 'Stock In';
        return view('admin/stockin', $data);
    }

    public function stockInAdd()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Stock In';
            $data['validation'] = \Config\Services::validation();
            $request = Services::request();
            $modelSupplier = new SupplierModel($request);
            $data['supplier'] = $modelSupplier->findAll();
            return view('admin/stockin_tambah', $data);
        } else {
            if (!$this->validate('stockIn')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/stock/in/tambah')->withInput()->with('validation', $validation);
            }
            $request = Services::request();
            $model = new StokModel($request);
            $temptanggal = str_replace('/', '-', $this->request->getPost('tanggal'));
            $tanggal = strtotime($temptanggal);
            $req = [
                'produk' => $this->request->getPost('barcode'),
                'tipe' => 'in',
                'detail' => $this->request->getPost('detail'),
                'supplier' => $this->request->getPost('supplier') != '-' ? $this->request->getPost('supplier') : null,
                'qty' => $this->request->getPost('qty'),
                'tanggal' => date('Y-m-d', $tanggal),
                'user' => user()->id
            ];
            $model->insert($req);
            session()->setFlashdata('success', 'Berhasil memperbarui stok produk.');
            return redirect('admin/stock/in');
        }
    }

    public function stockInDelete($id)
    {
        $request = Services::request();
        $model = new StokModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data stock in.');
        return redirect('admin/stock/in');
    }

    public function stockOut()
    {
        $data['title'] = 'Stock Out';
        return view('admin/stockout', $data);
    }

    public function stockOutAdd()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Stock Out';
            $data['validation'] = \Config\Services::validation();
            $request = Services::request();
            $modelSupplier = new SupplierModel($request);
            $data['supplier'] = $modelSupplier->findAll();
            return view('admin/stockout_tambah', $data);
        } else {
            if (!$this->validate('stockIn')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/stock/out/tambah')->withInput()->with('validation', $validation);
            }
            $request = Services::request();
            $model = new StokModel($request);
            $temptanggal = str_replace('/', '-', $this->request->getPost('tanggal'));
            $tanggal = strtotime($temptanggal);
            $req = [
                'produk' => $this->request->getPost('barcode'),
                'tipe' => 'out',
                'detail' => $this->request->getPost('detail'),
                'supplier' => $this->request->getPost('supplier') != '-' ? $this->request->getPost('supplier') : null,
                'qty' => $this->request->getPost('qty'),
                'tanggal' => date('Y-m-d', $tanggal),
                'user' => user()->id
            ];
            $model->insert($req);
            session()->setFlashdata('success', 'Berhasil memperbarui stok produk.');
            return redirect('admin/stock/out');
        }
    }

    public function stockOutDelete($id)
    {
        $request = Services::request();
        $model = new StokModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data stock out.');
        return redirect('admin/stock/out');
    }

    public function listStock()
    {
        $request = Services::request();
        $datatable = new StokModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->barcode;
                $row[] = $list->nama_produk;
                $row[] = $list->qty;
                $row[] = $list->tipe;
                $row[] = $list->tanggal;
                $row[] = "<button type=\"button\" class=\"btn btn-light btn-xs\" title=\"Detail\"><i class=\"fas fa-eye mr-1\"></i>Detail</button>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->stock_id', 'Stok $list->nama_produk')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            return json_encode($output);
        }
    }

    public function listStockIn()
    {
        $request = Services::request();
        $datatable = new StokModel($request);
        $tipe = 'in';

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables($tipe);
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->barcode;
                $row[] = $list->nama_produk;
                $row[] = $list->qty;
                $row[] = $list->tipe;
                $row[] = $list->tanggal;
                $row[] = "<button type=\"button\" class=\"btn btn-light btn-xs\" title=\"Detail\"><i class=\"fas fa-eye mr-1\"></i>Detail</button>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->stock_id', 'Stok $list->nama_produk')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll($tipe),
                'recordsFiltered' => $datatable->countFiltered($tipe),
                'data' => $data
            ];

            return json_encode($output);
        }
    }

    public function listStockOut()
    {
        $request = Services::request();
        $datatable = new StokModel($request);
        $tipe = 'out';

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables($tipe);
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->barcode;
                $row[] = $list->nama_produk;
                $row[] = $list->qty;
                $row[] = $list->tipe;
                $row[] = $list->tanggal;
                $row[] = "<button type=\"button\" class=\"btn btn-light btn-xs\" title=\"Detail\"><i class=\"fas fa-eye mr-1\"></i>Detail</button>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->stock_id', 'Stok $list->nama_produk')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll($tipe),
                'recordsFiltered' => $datatable->countFiltered($tipe),
                'data' => $data
            ];

            return json_encode($output);
        }
    }

    public function listProduk()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'viewmodal' => view('admin/modal_produkstocking', $data)
            ];
            return json_encode($msg);
        }
    }

    public function listDataProduk()
    {
        if ($this->request->isAJAX()) {
            $keywordkode = $this->request->getPost('keywordkode');
            $request = Services::request();
            $datatable = new ProdukModel($request);

            if ($request->getMethod(true) === 'POST') {
                $lists = $datatable->getDatatables($keywordkode);
                $data = [];
                $no = $request->getPost('start');

                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->barcode;
                    $row[] = $list->nama;
                    $row[] = $list->kategori;
                    $row[] = number_format($list->stok, 0, ',', '.');
                    $row[] = number_format($list->harga_jual, 0, ',', '.');
                    $row[] = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"pilihProduk('" . $list->barcode . "', '" . $list->nama . "', '" . $list->stok . "', '" . $list->satuan . "')\"><i class=\"fas fa-check\"></i></button>";
                    $data[] = $row;
                }

                $output = [
                    'draw' => $request->getPost('draw'),
                    'recordsTotal' => $datatable->countAllData($keywordkode),
                    'recordsFiltered' => $datatable->countFiltered($keywordkode),
                    'data' => $data
                ];

                return json_encode($output);
            }
        }
    }

    public function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $kodebarcode = $this->request->getPost('barcode');
            $namaproduk = $this->request->getPost('namaproduk');

            $request = Services::request();
            $model = new ProdukModel($request);
            $cekProduk = $model->cekProduk($kodebarcode, $namaproduk);

            if (count($cekProduk) > 1) {
                $msg = ['totaldata' => 'banyak'];
            } else if (count($cekProduk) == 1) {
                $msg = [
                    'sukses' => 'berhasil',
                    'hasil' => $model->getOneProduk($kodebarcode)
                ];
            } else {
                $msg = ['error' => 'Produk tidak ditemukan'];
            }

            return json_encode($msg);
        }
    }
}
