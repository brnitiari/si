<script type="text/javascript" src="<?= base_url()?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/validasi.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/localization/messages_id.js"></script>
<script>
	$(function ()
	{
		$('.select2').select2()
	})
</script>
<form action="<?=$form_action?>" method="post" id="validasi">
	<div class='modal-body'>
		<div class="row">
			<div class="col-sm-12">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-group">
							<label for="nama">Nama</label>
							<select class="form-control input-sm select2 required"  id="pilih" name="pilih" style="width:100%;" onchange="pilih_telepon(this.value);">
							<?php foreach ($nama AS $data): ?>
								<option value="<?=$data['id'].'|'.$data['telepon']?>"><?= $data['nama']?></option>
							<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label" for="hp">No HP</label>
							<input id="telepon" name="telepon" class="form-control input-sm required" type="text"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="reset" class="btn btn-social btn-flat btn-danger btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
			<button type="submit" class="btn btn-social btn-flat btn-info btn-sm" id="ok"><i class='fa fa-check'></i> Simpan</button>
		</div>
	</div>
</form>
<script>
	$('document').ready(function()
	{
		$('#pilih').change();
	});

	function pilih_telepon(tlp)
	{
		tlp = tlp.split("|");
		$('#telepon').attr('value', tlp[1]);
	};
</script>
