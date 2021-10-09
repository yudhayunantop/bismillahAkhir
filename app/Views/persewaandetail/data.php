<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Persewaan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/perusahaan">Perusahaan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Data Detail Persewaan</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <form action="<?= base_url("persewaandetail/create/".$idPerusahaan) ?>" method="POST" class="d-inline">
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New Persewaan</button>
                    </form>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped" id="tabledata">
                    <?php if (isset($_SESSION['pesan'])): ?>
                        <div class="alert alert-warning" role="alert">
                            <?= $_SESSION['pesan']; ?>
                        </div>
                    <?php endif;?>
                    <thead>
                        <th>#</th>
                        <th>Tanggal Tagih</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah Tagihan</th>
                        <th>Counter Bulan Lalu</th>
                        <th>Counter Bulan ini</th>
                        <th>Selisih Counter</th>
                        <th>Kertas Rusak</th>
                        <th>Netto</th>
                        <th>Kelebihan Pemakaian</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($persewaanDetail as $row) : ?>
                            <tr>
                                <td width="50"><?= $n++; ?>.</td>
                                <td width="100"><?= $row['TANGGAL_TAGIH']; ?></td>
                                <td width="100"><?= $row['TANGGAL_BAYAR']; ?></td>
                                <td width="100"><?= $row['JUMLAH_TAGIHAN']; ?></td>
                                <td width="100"><?= $row['COUNTER_BULAN_LALU']; ?></td>
                                <td width="100"><?= $row['COUNTER_BULAN_INI']; ?></td>
                                <td width="100"><?= $row['SELISIH_COUNTER']; ?></td>
                                <td width="100"><?= $row['KERTAS_RUSAK']; ?></td>
                                <td width="100"><?= $row['NETTO']; ?></td>
                                <td width="100"><?= $row['KELEBIHAN_PEMAKAIAN']; ?></td>
                                <td width="100" class="text-right">
                                    <div class="btn-group">
                                        <!-- <a href="/persewaandetail/edit/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a> -->
                                        <form action="/persewaandetail/edit/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></button>
                                        </form>
                                        <form action="/persewaandetail/delete/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="Hapus">
                                            <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('apakah anda yakin?');"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <form action="/persewaandetail/cetakcounter/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-file-invoice"></i></i></button>
                                        </form>
                                        <form action="/persewaandetail/cetaktagihan/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-file-invoice-dollar"></i></button>
                                        </form>
                                        <form action="/persewaandetail/hitungsse/<?= $row['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-coins"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer'); ?>