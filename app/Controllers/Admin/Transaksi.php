<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\MemberModel;
use App\Models\Admin\ProdukModel;
use App\Models\Admin\TransaksiModel;
use Config\Services;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
// use Mike42\Escpos\EscposImage;

class Transaksi extends BaseController
{
    public function index()
    {
        $memberModel = new MemberModel();

        $data['title'] = 'Transaksi';
        $data['faktur'] = $this->buatFaktur();
        $data['member'] = $memberModel->findAll();
        return view('admin/transaksi', $data);
    }

    public function buatFaktur()
    {
        $model = new TransaksiModel();
        $tanggal = date('Y-m-d');
        $maxfaktur = $model->getMaxFaktur($tanggal);
        $data = $maxfaktur['nofaktur'];

        // Ambil 4 angka terakhir
        $lastNoUrut = substr($data, -4);

        // Nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;

        // Buat nomor faktur berikutnya
        $faktur = 'J' . date('dmy', strtotime($tanggal)) . sprintf('%05s', $nextNoUrut);
        return $faktur;
    }

    public function dataCart()
    {
        $model = new TransaksiModel();
        $nofaktur = $this->request->getPost('nofaktur');
        $tampilData = $model->detailCart($nofaktur);

        $data = [
            'datadetail' => $tampilData
        ];

        $msg = [
            'data' => view('admin/transaksi_detail', $data)
        ];

        return json_encode($msg);
    }

    public function viewProduk()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'viewmodal' => view('admin/modal_cariproduk', $data)
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
                    $row[] = "<button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"tambahKeCart('" . $list->id . "', '" . $list->barcode . "', '" . $list->nama . "', '" . $list->stok . "', '" . $list->harga_jual . "')\"><i class=\"fas fa-shopping-cart\"></i></button>";
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
            $id = $this->request->getPost('id');
            $kodebarcode = $this->request->getPost('barcode');
            $namaproduk = $this->request->getPost('namaproduk');
            $jumlah = $this->request->getPost('jumlah');
            $nofaktur = $this->request->getPost('nofaktur');

            $request = Services::request();
            $model = new ProdukModel($request);
            $cekProduk = $model->cekProduk($kodebarcode, $namaproduk);

            if (count($cekProduk) > 1) {
                $msg = ['totaldata' => 'banyak'];
            } else if (count($cekProduk) == 1) {
                $transmodel = new TransaksiModel();
                $msg = $transmodel->addToCart($kodebarcode, $namaproduk, $nofaktur, $jumlah);
            } else {
                $msg = ['error' => 'Produk tidak ditemukan'];
            }

            return json_encode($msg);
        }
    }

    public function hitungTotalBayar()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $model = new TransaksiModel();
            $total = $model->totalBayar($nofaktur);

            $msg = [
                'totalbayar' => $total[0]['totalbayar']
            ];

            return json_encode($msg);
        }
    }

    public function getItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $model = new TransaksiModel();
            $msg['item'] = $model->getItemCart($id);
            return json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $model = new TransaksiModel();
            $hapusItem = $model->hapusItemCart($id);

            if ($hapusItem) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }

            return json_encode($msg);
        }
    }

    public function editItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('itemid');

            $model = new TransaksiModel();
            $editItem = $model->editItemCart($id);

            return json_encode($editItem);
        }
    }

    public function pembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tanggal = $this->request->getPost('tanggal');
            $member = $this->request->getPost('member');

            $model = new TransaksiModel();
            $cekData = count($model->getAllFromCart($nofaktur));
            $total = $model->totalBayar($nofaktur);
            if ($cekData > 0) {
                $data = [
                    'nofaktur' => $nofaktur,
                    'member' => $member,
                    'totalbayar' => $total[0]['totalbayar']
                ];

                $msg = [
                    'data' => view('admin/modal_pembayaran', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Produk masih kosong'
                ];
            }
            return json_encode($msg);
        }
    }

    public function simpanPembayaran()
    {
        $faktur = $this->request->getPost('faktur');
        $kodemember = $this->request->getPost('kodemember') == '-' ? null : $this->request->getPost('kodemember');
        $totalkotor = $this->request->getPost('totalkotor');
        $totalbersih = str_replace(".", "", $this->request->getPost('totalbersih'));
        $dispersen = str_replace(".", "", $this->request->getPost('dispersen'));
        $disuang = str_replace(".", "", $this->request->getPost('disrupiah'));
        $jmluang = str_replace(".", "", $this->request->getPost('jumlahuang'));
        $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

        $model = new TransaksiModel();
        $dataPenjualan = [
            'faktur' => $faktur,
            'tanggal' => date('Y-m-d H:i:s'),
            'id_kasir' => user()->id,
            'id_member' => $kodemember,
            'diskon_uang' => $disuang,
            'diskon_persen' => $dispersen,
            'total_bruto' => $totalkotor,
            'total_netto' => $totalbersih,
            'bayar' => $jmluang,
            'kembali' => $sisauang
        ];
        $model->insertKePenjualan($dataPenjualan);
        $model->insertDetailPenjualan($faktur);

        $msg = [
            'sukses' => 'berhasil',
            'nofaktur' => $faktur
        ];

        return json_encode($msg);
    }

    public function batalTransaksi()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $model = new TransaksiModel();
            $hapusCart = $model->kosongkanCart($nofaktur);

            if ($hapusCart) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }

            return json_encode($msg);
        }
    }

    public function cetakStruk()
    {
        if ($this->request->isAJAX()) {
            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector("posprinter_gilang");
            $printer = new Printer($connector, $profile);

            $model = new TransaksiModel();
            $nofaktur = $this->request->getPost('nofaktur');

            // Bagian Nama Toko dan Alamat
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Jaya Raksa Copy Center\n");
            $printer->setEmphasis(false);
            $printer->text("Kp. Cihanjuang RT 03 RW 02\n");
            $printer->feed();

            // Bagian Nomor Faktur dan Waktu
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Faktur: $nofaktur\n");
            $printer->text("Waktu: " . date('d F Y') . "\n");
            $printer->text("Kasir: " . (user()->fullname ? user()->fullname : user()->username) . "\n");
            $printer->text("================================");
            $printer->feed();

            // Bagian isi
            $dataBarang = $model->getPenjualanDetail($nofaktur);
            $jumlah = $model->getTransaksi($nofaktur);
            foreach ($dataBarang as $row) {
                $printer->text($row['nama_produk'] . "\n");
                if ($row['diskon'] != 0) {
                    $printer->text($this->tigaKolom('', 'disc.', $row['diskon']));
                }
                $printer->text($this->tigaKolom($row['qty'] . $row['satuan'], $row['harga_produk'], $row['subtotal']));
            }
            $printer->text($this->duaKolom(" ", "----------"));
            $printer->text($this->duaKolom("Total", $jumlah['total_bruto']));
            if ($jumlah['diskon_uang'] != 0) {
                $printer->text($this->duaKolom("Diskon Rp.", $jumlah['diskon_uang']));
            }
            if ($jumlah['diskon_persen'] != 0) {
                $printer->text($this->duaKolom("Diskon %", $jumlah['diskon_persen']));
            }
            $printer->text($this->duaKolom("Subtotal", $jumlah['total_netto']));
            $printer->text($this->duaKolom("Bayar", $jumlah['bayar']));
            $printer->text($this->duaKolom("Kembali", $jumlah['kembali']));
            $printer->feed();

            // Bagian footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("- Terima Kasih -\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->feed();

            // Potong dan akhiri print
            $printer->cut();
            $printer->close();
            return "Berhasil cetak struk";
        }
    }

    // Fungsi untuk styling hasil cetak struk
    private function tigaKolom($kolom1, $kolom2, $kolom3)
    {
        // Mengatur lebar setiap kolom
        $lebarKolom1 = 10;
        $lebarKolom2 = 10;
        $lebarKolom3 = 10;

        // Melakukan Word Wrap, menambahkan baris baru jika karakter terlalu banyak
        $kolom1 = wordwrap($kolom1, $lebarKolom1, "\n", true);
        $kolom2 = wordwrap($kolom2, $lebarKolom2, "\n", true);
        $kolom3 = wordwrap($kolom3, $lebarKolom3, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);
        $kolom2Array = explode("\n", $kolom2);
        $kolom3Array = explode("\n", $kolom3);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

        // Mendeklarasikan variabel untuk menampung kolom yang sudah diedit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap) untuk menggabungkan setiap kolom menjadi satu baris
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
            // Memberikan spasi pada setiap cell berdasarkan lebar yang ditentukan
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebarKolom1, " ");
            // Memberikan rata kanan pada kolom 2 dan 3 untuk harga dan total
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebarKolom2, " ", STR_PAD_LEFT);
            $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebarKolom3, " ", STR_PAD_LEFT);

            // Menggabungkan kolom menjadi satu baris dan ditampung ke variabel hasil
            $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
        }

        // Hasil yang berupa Array, disatukan kembali menjadi string dan tambahan \n di setiap barisnya
        return implode($hasilBaris) . "\n";
    }

    private function duaKolom($kolom1, $kolom2)
    {
        // Mengatur lebar setiap kolom
        $lebarKolom1 = 21;
        $lebarKolom2 = 10;

        // Melakukan Word Wrap, menambahkan baris baru jika karakter terlalu banyak
        $kolom1 = wordwrap($kolom1, $lebarKolom1, "\n", true);
        $kolom2 = wordwrap($kolom2, $lebarKolom2, "\n", true);

        // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
        $kolom1Array = explode("\n", $kolom1);
        $kolom2Array = explode("\n", $kolom2);

        // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
        $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

        // Mendeklarasikan variabel untuk menampung kolom yang sudah diedit
        $hasilBaris = array();

        // Melakukan perulangan setiap baris (yang dibentuk wordwrap) untuk menggabungkan setiap kolom menjadi satu baris
        for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {
            // Memberikan spasi pada setiap cell berdasarkan lebar yang ditentukan
            $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebarKolom1, " ", STR_PAD_LEFT);
            // Memberikan rata kanan pada kolom 2 untuk harga dan total
            $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebarKolom2, " ", STR_PAD_LEFT);

            // Menggabungkan kolom menjadi satu baris dan ditampung ke variabel hasil
            $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
        }

        // Hasil yang berupa Array, disatukan kembali menjadi string dan tambahan \n di setiap barisnya
        return implode($hasilBaris) . "\n";
    }
}
