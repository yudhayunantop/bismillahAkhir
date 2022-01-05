<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Peramalan</h1>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Hasil ramal <?= $perusahaan; ?></h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped" id="tabledata">
                    <thead>
                        <th>#</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Hasil Ramal(Rp.)</th>
                    </thead>
                    <tbody>
                    <?php
                        $n=1;
                        for ($i=0;$i<12;$i++) : ?>
                        <tr>
                            <td width="50"><?= $n++; ?>.</td>
                            <td width="50"><?= $tahunBaru[$i]; ?></td>
                            <td width="50"><?= $bulanBaru[$i]; ?></td>
                            <td width="50"><?= $dataJadi[$i]; ?></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer'); ?>