<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\LaporanPenjualanModel;
use App\Models\Admin\MemberModel;
use Config\Services;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class LaporanPenjualan extends BaseController
{
    public function index()
    {
        $data['title'] = "Laporan Penjualan";
        // $request = Services::request();
        $memberModel = new MemberModel();
        $data['member'] = $memberModel->findAll();

        return view('admin/lappenjualan', $data);
    }

    public function listLapPenjualan()
    {
        $request = Services::request();
        $datatable = new LaporanPenjualanModel($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tanggal;
                $row[] = $list->nama_lengkap;
                $row[] = number_format($list->total_bruto, 2, ',', '.');
                $row[] = number_format($list->diskon_uang + (floatval($list->total_bruto) * floatval($list->diskon_persen) / 100), 2, ',', '.');
                $row[] = number_format($list->total_netto, 2, ',', '.');
                $row[] = "<button class=\"btn btn-secondary btn-xs\" type=\"submit\" onclick=\"showDetailModal('$list->faktur')\" title=\"Lihat\"><i class=\"fas fa-eye mr-1\"></i>Lihat</button>
                <button class=\"btn btn-danger btn-xs\" type=\"submit\" onclick=\"hapus('$list->faktur', '$list->faktur')\" title=\"Hapus\"><i class=\"fas fa-trash-alt mr-1\"></i>Hapus</button>";
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

    public function getDataFaktur()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $model = new LaporanPenjualanModel($request);
            $faktur = $this->request->getPost('faktur');

            $datafaktur = $model->getDataFaktur($faktur);

            return json_encode($datafaktur);
        }
    }

    public function printStruk()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $model = new LaporanPenjualanModel($request);
            $faktur = $this->request->getPost('faktur');

            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector("posprinter_gilang");
            $printer = new Printer($connector, $profile);

            $model->getDataFaktur($faktur);

            // Bagian Nama Toko dan Alamat
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Jaya Raksa Copy Center\n");
            $printer->setEmphasis(false);
            $printer->text("Kp. Cihanjuang RT 03 RW 02\n");
            $printer->feed();

            // Bagian Nomor Faktur dan Waktu
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Faktur: $faktur\n");
            $printer->text("Waktu: " . date('d F Y') . "\n");
            $printer->text("Kasir: " . (user()->fullname ? user()->fullname : user()->username) . "\n");
            $printer->text("================================");
            $printer->feed();

            // Bagian isi
            $data = $model->getDataFaktur($faktur);
            foreach ($data['detail'] as $row) {
                $printer->text($row['nama'] . "\n");
                if ($row['diskon'] != 0) {
                    $printer->text($this->tigaKolom('', 'disc.', $row['diskon']));
                }
                $printer->text($this->tigaKolom($row['qty'] . $row['satuan'], $row['harga_jual'], $row['subtotal']));
            }
            $printer->text($this->duaKolom(" ", "----------"));
            $printer->text($this->duaKolom("Total", $data['penjualan']['total_bruto']));
            if ($data['penjualan']['diskon_uang'] != 0) {
                $printer->text($this->duaKolom("Diskon Rp.", $data['penjualan']['diskon_uang']));
            }
            if ($data['penjualan']['diskon_persen'] != 0) {
                $printer->text($this->duaKolom("Diskon %", $data['penjualan']['diskon_persen']));
            }
            $printer->text($this->duaKolom("Subtotal", $data['penjualan']['total_netto']));
            $printer->text($this->duaKolom("Bayar", $data['penjualan']['bayar']));
            $printer->text($this->duaKolom("Kembali", $data['penjualan']['kembali']));
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
