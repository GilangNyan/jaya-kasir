<?php

namespace App\Models\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class LaporanPenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'faktur';

    protected $autoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['faktur', 'tanggal', 'id_kasir', 'id_member', 'diskon_uang', 'diskon_persen', 'total_bruto', 'total_netto', 'bayar', 'deleted_at'];

    // Variabel untuk datatables server-side
    protected $column_order = [null, 'faktur', 'tanggal', 'customer', 'total', 'diskon', 'grand', null];
    protected $column_search = ['faktur', 'customer'];
    protected $order = ['tanggal' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)->join('member', 'penjualan.id_member = member.id', 'left');
    }

    private function getDatatablesQuery()
    {
        if ($this->request->getPost('periode') != '') {
            $periode = explode(' ', $this->request->getPost('periode'));
            $awal = strtotime(str_replace('/', '-', $periode[0]));
            $akhir = strtotime(str_replace('/', '-', $periode[2]));
            $dtawal = date('Y-m-d', $awal);
            $dtakhir = date('Y-m-d', $akhir);
            $this->dt = $this->dt->where("tanggal BETWEEN '$dtawal' AND '$dtakhir'", null, false);
        }
        if ($this->request->getPost('customer') != '-') {
            $customer = $this->request->getPost('customer');
            $this->dt = $this->dt->where('id_member', $customer);
        }
        if ($this->request->getPost('faktur') != '') {
            $faktur = $this->request->getPost('faktur');
            $this->dt = $this->dt->like('faktur', $faktur);
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

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1) {
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        }
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    public function getDataFaktur($faktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder2 = $db->table('penjualan_detail');

        $penjualan = $builder->join('users', 'penjualan.id_kasir = users.id', 'LEFT')->join('member', 'penjualan.id_member = member.id', 'LEFT')->getWhere(['faktur' => $faktur])->getRowArray();
        $detail = $builder2->join('produk', 'penjualan_detail.barcode = produk.barcode')->join('satuan', 'produk.satuan = satuan.id')->getWhere(['faktur' => $faktur])->getResultArray();

        $data = [
            'penjualan' => $penjualan,
            'detail' => $detail
        ];

        return $data;
    }
}
