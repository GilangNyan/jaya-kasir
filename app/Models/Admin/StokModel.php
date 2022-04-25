<?php

namespace App\Models\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class StokModel extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'id';

    protected $autoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['produk', 'tipe', 'detail', 'supplier', 'qty', 'tanggal', 'user', 'deleted_at'];

    // Variabel untuk datatables server-side
    protected $column_order = [null, 'produk', 'nama_produk', 'qty', 'tipe', 'tanggal', null];
    protected $column_search = ['produk', 'nama_produk', 'qty', 'tipe', 'tanggal'];
    protected $order = ['tanggal', 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->select('*, stok.id as stock_id, produk.nama as nama_produk, supplier.nama as nama_supplier')->join('produk', 'stok.produk = produk.barcode', 'left')->join('supplier', 'stok.supplier = supplier.id', 'left');
    }

    private function getDatatablesQuery($tipe = "")
    {
        if (strlen($tipe) == 0) {
            $this->dt = $this->dt;
        } else {
            $this->dt = $this->dt->like('tipe', $tipe);
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables($tipe = "")
    {
        $this->getDatatablesQuery($tipe);
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered($tipe = "")
    {
        $this->getDatatablesQuery($tipe);
        return $this->dt->countAllResults();
    }

    public function countAll($tipe = "")
    {
        if (strlen($tipe) == 0) {
            $tbl_storage = $this->dt = $this->dt;
        } else {
            $tbl_storage = $this->dt = $this->dt->like('tipe', $tipe);
        }
        // $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
