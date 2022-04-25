<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Penjualan Bulanan Kotor
        </h3>
    </div>
    <div class="card-body" style="height: 40vh;">
        <canvas id="monthly-gross-sales"></canvas>
    </div>
</div>
<script defer>
    const label = [
        <?php foreach ($sales as $row) : ?>
            <?= "'" . $row['tahun_bulan'] . "'" . ','; ?>
        <?php endforeach ?>
    ];
    const data = {
        labels: label,
        datasets: [{
            label: 'Penjualan (Rp)',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [
                <?php foreach ($sales as $row) : ?>
                    <?= $row['jumlah'] . ','; ?>
                <?php endforeach ?>
            ]
        }]
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    };
</script>