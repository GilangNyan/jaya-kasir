<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Penjualan Harian
        </h3>
    </div>
    <div class="card-body" style="height: 40vh;">
        <canvas id="daily-sales"></canvas>
    </div>
</div>
<script defer>
    const labelDailySales = [
        <?php foreach ($sales as $row) : ?>
            <?= "'" . $row['hari'] . "'" . ','; ?>
        <?php endforeach ?>
    ];
    const dataDailySales = {
        labels: labelDailySales,
        datasets: [{
            label: 'Penjualan (Rp)',
            backgroundColor: 'rgb(33, 39, 156)',
            borderColor: 'rgb(33, 39, 156)',
            data: [
                <?php foreach ($sales as $row) : ?>
                    <?= $row['jumlah'] . ','; ?>
                <?php endforeach ?>
            ]
        }]
    };
    const configDailySales = {
        type: 'bar',
        data: dataDailySales,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    };
</script>