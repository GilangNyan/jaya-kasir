<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\SupplierModel;
use Config\Services;

class Supplier extends BaseController
{
    public function index()
    {
        $data['title'] = 'Supplier';
        return view('admin/supplier', $data);
    }

    public function tambah()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Tambah Data Supplier';
            $data['validation'] = \Config\Services::validation();
            return view('admin/supplier_tambah', $data);
        } else {
            if (!$this->validate('supplier')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/supplier/tambah')->withInput()->with('validation', $validation);
            }
            $request = Services::request();
            $model = new SupplierModel($request);
            $req = [
                'nama' => $this->request->getPost('nama'),
                'telepon' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'),
                'deskripsi' => $this->request->getPost('desc')
            ];
            $model->insert($req);
            session()->setFlashdata('success', 'Berhasil menambahkan data supplier.');
            return redirect('admin/supplier');
        }
    }

    public function edit($id)
    {
        $request = Services::request();
        $model = new SupplierModel($request);

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Ubah Data Supplier';
            $data['validation'] = \Config\Services::validation();
            $data['supplier'] = $model->find($id);
            return view('admin/supplier_edit', $data);
        } else {
            $supplier = $model->find($id);
            if ($supplier['telepon'] === $this->request->getPost('telp')) {
                if (!$this->validate('supplierEdit')) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('admin/supplier/edit/' . $id)->withInput()->with('validation', $validation);
                }
            } else {
                if (!$this->validate('supplier')) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('admin/supplier/edit/' . $id)->withInput()->with('validation', $validation);
                }
            }
            $req = [
                'id' => $id,
                'nama' => $this->request->getPost('nama'),
                'telepon' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'),
                'deskripsi' => $this->request->getPost('desc')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil mengubah data supplier.');
            return redirect('admin/supplier');
        }
    }

    public function hapus($id)
    {
        $request = Services::request();
        $model = new SupplierModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data supplier.');
        return redirect()->to('admin/supplier');
    }

    public function listSupplier()
    {
        $request = Services::request();
        $datatable = new SupplierModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->telepon;
                $row[] = $list->alamat;
                $row[] = $list->deskripsi;
                $row[] = "<a class=\"btn btn-warning btn-xs\" href=\"" . base_url('admin/supplier/edit') . '/' . $list->id . "\" title=\"Edit\"><i class=\"fas fa-edit mr-1\"></i>Edit</a>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->id', '$list->nama')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
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
}
