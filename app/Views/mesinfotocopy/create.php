<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <form action="/mesinfotocopy/save" method="POST">
    <?= csrf_field(); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?= $title; ?></h1>
                    </div>
                    <div class="text-right col-sm-6">
                        <a href="/mesinfotocopy" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="col-md-8 order-last order-md-first">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title"><?= $title; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                                <label for="input_nama">Nama Mesin</label>
                                <input id="input_nama" name="input_nama" class="form-control <?= ($validation->hasError('input_nama')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Nama..." autofocus value="<?= old('input_nama'); ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_nama'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_stok">Stok</label>
                                <input id="input_stok" name="input_stok" class="form-control <?= ($validation->hasError('input_stok')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Stok..." value="<?= old('input_stok'); ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_stok'); ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>

<?= view('templates/footer'); ?>