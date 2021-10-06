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
                                        <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-calculator"></i></button>
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