<div class="content-wrapper">
	<section class="content-header">
		<h1>Pengaturan Daftar Kontak</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Pengaturan Daftar Kontak</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form class="form-inline" id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-3">
					<div class="card card-outline card-info">
						<div class="card-header with-border">
							<h3 class="box-title">SMS</h3>
							<div class="card-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="card-body no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li class="active"><a href="<?= site_url('sms/kontak')?>"><i class="fa fa-phone"></i> Daftar Kontak</a></li>
               	<li><a href="<?= site_url('sms/group')?>"><i class="fa fa-list"></i> Group Kontak</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="card card-outline card-info">
            <div class="card-header with-border">
							<a href="<?= site_url('sms/form_kontak/0')?>" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Tambah Kontak"  class="btn btn-flat btn-success btn-xs visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xl-inline-block text-left"><i class='fa fa-plus'></i> Tambah Kontak</a>
							<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '<?= site_url("sms/delete_all_kontak")?>')" class="btn btn-flat btn-danger btn-xs visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block visible-xl-inline-block text-left hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper dt-bootstrap no-footer">
										<form class="form-inline" id="mainform" name="mainform" action="" method="post">
											<div class="row">
												<div class="col-sm-12">
													<div class="card-tools">
														<div class="input-group input-group-sm pull-right">
															<input name="cari_kontak" id="cari_kontak" class="form-control" placeholder="Cari..." type="text" value="<?=$cari_kontak?>" onkeypress="if (event.keyCode == 13):$('#'+'mainform').attr('action', '<?= site_url('sms/search_kontak')?>');$('#'+'mainform').submit();endif">
															<div class="input-group-btn">
																<button type="submit" class="btn btn-default" onclick="$('#'+'mainform').attr('action', '<?= site_url("sms/search_kontak")?>');$('#'+'mainform').submit();"><i class="fa fa-search"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<div class="table-responsive">
														<table class="table table-bordered dataTable table-hover">
															<thead class="bg-gray disabled color-palette">
																<tr>
																	<th><input type="checkbox" id="checkall"/></th>
																	<th>No</th>
																	<th>Aksi</th>
																	<th width="30%">Nama</th>
																	<th>Jenis Kelamin</th>
																	<th>Alamat</th>
																	<th>No HP</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($main as $data): ?>
																	<tr>
																		<td><input type="checkbox" name="id_cb[]" value="<?=$data['id_kontak']?>" /></td>
																		<td><?=$data['no']?></td>
																		<td nowrap>
																			<a href="<?=site_url("sms/form_kontak/$data[id_kontak]")?>" class="btn bg-orange btn-flat btn-xs" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Ubah Data" title="Ubah Data"><i class="fa fa-edit"></i></a>
																			<a href="#" data-href="<?=site_url("sms/kontak_delete/$data[id_kontak]")?>" class="btn bg-maroon btn-flat btn-xs"  title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                    <td><a href="<?=site_url("penduduk/detail/$p/$o/$data[id_pend]")?>"><?=$data['nama']?></a></td>
																		<td><?=$data['sex']?></td>
																		<td><?=$data['alamat_sekarang']?></td>
																		<td><?=$data['no_hp']?></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</form>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="dataTables_length">
                          <form id="paging" action="<?= site_url("sms/kontak")?>" method="post" class="form-horizontal">
                            <label>
                              Tampilkan
                              <select name="per_page" class="form-control form-control-sm" onchange="$('#paging').submit()">
                                <option value="20" <?php selected($per_page, 20); ?> >20</option>
                                <option value="50" <?php selected($per_page, 50); ?> >50</option>
                                <option value="100" <?php selected($per_page, 100); ?> >100</option>
                              </select>
                              Dari
                              <strong><?= $paging->num_rows?></strong>
                              Total Data
                            </label>
                          </form>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers">
                          <ul class="pagination">
                            <?php if ($paging->start_link): ?>
                              <li><a href="<?= site_url("sms/kontak/$paging->start_link/$o")?>" aria-label="First"><span aria-hidden="true">Awal</span></a></li>
                            <?php endif; ?>
                            <?php if ($paging->prev): ?>
                              <li><a href="<?= site_url("sms/kontak/$paging->prev/$o")?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <?php endif; ?>
                            <?php for ($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                              <li <?=jecho($p, $i, "class='active'")?>><a href="<?= site_url("sms/kontak/$i/$o")?>"><?= $i?></a></li>
                            <?php endfor; ?>
                            <?php if ($paging->next): ?>
                              <li><a href="<?= site_url("sms/kontak/$paging->next/$o")?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                            <?php endif; ?>
                            <?php if ($paging->end_link): ?>
                              <li><a href="<?= site_url("sms/kontak/$paging->end_link/$o")?>" aria-label="Last"><span aria-hidden="true">Akhir</span></a></li>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<?php $this->load->view('global/confirm_delete');?>