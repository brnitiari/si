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
				<div class="card card-outline card-danger">
					<div class="card-body">
						<div class="form-group">
							<label class="control-label" for="hp">No HP Tujuan</label>
							<input name="DestinationNumber" class="form-control form-control-sm required bilangan" type="text" value="<?=$sms['DestinationNumber']?>"></input>
						</div>
						<div class="form-group">
							<label class="control-label" for="pesan">Isi Pesan</label>
							<textarea name="TextDecoded" class="form-control form-control-sm required" placeholder="Isi Pesan"><?=$sms['TextDecoded']?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="reset" class="btn btn-flat btn-danger btn-xs" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
			<button type="submit" class="btn btn-flat btn-info btn-xs" id="ok"><i class='fa fa-envelope-o'></i> Kirim</button>
		</div>
	</div>
</form>
