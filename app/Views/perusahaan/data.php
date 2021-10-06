<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Perusahaan</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Perusahaan</li>
            </ol>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h5 class="card-title">Daftar Perusahaan</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <a href="/perusahaan/create" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> New Perusahaan</a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped" id="tabledata">
                    <thead>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Limit</th>
                        <th>Harga Over</th>
                        <th>Biaya Sewa</th>
                        <th>Nama Mesin</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        foreach ($perusahaan as $row) : ?>
                            <tr>
                                <td width="50"><?= $n++; ?>.</td>
                                <td width="100"><?= $row['NAMA_PERUSAHAAN']; ?></td>
                                <td width="100"><?= $row['ALAMAT']; ?></td>
                                <td width="100"><?= $row['NO_TELP']; ?></td>
                                <td width="100"><?= $row['LIMIT_PERUSAHAAN']; ?></td>
                                <td width="100"><?= $row['HARGA_OVER']; ?></td>
                                <td width="100"><?= $row['BIAYA_SEWA']; ?></td>
                                <td width="100"><?= $row['NAMA_MESIN']; ?></td>
                                <td width="100" class="text-right">
                                    <div class="btn-group">
                                        <a href="/perusahaan/edit/<?= $row['ID_PERUSAHAAN']; ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                                        <form action="/perusahaan/delete/<?= $row['ID_PERUSAHAAN']; ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="Hapus">
                                            <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('apakah anda yakin?');"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <a href="/persewaandetail/<?= $row['ID_PERUSAHAAN']; ?>" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
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