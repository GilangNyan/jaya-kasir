<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\MemberModel;

class Member extends BaseController
{
    public function index()
    {
        $model = new MemberModel();

        $data['title'] = 'Member';
        $data['member'] = $model->findAll();
        return view('admin/member', $data);
    }

    public function tambah()
    {
        if (!isset($_POST['submit'])) {
            $data['title'] = 'Tambah Member';
            $data['validation'] = \Config\Services::validation();
            return view('admin/member_tambah', $data);
        } else {
            if (!$this->validate('member')) {
                $validation = \Config\Services::validation();
                return redirect()->to('admin/member/tambah')->withInput()->with('validation', $validation);
            }
            $model = new MemberModel();
            $req = [
                'nama_lengkap' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'telepon' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil menambahkan data member.');
            return redirect('admin/member');
        }
    }

    public function edit($id)
    {
        $model = new MemberModel();

        if (!isset($_POST['submit'])) {
            $data['title'] = 'Ubah Member';
            $data['validation'] = \Config\Services::validation();
            $data['member'] = $model->find($id);
            return view('admin/member_edit', $data);
        } else {
            $member = $model->find($id);
            if ($member['email'] === $this->request->getPost('email')) {
                if (!$this->validate('memberEditEmail')) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('admin/member/edit/' . $id)->withInput()->with('validation', $validation);
                }
            } else if ($member['telepon'] === $this->request->getPost('telp')) {
                if (!$this->validate('memberEditTelp')) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('admin/member/edit/' . $id)->withInput()->with('validation', $validation);
                }
            } else {
                if (!$this->validate('member')) {
                    $validation = \Config\Services::validation();
                    return redirect()->to('admin/member/edit/' . $id)->withInput()->with('validation', $validation);
                }
            }
            $req = [
                'id' => $id,
                'nama_lengkap' => $this->request->getPost('nama'),
                'email' => $this->request->getPost('email'),
                'telepon' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat')
            ];
            $model->save($req);
            session()->setFlashdata('success', 'Berhasil mengubah data member.');
            return redirect('admin/member');
        }
    }

    public function hapus($id)
    {
        $model = new MemberModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Berhasil menghapus data member.');
        return redirect()->to('admin/member');
    }
}
