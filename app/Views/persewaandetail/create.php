<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <form action="/persewaandetail/save/<?= $idPerusahaan?>" method="POST">
        <input type="hidden" value="<?= $idPerusahaan?>" name="input_idperusahaan" id="input_idperusahaan">
    <?= csrf_field(); ?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?= $title; ?></h1>
                    </div>
                    <div class="text-right col-sm-6">
                        <a href="<?= base_url("persewaandetail/".$idPerusahaan)?>" class="btn btn-default">
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
                    <?php if (isset($_SESSION['pesan'])): ?>
                        <div class="alert alert-warning" role="alert">
                            <?= $_SESSION['pesan']; ?>
                        </div>
                    <?php endif;?>
                    <div class="card-body">
                        <div class="form-group">
                                <label for="input_tanggaltagih">Tanggal Tagih</label>
                                <input id="post_data" name="input_tanggaltagih" class="form-control gijgo <?= ($validation->hasError('input_tanggaltagih')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Tanggal Tagih..." autofocus value="<?= old('input_tanggaltagih')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_tanggaltagih'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                        <label for="input_tanggalbayar">Tanggal Bayar</label>
                                <input id="post_date" name="input_tanggalbayar" class="form-control gijgo2 <?= ($validation->hasError('input_tanggalbayar')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Tanggal Bayar..." value="<?= old('input_tanggalbayar')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_tanggalbayar'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_counterini">Counter Bulan Ini</label>
                                <input id="input_counterini" name="input_counterini" class="form-control <?= ($validation->hasError('input_counterini')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Counter Bulan ini..." value="<?= old('input_counterini')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_counterini'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_counterlalu">Counter Bulan Lalu</label>
                                <input id="input_counterlalu" name="input_counterlalu" class="form-control <?= ($validation->hasError('input_counterlalu')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Counter Bulan Lalu..." value="<?= old('input_counterlalu')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_counterlalu'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_kertasrusak">Kertas Rusak</label>
                                <input id="input_kertasrusak" name="input_kertasrusak" class="form-control <?= ($validation->hasError('input_kertasrusak')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Kertas Rusak..." value="<?= old('input_kertasrusak')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_kertasrusak'); ?>
                                </div>
                        </div>
                        <!-- <div class="form-group">
                                <label for="input_kelebihanpemakaian">Kelebihan Pemakaian</label>
                                <input id="input_kelebihanpemakaian" name="input_kelebihanpemakaian" class="form-control <?= ($validation->hasError('input_kelebihanpemakaian')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Kelebihan Pemakaian..." value="<?= old('input_kelebihanpemakaian')?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_kelebihanpemakaian'); ?>
                                </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>

<?= view('templates/footer'); ?>