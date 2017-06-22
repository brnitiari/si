<script>
$(function(){
var nik = {};
nik.results = [
<?php foreach($perempuan as $data){?>
  {id:'<?php echo $data['id']?>',name:"<?php echo $data['nik']." - ".($data['nama'])?>",info:"<?php echo ($data['alamat'])?>"},
<?php }?>
];

$('#nik').flexbox(nik, {
resultTemplate: '<div><label>No nik : </label>{name}</div><div>{info}</div>',
watermark: <?php if($individu){?>'<?php echo $individu['nik']?> - <?php echo spaceunpenetration($individu['nama'])?>'<?php }else{?>'Ketik no nik di sini..'<?php }?>,
width: 260,
noResultsText :'Tidak ada no nik yang sesuai..',
onSelect: function() {
$('#'+'main').submit();
}
});

/* set otomatis hari */
$('input[name=tanggal]').change(function(){
  var hari = {
    0 : 'Minggu', 1 : 'Senin', 2 : 'Selasa', 3 : 'Rabu', 4 : 'Kamis', 5 : 'Jumat', 6 : 'Sabtu'
  };
  var t = $(this).datepicker('getDate');
  var i = t.getDay();
  $(this).closest('td').find('[name=hari]').val(hari[i]);
})

});
</script>


<style>
table.form.detail th{
    padding:5px;
    background:#fafafa;
    border-right:1px solid #eee;
}
table.form.detail td{
    padding:5px;
}

</style>
<div id="pageC">
	<table class="inner">
	<tr style="vertical-align:top">
	<td class="side-menu">
				<fieldset>
<legend>Surat Administrasi</legend>
<div id="sidecontent2"  class="lmenu">
<ul>
<?php foreach($menu_surat AS $data){?>

        <li <?php  if($data['url_surat']==$lap){?>class="selected"<?php  }?>><a href="<?php echo site_url()?>surat/<?php echo $data['url_surat']?>"><?php echo unpenetration($data['nama'])?></a></li>
<?php }?>
</ul>
</div>
</fieldset>

	</td>
		<td style="background:#fff;padding:5px;">

<div class="content-header">

</div>
<div id="contentpane">
<div class="ui-layout-north panel">
<h3>Surat Keterangan Kelahiran</h3>
</div>

  <div class="ui-layout-center" id="maincontent" style="padding: 5px;">
<table class="form">
<tr></tr>
<tr>
<th>NIK / Nama Ibu</th>
<td>
<form action="" id="main" name="main" method="POST">
<div id="nik" name="nik"></div>
</form>
</tr>
<form id="validasi" action="<?php echo $form_action?>" method="POST" target="_blank">
<input type="hidden" name="nik" value="<?php echo $individu['id']?>"  class="inputbox required">
<?php if($individu){ //bagian info setelah terpilih?>
  <?php include("donjo-app/views/surat/form/konfirmasi_pemohon.php"); ?>
<?php }?>
<tr>
<th>Nomor Surat</th>
<td><input name="nomor" type="text" class="inputbox required" size="12"/> <span>Terakhir: <?php echo $surat_terakhir['no_surat'];?> (tgl: <?php echo $surat_terakhir['tanggal']?>)</span></td>
</tr>
<tr>
	<th>DATA KELAHIRAN :</th>
</tr>
<tr>
	<th>Hari/ Tanggal/ Jam</th>
	<td><input name="hari" readonly type="text" class="inputbox required" size="10"/> /
	<input name="tanggal" type="text" class="inputbox required datepicker" size="10"/> /
	<input name="jam" type="text" class="inputbox required" size="10"/></td>
</tr>
<tr>
	<th>Tempat kelahiran</th>
	<td><input name="tempat_lahir_bayi" type="text" class="inputbox required" size="10"/>
</td>
</tr>
<tr>
	<th>Nama Bayi</th>
	<td><input name="nama_bayi" type="text" class="inputbox required" size="30"/></td>
</tr>
<tr>
	<th>Jenis Kelamin Bayi</th>
	<td><input name="sex_bayi" type="text" class="inputbox required" size="10"/></td>
</tr>

<tr>
	<th>DATA PELAPOR :</th>
</tr>
<tr>
	<th>Nama</th>
	<td><input name="nama_pelapor" type="text" class="inputbox required" size="30"/></td>
</tr>
<tr>
	<th>NIK</th>
	<td><input name="nik_pelapor" type="text" class="inputbox required" size="10"/></td>
</tr>
<tr>
	<th>Umur</th>
	<td><input name="umur_pelapor" type="text" class="inputbox required" size="5"/> tahun</td>
</tr>
<tr>
	<th>Pekerjaan</th>
	<td><input name="pek_pelapor" type="text" class="inputbox required" size="10"/></td>
</tr>
<tr>
	<th>Alamat</th>
	<td><input name="alamat_pelapor" type="text" class="inputbox required" size="40"/></td>
</tr>
<tr>
	<th>Hubungan Pelapor dengan Bayi</th>
	<td><input name="hubungan" type="text" class="inputbox required" size="20"/></td>
</tr>
	<?php include("donjo-app/views/surat/form/_pamong.php"); ?>

        </table>
    </div>

    <div class="ui-layout-south panel bottom">
        <div class="left">
            <a href="<?php echo site_url()?>surat" class="uibutton icon prev">Kembali</a>
        </div>
        <div class="right">
            <div class="uibutton-group">
                <button class="uibutton" type="reset"><span class="fa fa-refresh"></span> Bersihkan</button>

							<button type="button" onclick="$('#'+'validasi').attr('action','<?php echo $form_action?>');$('#'+'validasi').submit();" class="uibutton special"><span class="fa fa-print" style="color:#fff">&nbsp;</span>Cetak</button>
							<?php if (SuratExport($url)) { ?><button type="button" onclick="$('#'+'validasi').attr('action','<?php echo $form_action2?>');$('#'+'validasi').submit();" class="uibutton confirm"><span class="fa fa-file-text" style="color:#fff">&nbsp;</span>Export Doc</button><?php } ?>
            </div>
        </div>
    </div> </form>
</div>
</td></tr></table>
</div>
