<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengelolaan Data RW</h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('beranda') ?>"><i class="fa fa-home"></i> Beranda</a></li>
            <li><a href="<?= site_url('wilayah/clear') ?>"> Daftar <?= ucwords($this->setting->sebutan_dusun) ?></a></li>
            <li><a href="<?= site_url("wilayah/sub_rw/{$id_dusun}") ?>"> Daftar RW</a></li>
            <li class="active">Data RW</li>
        </ol>
    </section>
    <section class="content" id="maincontent">
        <div class="box box-info">
            <div class="box-header with-border">
                <a href="<?= site_url("wilayah/sub_rw/{$id_dusun}") ?>" class="btn btn-social btn-flat btn-info btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"  title="Kembali Ke Daftar RW">
                    <i class="fa fa-arrow-circle-left "></i>Kembali ke Daftar RW
                </a>
            </div>
            <form id="validasi" action="<?= $form_action?>" method="POST" enctype="multipart/form-data"  class="form-horizontal">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="rw">Nama RW</label>
                        <div class="col-sm-7">
                            <?php if ($id_rw): ?>
                                <input type="hidden" name="id_rw" value="<?= $id_rw?>">
                            <?php endif; ?>
                            <input  id="rw" class="form-control input-sm digits required" maxlength="10" type="text" placeholder="Nama RW" name="rw" value="<?= $rw ?>">
                        </div>
                    </div>
                    <?php if ($individu): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="kepala_lama">Kepala RW Sebelumnya</label>
                            <div class="col-sm-7">
                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                    <strong><?= $individu['nama']?></strong>
                                    <br/>NIK - <?= $individu['nik']?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="id_kepala">NIK / Nama Kepala RW</label>
                        <div class="col-sm-7">
                            <select class="form-control select2 select2-infinite" data-url="wilayah/apipendudukwilayah" style="width: 100%;" id="id_kepala" name="id_kepala">
                                <option selected="selected">-- Silakan Masukan NIK / Nama--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="reset" class="btn btn-social btn-flat btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
                    <button type="submit" class="btn btn-social btn-flat btn-info btn-sm pull-right"><i class="fa fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>
    </section>
</div>
<?php $this->load->view('global/validasi_form'); ?>
