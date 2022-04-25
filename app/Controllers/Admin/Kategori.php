<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\KategoriModel;
use Config\Services;

class Kategori extends BaseController
{
    public function index()
    {
        $data['title'] = 'Kategori';
        return view('admin/kategori', $data);
    }

    public function tambah()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Tambah Kategori';
            $data['validation'] = \Config\Services::validation();
            return view('admin/kategori_tambah', $data);
        } else {
            if (!$this->validate('kategori')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/kategori/tambah')->withInput()->with('validation', $validation);
            }
            $request = Services::request();
            $model = new KategoriModel($request);
            $req = [
                'kategori' => $this->request->getPost('nama'),
                'bisadihitung' => $this->request->getPost('countable')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil menambahkan data kategori.');
            return redirect('admin/kategori');
        }
    }

    public function edit($id)
    {
        $request = Services::request();
        $model = new KategoriModel($request);

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Ubah Kategori';
            $data['validation'] = \Config\Services::validation();
            $data['kategori'] = $model->find($id);
            return view('admin/kategori_edit', $data);
        } else {
            if (!$this->validate('kategori')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/kategori/edit/' . $id)->withInput()->with('validation', $validation);
            }
            $req = [
                'id' => $id,
                'kategori' => $this->request->getPost('nama'),
                'bisadihitung' => $this->request->getPost('countable')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil mengubah data kategori.');
            return redirect('admin/kategori');
        }
    }

    public function hapus($id)
    {
        $request = Services::request();
        $model = new KategoriModel($request);
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data kategori.');
        return redirect()->to('admin/kategori');
    }

    public function sampah()
    {
        $request = Services::request();
        $model = new KategoriModel($request);

        $data['title'] = 'Kategori';
        $data['kategori'] = $model->onlyDeleted()->findAll();
        return view('admin/kategori', $data);
    }

    public function listKategori()
    {
        $request = Services::request();
        $datatable = new KategoriModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->kategori;
                $row[] = $list->bisadihitung == 0 ? 'Tidak' : 'Ya';
                $row[] = "<a class=\"btn btn-warning btn-xs\" href=\"" . base_url('admin/kategori/edit') . '/' . $list->id . "\" title=\"Edit\"><i class=\"fas fa-edit mr-1\"></i>Edit</a>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->id', '$list->kategori')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
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
