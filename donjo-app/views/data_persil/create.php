
<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengelolaan Data C-Desa <?=ucwords($this->setting->sebutan_desa)?> <?= $desa["nama_desa"];?></h1>
		<ol class="breadcrumb">
			<li><a href="<?=site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?=site_url('data_persil/clear')?>"> Daftar C-Desa</a></li>
			<li class="active">Pengelolaan Data C-Desa</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-3">
				<?php $this->load->view('data_persil/menu_kiri.php')?>
			</div>
			<div class="col-md-9">
				<div class="card card-outline card-info">
					<div class="card-body">
						<div class="card-header with-border">
							<a href="<?= site_url('cdesa/clear')?>" class="btn btn-flat btn-primary btn-xs visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xl-inline-block text-left" title="Kembali Ke Daftar C-Desa"><i class="fa fa-arrow-circle-o-left"></i> Kembali Ke Daftar C-Desa</a>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<form action="" id="main" name="main" method="POST" class="form-horizontal">
									<div class="card-body">

										<div class="form-group ">
											<label for="jenis_pemilik" class="col-sm-3 control-label">Jenis Pemilik</label>
											<div class="btn-group col-sm-8 kiri" data-toggle="buttons">
												<label class="btn btn-info btn-flat btn-xs col-sm-3 form-check-label <?php (empty($cdesa) or $cdesa["jenis_pemilik"] == 1) and print('active') ?>">
													<input type="radio" name="jenis_pemilik" class="form-check-input" value="1" autocomplete="off" <?php selected((empty($cdesa) or $cdesa["jenis_pemilik"] == 1), true, true)?> onchange="pilih_pemilik(this.value);">Warga Desa
												</label>
												<label class="btn btn-info btn-flat btn-xs col-sm-3 form-check-label <?= ($cdesa["jenis_pemilik"] == 2) and print('active') ?>">
													<input type="radio" name="jenis_pemilik" class="form-check-input" value="2" autocomplete="off" <?php selected(($cdesa["jenis_pemilik"] == 2), true, true)?> onchange="pilih_pemilik(this.value);">Warga Luar Desa
												</label>
											</div>
										</div>

										<div id="warga_desa">
											<div class="form-group">
												<label class="col-sm-3 control-label" >Cari Nama Pemilik</label>
												<div class="col-sm-8">
													<select class="form-control form-control-sm select2" style="width: 100%;" id="nik" name="nik" onchange="ubah_pemilik($('#jenis_pemilik').val());">
														<option value="">-- Silakan Masukan NIK / Nama --</option>
														<?php foreach ($penduduk as $item): ?>
															<option value="<?= $item['id']?>" <?php selected($pemilik['nik'], $item['id'])?>>Nama : <?= $item['nama']." Alamat : ".$item['info']?></option>
														<?php endforeach;?>
													</select>
												</div>
											</div>
											<?php if ($pemilik): ?>
												<div class="form-group">
													<label for="nama" class="col-sm-3 control-label">Pemilik</label>
													<div class="col-sm-8">
														<div class="form-group">
															<label class="col-sm-3 control-label">Nama Penduduk</label>
															<div class="col-sm-9">
																<input  class="form-control form-control-sm" type="text" placeholder="Nama Pemilik" value="<?= $pemilik["nama"] ?>" disabled >
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">NIK Pemilik</label>
															<div class="col-sm-9">
																<input  class="form-control form-control-sm" type="text" placeholder="NIK Pemilik" value="<?= $pemilik["nik"] ?>" disabled >
															</div>
														</div>
														<div class="form-group">
															<label for="alamat"  class="col-sm-3 control-label">Alamat Pemilik</label>
															<div class="col-sm-9">
																<textarea  class="form-control form-control-sm" placeholder="Alamat Pemilik" disabled><?= "RT ".$pemilik["rt"]." / RT ".$pemilik["rw"]." - ".strtoupper($pemilik["dusun"]) ?></textarea>
															</div>
														</div>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</form>
								<form name='mainform' action="<?= site_url('cdesa/simpan_cdesa')?>" method="POST"  id="validasi" class="form-horizontal">
									<div class="card-body">
										<input id="jenis_pemilik" name="jenis_pemilik" type="hidden" value="1">
										<input type="hidden" name="nik_lama" value="<?= $pemilik["nik_lama"] ?>"/>
										<input type="hidden" name="nik" value="<?= $pemilik["nik"] ?>"/>
										<input type="hidden" name="id_pend" value="<?= $pemilik["id"] ?>"/>
										<?php if ($cdesa): ?>
											<input type="hidden" name="id" value="<?= $cdesa["id"] ?>"/>
										<?php endif; ?>
										<input type="hidden" name="c_desa" value="<?= $cdesa["c_desa"] ?>"/>

										<div id="warga_luar_desa">
											<div class="form-group">
												<label for="c_desa"  class="col-sm-3 control-label">Nama Pemilik</label>
												<div class="col-sm-8">
													<input class="form-control form-control-sm required" type="text" placeholder="Nama Pemilik Luar" id="nama_pemilik_luar" name="nama_pemilik_luar" value="<?= ($cdesa["nama_pemilik_luar"])?>" <?php $pemilik and print('disabled') ?>>
												</div>
											</div>
											<div class="form-group">
												<label for="c_desa"  class="col-sm-3 control-label">Alamat Pemilik</label>
												<div class="col-sm-8">
													<input class="form-control form-control-sm required" type="text" placeholder="Alamat Pemilik Luar" id="alamat_pemilik_luar" name="alamat_pemilik_luar" value="<?= ($cdesa["alamat_pemilik_luar"])?>" <?php $pemilik and print('disabled') ?>>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label for="c_desa"  class="col-sm-3 control-label">Nomor C-DESA</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm angka required" type="text" placeholder="Nomor Surat C-DESA" name="c_desa" value="<?= ($cdesa["nomor"])?>" <?php !($pemilik or $cdesa['jenis_pemilik'] == 2) and print('disabled') ?>>
											</div>
										</div>
										<div class="form-group">
											<label for="nama_kepemilikan"  class="col-sm-3 control-label">Nama Pemilik Tertulis di C-Desa</label>
											<div class="col-sm-8">
												<input class="form-control form-control-sm nama required" type="text" placeholder="Nama pemilik sebagaimana tertulis di Surat C-DESA" name="nama_kepemilikan" value="<?= ($cdesa["nama_kepemilikan"])?sprintf("%04s", $cdesa["nama_kepemilikan"]): NULL ?>" <?php !($pemilik or $cdesa['jenis_pemilik'] == 2) and print('disabled') ?>>
											</div>
										</div>
									</div>
									<div class="card-footer">
										<div class="col-xs-12">
											<button type="reset" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-times"></i> Batal</button>
											<button type="submit" class="btn btn-flat btn-info btn-xs pull-right"><i class="fa fa-check"></i> Simpan</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	$(document).ready(function(){
		$('#tipe').change(function(){
			var id=$(this).val();
			$.ajax({
				url : "<?=site_url('data_persil/kelasid')?>",
				method : "POST",
				data : {id: id},
				async : true,
				dataType : 'json',
				success: function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						html += '<option value='+data[i].id+'>'+data[i].kode+' '+data[i].ndesc+'</option>';
					}
					$('#kelas').html(html);
				}
			});
			return false;
		});

		pilih_pemilik(<?= $cdesa['jenis_pemilik'] ?: 1?>);

	});

	function pilih_lokasi(pilih)
	{
		if (pilih == 1)
		{
			$("#manual").hide();
			$("#pilih").show();
		}
		else
		{
			$("#manual").removeClass('hidden');
			$("#manual").show();
			$("#pilih").hide();
		}
	}

	function pilih_pemilik(pilih)
	{
		$('#jenis_pemilik').val(pilih);
		if (pilih == 1)
		{
			if ($('#nik').val() == '')
			{
				$('input[name=c_desa]').attr('disabled','disabled');
				$('input[name=nama_kepemilikan]').attr('disabled','disabled');
			}
			$('#nama_pemilik_luar').val('');
			$('#nama_pemilik_luar').removeClass('required');
			$('#alamat_pemilik_luar').val('');
			$('#alamat_pemilik_luar').removeClass('required');
			$("#warga_luar_desa").hide();
			$('#nik').addClass('required');
			$("#warga_desa").show();
		}
		else
		{
			$('#nik').removeClass('required');
			$("#warga_desa").hide();
			$("#warga_luar_desa").show();
			$('#nama_pemilik_luar').addClass('required');
			$('#alamat_pemilik_luar').addClass('required');
			$('input[name=c_desa]').removeAttr('disabled');
			$('input[name=nama_kepemilikan]').removeAttr('disabled');
			if ($('#nik').val() != '')
			{
				$('#nik').val('');
				$('#nik').change();
			}
		}
	}

	function ubah_pemilik(jenis_pemilik)
	{
		$('#main').submit();
	}
</script>

