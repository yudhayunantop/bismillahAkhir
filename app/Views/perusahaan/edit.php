<?= view('templates/header'); ?>
<?= view('templates/sidebar'); ?>

<div class="content-wrapper">
    <form action="/perusahaan/update/<?= $perusahaan['ID_PERUSAHAAN']; ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="input_idperusahaan" value="<?= $perusahaan['ID_PERUSAHAAN']; ?>">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?= $title; ?></h1>
                    </div>
                    <div class="text-right col-sm-6">
                        <a href="perusahaan/" class="btn btn-default">
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
                                <label for="input_nama">Nama Perusahaan</label>
                                <input id="input_nama" name="input_nama" class="form-control <?= ($validation->hasError('input_nama')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Nama..." autofocus value="<?= (old('input_nama')) ? old('input_nama') : $perusahaan['NAMA_PERUSAHAAN'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_nama'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_alamat">Alamat</label>
                                <input id="input_alamat" name="input_alamat" class="form-control <?= ($validation->hasError('input_alamat')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Alamat..." value="<?= (old('input_alamat')) ? old('input_alamat') : $perusahaan['ALAMAT'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_alamat'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_notelp">No. Telp</label>
                                <input id="input_notelp" name="input_notelp" class="form-control <?= ($validation->hasError('input_notelp')) ? 'is-invalid' : ''; ?>" type="text" placeholder="No. Telp..." value="<?= (old('input_notelp')) ? old('input_notelp') : $perusahaan['NO_TELP'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_notelp'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_limit">Limit</label>
                                <input id="input_limit" name="input_limit" class="form-control <?= ($validation->hasError('input_limit')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Limit..." value="<?= (old('input_limit')) ? old('input_limit') : $perusahaan['LIMIT_PERUSAHAAN'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_limit'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_hargaover">Harga Over</label>
                                <input id="input_hargaover" name="input_hargaover" class="form-control <?= ($validation->hasError('input_hargaover')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Harga..." value="<?= (old('input_hargaover')) ? old('input_hargaover') : $perusahaan['HARGA_OVER'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_hargaover'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_biayasewa">Biaya Sewa</label>
                                <input id="input_biayasewa" name="input_biayasewa" class="form-control <?= ($validation->hasError('input_biayasewa')) ? 'is-invalid' : ''; ?>" type="text" placeholder="Biaya..." value="<?= (old('input_biayasewa')) ? old('input_biayasewa') : $perusahaan['BIAYA_SEWA'] ?>">
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_biayasewa'); ?>
                                </div>
                        </div>
                        <div class="form-group">
                                <label for="input_mesin">Mesin Fotocopy</label>
                                <select name="input_mesin" id="input_mesin" class="form-control">
                                    <?php foreach($StokMesin as $row):?>
                                        <?php if ($perusahaan['ID_MESIN']==$row['ID_MESIN']):?>
                                            <option value="<?= $row['ID_MESIN']?>" selected><?= $row['NAMA_MESIN']?></option>
                                        <?php else:?>
                                            <option value="<?= $row['ID_MESIN']?>"><?= $row['NAMA_MESIN']?></option>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                                <div class="invalid-feedback text-left">
                                    <?= $validation->getError('input_mesin'); ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>

<?= view('templates/footer'); ?>