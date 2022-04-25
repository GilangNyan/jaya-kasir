<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\UserModel;

class User extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['title'] = 'Pengguna';
        $data['pengguna'] = $model->paginate(9, 'pengguna');
        $data['pager'] = $model->pager;
        return view('admin/user', $data);
    }
}
