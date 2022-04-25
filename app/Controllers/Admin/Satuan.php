<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\SatuanModel;
use Config\Services;

class Satuan extends BaseController
{
    public function index()
    {
        $request = Services::request();
        $model = new SatuanModel($request);

        $data['title'] = 'Satuan';
        $data['satuan'] = $model->findAll();
        return view('admin/satuan', $data);
    }

    public function tambah()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Tambah Satuan';
            $data['validation'] = \Config\Services::validation();
            return view('admin/satuan_tambah', $data);
        } else {
            if (!$this->validate('satuan')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/satuan/tambah')->withInput()->with('validation', $validation);
            }
            $request = Services::request();
            $model = new SatuanModel($request);
            $req = [
                'satuan' => $this->request->getPost('nama')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil menambahkan data satuan.');
            return redirect('admin/satuan');
        }
    }

    public function edit($id)
    {
        $request = Services::request();
        $model = new SatuanModel($request);

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Ubah Satuan';
            $data['validation'] = \Config\Services::validation();
            $data['satuan'] = $model->find($id);
            return view('admin/satuan_edit', $data);
        } else {
            if (!$this->validate('satuan')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/satuan/edit/' . $id)->withInput()->with('validation', $validation);
            }
            $req = [
                'id' => $id,
                'satuan' => $this->request->getPost('nama'),
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil mengubah data satuan.');
            return redirect('admin/satuan');
        }
    }

    public function hapus($id)
    {
        $request = Services::request();
        $model = new SatuanModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data satuan.');
        return redirect()->to('admin/satuan');
    }

    public function sampah()
    {
        // 
    }

    public function listSatuan()
    {
        $request = Services::request();
        $datatable = new SatuanModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->satuan;
                $row[] = "<a class=\"btn btn-warning btn-xs\" href=\"" . base_url('admin/satuan/edit') . '/' . $list->id . "\" title=\"Edit\"><i class=\"fas fa-edit mr-1\"></i>Edit</a>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->id', '$list->satuan')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
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
