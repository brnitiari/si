<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * File ini:
 *
 * View form data suplemen untuk modul Suplemen
 *
 * donjo-app/views/suplemen/form.php,
 *
 */

/**
 *
 * File ini bagian dari:
 *
 * OpenSID
 *
 * Sistem informasi desa sumber terbuka untuk memajukan desa
 *
 * Aplikasi dan source code ini dirilis berdasarkan lisensi GPL V3
 *
 * Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 *
 * Dengan ini diberikan izin, secara gratis, kepada siapa pun yang mendapatkan salinan
 * dari perangkat lunak ini dan file dokumentasi terkait ("Aplikasi Ini"), untuk diperlakukan
 * tanpa batasan, termasuk hak untuk menggunakan, menyalin, mengubah dan/atau mendistribusikan,
 * asal tunduk pada syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam
 * setiap salinan atau bagian penting Aplikasi Ini. Barang siapa yang menghapus atau menghilangkan
 * pemberitahuan ini melanggar ketentuan lisensi Aplikasi Ini.
 *
 * PERANGKAT LUNAK INI DISEDIAKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN
 * TERSIRAT. PENULIS ATAU PEMEGANG HAK CIPTA SAMA SEKALI TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU
 * KEWAJIBAN APAPUN ATAS PENGGUNAAN ATAU LAINNYA TERKAIT APLIKASI INI.
 *
 * @package	OpenSID
 * @author	Tim Pengembang OpenDesa
 * @copyright	Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright	Hak Cipta 2016 - 2020 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license	http://www.gnu.org/licenses/gpl.html	GPL V3
 * @link 	https://github.com/OpenSID/OpenSID
 */
?>

<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">
						Form Data Suplemen
					</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('hom_sid'); ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item"><a href="<?= site_url('suplemen')?>"> Data Suplemen</a></li>
						<li class="breadcrumb-item active">Form Data Suplemen</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<section class="content" id="maincontent">
		<div class="card card-outline card-info">
			<div class="card-header with-border">
				<a href="<?= site_url('suplemen')?>" class="btn btn-flat btn-info btn-xs visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xl-inline-block text-left"><i class="fa fa-arrow-circle-left"></i> Kembali Ke Daftar Suplemen</a>
			</div>
			<form id="validasi" action="<?= $form_action; ?>" method="POST" class="form-horizontal">
				<div class="card-body">
					<div class="row mb-2">
						<label class="col-sm-3 control-label" for="id_master">Sasaran Data</label>
						<div class="col-sm-7">
							<?php if ($suplemen['jml'] <> 0): ?>
								<input type="hidden" name="sasaran" value="<?= $suplemen['sasaran']; ?>">
								<select class="form-control form-control-sm" disabled>
							<?php else: ?>
								<select class="form-control form-control-sm required" name="sasaran">
							<?php endif;?>
							<option value="">Pilih Sasaran</option>
							<?php foreach ($list_sasaran AS $key => $value): ?>
								<?php if (in_array($key, ['1', '2'])) : ?>
									<option value="<?= $key; ?>" <?= selected($suplemen['sasaran'], $key); ?>><?= $value?></option>
								<?php endif; ?>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row mb-2">
						<label class="col-sm-3 control-label" for="nama">Nama Data Suplemen</label>
						<div class="col-sm-7">
							<input class="form-control form-control-sm nomor_sk required" maxlength="100" type="text" placeholder="Nama Data Suplemen" name="nama" id="nama" value="<?= $suplemen['nama']?>">
						</div>
					</div>
					<div class="row mb-2">
						<label class="col-sm-3 control-label" for="keterangan">Keterangan</label>
						<div class="col-sm-7">
							 <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" maxlength="300" placeholder="Keterangan" rows="3" style="resize:none;"><?= $suplemen['keterangan']?></textarea>
						 </div>
					</div>
				</div>
				<div class="card-footer">
					<button type="reset" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-times"></i> Batal</button>
					<button type="submit" class="btn btn-flat btn-info btn-xs pull-right"><i class="fa fa-check"></i> Simpan</button>
				</div>
			</form>
		</div>
	</section>
</div>
