<?php

namespace App\Models\Admin;

use CodeIgniter\Config\Config;
use CodeIgniter\Model;
use Config\Services;

class TransaksiModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'faktur';

    protected $autoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['faktur', 'tanggal', 'id_kasir', 'id_member', 'diskon', 'total_bruto', 'total_netto', 'bayar', 'deleted_at'];

    public function getMaxFaktur($tanggal)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');

        $builder->select('MAX(faktur) as nofaktur');
        $builder->where('STR_TO_DATE(faktur, "J%d%m%y")', $tanggal);
        // dd($builder->get()->getRowArray());

        return $builder->get()->getRowArray();
    }

    public function detailCart($nofaktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        $builder->select('detail_id, produk.barcode as barcode, produk.nama as nama_produk, penjualan_temp.harga_jual as harga_produk, qty, diskon, subtotal');
        $builder->join('produk', 'penjualan_temp.barcode = produk.barcode');
        $builder->where('faktur', $nofaktur);
        $builder->orderBy('detail_id', 'asc');

        return $builder->get()->getResultArray();
    }

    public function addToCart($barcode, $namaproduk, $nofaktur, $jumlah)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        $request = Services::request();
        $modelProduk = new ProdukModel($request);

        $rowProduk = $modelProduk->cekProduk($barcode, $namaproduk)[0];

        $stokProduk = $rowProduk['stok'];

        if (intval($stokProduk) == 0) {
            $msg = ['error' => 'Stok produk kosong'];
        } else if ($jumlah > $stokProduk) {
            $msg = ['error' => 'Stok produk tidak mencukupi'];
        } else {
            $insertData = [
                'faktur' => $nofaktur,
                'barcode' => $rowProduk['barcode'],
                'harga_beli' => $rowProduk['harga_beli'],
                'harga_jual' => $rowProduk['harga_jual'],
                'qty' => $jumlah,
                'diskon' => 0,
                'subtotal' =>  $rowProduk['harga_jual'] * $jumlah
            ];

            $builder->insert($insertData);
            $msg = ['sukses' => 'berhasil'];
        }
        return $msg;
    }

    public function totalBayar($nofaktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        $builder->select('SUM(subtotal) as totalbayar');
        $builder->where('faktur', $nofaktur);

        return $builder->get()->getResultArray();
    }

    public function getItemCart($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        return $builder->where('detail_id', $id)->get()->getRowArray();
    }

    public function hapusItemCart($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        return $builder->delete(['detail_id' => $id]);
    }

    public function editItemCart($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        $request = Services::request();
        $modelProduk = new ProdukModel($request);

        $item = $builder->where('detail_id', $id)->get()->getRowArray();
        $rowProduk = $modelProduk->getOneProduk($item['barcode']);

        $stokProduk = $rowProduk['stok'];
        $oldQty = $item['qty'];
        $oldDiskon = $item['diskon'];
        $newQty = $request->getPost('itemqty');
        $newDiskon = $request->getPost('itemdiskon');

        if ((intval($stokProduk) + $oldQty) == 0) {
            $msg = ['error' => 'Stok produk kosong'];
        } else if ($newQty > ($stokProduk + $oldQty)) {
            $msg = ['error' => 'Stok produk tidak mencukupi'];
        } else {
            $data = [
                'qty' => $newQty,
                'diskon' => $newDiskon,
                'subtotal' => ($rowProduk['harga_jual'] - $newDiskon) * $newQty
            ];

            $builder->update($data, "detail_id = $id");
            $msg = [
                'sukses' => 'berhasil',
                'data' => $newQty
            ];
        }
        return $msg;
    }

    public function getAllFromCart($faktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_temp');

        $builder->where('faktur', $faktur);

        return $builder->get()->getResultArray();
    }

    public function insertKePenjualan($data = [])
    {
        $db = \Config\Database::connect();
        $tblPenjualan = $db->table('penjualan');

        return $tblPenjualan->insert($data);
    }

    public function insertDetailPenjualan($faktur)
    {
        $db = \Config\Database::connect();
        $tblTempPenjualan = $db->table('penjualan_temp');
        $tblDetailPenjualan = $db->table('penjualan_detail');

        $ambilTemp = $tblTempPenjualan->getWhere(['faktur' => $faktur]);

        $fieldDetailPenjualan = [];
        foreach ($ambilTemp->getResultArray() as $row) {
            $fieldDetailPenjualan[] = [
                'faktur' => $faktur,
                'barcode' => $row['barcode'],
                'harga_beli' => $row['harga_beli'],
                'harga_jual' => $row['harga_jual'],
                'qty' => $row['qty'],
                'diskon' => $row['diskon'],
                'subtotal' =>  $row['subtotal']
            ];
        }
        $tblTempPenjualan->emptyTable();
        return $tblDetailPenjualan->insertBatch($fieldDetailPenjualan);
    }

    public function kosongkanCart($nofaktur)
    {
        $db = \Config\Database::connect();
        $tblTempPenjualan = $db->table('penjualan_temp');

        return $tblTempPenjualan->delete(['faktur' => $nofaktur]);
    }

    public function getPenjualanDetail($nofaktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_detail');

        $builder->select('detail_id, produk.barcode as barcode, produk.nama as nama_produk, penjualan_detail.harga_jual as harga_produk, satuan.satuan as satuan, qty, diskon, subtotal');
        $builder->join('produk', 'penjualan_detail.barcode = produk.barcode');
        $builder->join('satuan', 'produk.satuan = satuan.id');
        $builder->where('faktur', $nofaktur);
        $builder->orderBy('detail_id', 'asc');

        return $builder->get()->getResultArray();
    }

    public function getTransaksi($nofaktur)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');

        $builder->where('faktur', $nofaktur);

        return $builder->get()->getRowArray();
    }
}
