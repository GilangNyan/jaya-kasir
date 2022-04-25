<?php

namespace App\Models\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'barcode';

    protected $autoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['barcode', 'nama', 'kategori', 'satuan', 'harga_beli', 'harga_jual', 'stok', 'deleted_at'];

    // Variabel untuk DataTable Server-side
    protected $column_order = [null, 'barcode', 'nama', 'produk.kategori', 'satuan.satuan', 'harga_beli', 'harga_jual', 'stok', null];
    protected $column_search = ['barcode', 'nama', 'produk.kategori'];
    protected $order = ['nama' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->join('kategori', 'produk.kategori = kategori.id', 'left')->join('satuan', 'produk.satuan = satuan.id', 'left');
    }

    public function getProduk()
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        $builder->select('*');
        $builder->join('kategori', 'produk.kategori = kategori.id', 'left');
        $builder->join('satuan', 'produk.satuan = satuan.id', 'left');

        return $builder->get()->getResultArray();
    }

    public function cekProduk($barcode, $namaproduk)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        if (strlen($namaproduk) > 0) {
            $builder->where('barcode', $barcode);
            $builder->where('nama', $namaproduk);
        } else {
            $builder->like('barcode', $barcode);
            $builder->orLike('nama', $barcode);
        }

        return $builder->get()->getResultArray();
    }

    public function getOneProduk($barcode)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        $builder->join('satuan', 'produk.satuan = satuan.id', 'left');
        $builder->like('barcode', $barcode);
        $builder->orLike('nama', $barcode);
        return $builder->get()->getRowArray();
    }

    public function batchInsert($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        $builder->insertBatch($data);
    }

    public function batchUpdate($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);

        $builder->updateBatch($data, 'barcode');
    }

    // Method untuk kebutuhan DataTable server-side
    private function getDatatablesQuery($keywordkode = "")
    {
        if (strlen($keywordkode) == 0) {
            $this->dt = $this->dt;
        } else {
            $this->dt = $this->dt->like('barcode', $keywordkode)->orLike('nama', $keywordkode);
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
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
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

    public function getDatatables($keywordkode = "")
    {
        $this->getDatatablesQuery($keywordkode);
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered($keywordkode = "")
    {
        $this->getDatatablesQuery($keywordkode);
        return $this->dt->countAllResults();
    }

    public function countAllData($keywordkode = "")
    {
        if (strlen($keywordkode) == 0) {
            $tbl_storage = $this->dt;
        } else {
            $tbl_storage = $this->dt->like('barcode', $keywordkode)->orLike('nama', $keywordkode);
        }
        // $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}
