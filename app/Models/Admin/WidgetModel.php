<?php

namespace App\Models\Admin;

use CodeIgniter\Config\Config;
use CodeIgniter\Model;
use Config\Services;

class WidgetModel extends Model
{
    public function grossSales()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');

        $builder->selectSum('total_bruto');

        return $builder->get()->getRowArray();
    }

    public function netSales()
    {
        $grossSales = $this->grossSales();
        $diskon = $this->diskon();

        $netSales = $grossSales['total_bruto'] - $diskon;

        return $netSales;
    }

    public function diskon()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');

        $builder->selectSum('diskon_uang');
        $builder->selectSum('total_bruto * (diskon_persen / 100)', 'dispersen');
        $hasilquery = $builder->get()->getRowArray();
        $hasil = $hasilquery['diskon_uang'] + $hasilquery['dispersen'];

        $query = $db->query("SELECT SUM(a.qty * a.diskon) AS total_diskon FROM ( SELECT qty, diskon FROM penjualan_detail WHERE diskon != 0 ) a")->getRowArray();

        $hasil = $hasil + $query['total_diskon'];

        return $hasil;
    }

    public function grossProfit()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan_detail');

        $builder->selectSum('harga_beli');
        $modalBarang = $builder->get()->getRowArray();
        $netSales = $this->netSales();

        $grossProfit = $netSales - $modalBarang['harga_beli'];

        return $grossProfit;
    }

    public function grossSalesMonthly()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM (SELECT DATE_FORMAT(tanggal, '%Y/%m') AS tahun_bulan, SUM(total_bruto) as jumlah FROM `penjualan` GROUP BY tahun_bulan ORDER BY tahun_bulan DESC LIMIT 6)Var1 ORDER BY tahun_bulan ASC");

        return $query->getResultArray();
    }

    public function dailySales()
    {
        $db = \Config\Database::connect();
        // $query = $db->query("SELECT * FROM (SELECT tanggal, DAYNAME(tanggal) as hari, SUM(total_bruto) as jumlah FROM `penjualan` GROUP BY tanggal ORDER BY tanggal DESC LIMIT 7)Var1 ORDER BY tanggal ASC");
        $query = $db->query("
        SELECT
            IF(SUM(total_bruto) IS NULL, 0, SUM(total_bruto)) AS jumlah,
            b.Days AS tanggal,
            DAYNAME(b.Days) as hari
        FROM
            (SELECT a.Days
            FROM (
                SELECT curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS Days
                FROM		(SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                CROSS JOIN	(SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                CROSS JOIN	(SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
            ) a
            WHERE a.Days >= curdate() - INTERVAL 6 DAY) b
        LEFT JOIN penjualan
            ON tanggal = b.Days
        GROUP BY b.Days
        ORDER BY b.Days");

        return $query->getResultArray();
    }
}
