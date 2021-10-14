<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Peramalan Data Tagihan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Peramalan</li>
            </ol>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">List <?= $title; ?></h5>
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
                        <th>Nama</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                    <?php
                        $n = 1;
                        foreach ($perusahaan as $row) : ?>
                        <tr>
                            <td width="50"><?= $n++; ?>.</td>
                            <td width="100"><?= $row['NAMA_PERUSAHAAN']; ?></td>
                            <td width="50" class="text-left">
                                <div class="btn-group">
                                    <form action="/peramalan/ramal/<?= $row['ID_PERUSAHAAN']; ?>" method="POST" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-chart-line"></i></button>
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