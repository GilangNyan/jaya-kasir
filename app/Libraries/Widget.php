<?php

namespace App\Libraries;

use App\Models\Admin\WidgetModel;

class Widget
{
    public function grossSales()
    {
        $model = new WidgetModel();
        $gross = $model->grossSales();
        $data['gross'] = number_format($gross['total_bruto'], 2, ',', '.');
        return view('admin/layout/widget/gross_sales', $data);
    }

    public function netSales()
    {
        $model = new WidgetModel();
        $net = $model->netSales();
        $data['net'] = number_format($net, 2, ',', '.');
        return view('admin/layout/widget/net_sales', $data);
    }

    public function diskon()
    {
        $model = new WidgetModel();
        $diskon = $model->diskon();
        $data['diskon'] = number_format($diskon, 2, ',', '.');
        return view('admin/layout/widget/diskon', $data);
    }

    public function grossProfit()
    {
        $model = new WidgetModel();
        $grossProfit = $model->grossProfit();
        $data['gprofit'] = number_format($grossProfit, 2, ',', '.');
        return view('admin/layout/widget/gross_profit', $data);
    }

    public function grossSalesMonthly()
    {
        $model = new WidgetModel();
        $data['sales'] = $model->grossSalesMonthly();
        return view('admin/layout/widget/monthly_gross_sales', $data);
    }

    public function dailySales()
    {
        $model = new WidgetModel();
        $data['sales'] = $model->dailySales();
        return view('admin/layout/widget/daily_sales', $data);
    }
}
