<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <form action="/persewaandetail/update/<?= $persewaanDetail[0]['ID_PERSEWAAN_DETAIL']; ?>/<?= $idPerusahaan ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="input_idperusahaan" value="<?= $persewaanDetail[0]['ID_PERSEWAAN_DETAIL']; ?>">
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
                    <div class="card-body">
                        <div class="form-group">
                                <label for="input_tanggaltagih">Tanggal Tagih</label>
                                <input id="input_tanggaltagih" name="input_tanggaltagih" class="form-control gijgo <?= ($validation->hasError('input_tanggaltagih')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Nama..." autofocus value="<?= (old('input_tanggaltagih')) ? old('input_tanggaltagih') : $persewaanDetail[0]['TANGGAL_TAGIH'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_tanggaltagih'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_tanggalbayar">Tanggal Bayar</label>
                                <input id="input_tanggalbayar" name="input_tanggalbayar" class="form-control gijgo2 <?= ($validation->hasError('input_tanggalbayar')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Alamat..." value="<?= (old('input_tanggalbayar')) ? old('input_tanggalbayar') : $persewaanDetail[0]['TANGGAL_BAYAR'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_tanggalbayar'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_counterini">Counter Bulan Ini</label>
                                <input id="input_counterini" name="input_counterini" class="form-control <?= ($validation->hasError('input_counterini')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Limit..." value="<?= (old('input_counterini')) ? old('input_counterini') : $persewaanDetail[0]['COUNTER_BULAN_INI'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_counterini'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_counterlalu">Counter Bulan Lalu</label>
                                <input id="input_counterlalu" name="input_counterlalu" class="form-control <?= ($validation->hasError('input_counterlalu')) ? 'is-invalid' : ''; ?>" type="text" placeholder="No. Telp..." value="<?= (old('input_counterlalu')) ? old('input_counterlalu') : $persewaanDetail[0]['COUNTER_BULAN_LALU'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_counterlalu'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_kertasrusak">Kertas Rusak</label>
                                <input id="input_kertasrusak" name="input_kertasrusak" class="form-control <?= ($validation->hasError('input_kertasrusak')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Harga..." value="<?= (old('input_kertasrusak')) ? old('input_kertasrusak') : $persewaanDetail[0]['KERTAS_RUSAK'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_kertasrusak'); ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>

<?= view('templates/footer'); ?>