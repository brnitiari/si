<div class="content-wrapper">
	<section class="content-header">
		<h1>Anjungan Layanan Mandiri</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Anjungan Layanan Mandiri</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="card card-outline card-info">
			<div class="card-header with-border">
				<a href="<?=site_url('anjungan/form')?>" class="btn btn-flat bg-olive btn-xs visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xl-inline-block text-left" title="Tambah Anjungan Layanan Mandiri"><i class="fa fa-plus"></i> Tambah Anjungan Layanan Mandiri</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered dataTable table-striped table-hover tabel-daftar">
						<thead class="bg-gray disabled color-palette">
							<tr>
								<th>No</th>
								<th>Aksi</th>
								<th>IP Address</th>
								<th>Virtual Keyboard</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php if($main): ?>
								<?php foreach ($main as $key => $data): ?>
									<tr <?= jecho($data['status'] == 1, FALSE, 'class="select-row"'); ?>>
										<td class="padat"><?= ($key + 1); ?></td>
										<td class="aksi">
											<a href="<?= site_url("anjungan/form/$data[id]"); ?>" class="btn bg-orange btn-flat btn-xs" title="Ubah Data"><i class='fa fa-edit'></i></a>
											<?php if ($data['status'] == '1'): ?>
												<a href="<?= site_url("anjungan/lock/$data[id]/2"); ?>" class="btn bg-navy btn-flat btn-xs"  title="Non Aktifkan"><i class="fa fa-unlock"></i></a>
											<?php else: ?>
												<a href="<?= site_url("anjungan/lock/$data[id]/1"); ?>" class="btn bg-navy btn-flat btn-xs"  title="Aktifkan"><i class="fa fa-lock">&nbsp;</i></a>
											<?php endif ?>
											<a href="#" data-href="<?=site_url('anjungan/delete/'.$data[id]); ?>" class="btn bg-maroon btn-flat btn-xs" title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
										</td>
										<td><?= $data['ip_address']; ?></td>
										<td class="padat"><?= ($data['keyboard'] == 1) ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>'; ?></td>
										<td><?= $data['keterangan']; ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="10">Data Tidak Tersedia</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('global/confirm_delete');?>

