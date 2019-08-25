<style type="text/css">
	.nowrap { white-space: nowrap; }
</style>
<script>
	$(function()
	{
		// var keyword = <?= $keyword?> ;
		var keyword = " " ;
		$( "#cari" ).autocomplete(
		{
			source: keyword,
			maxShowItems: 10,
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Laporan Keuangan</h1>
		<ol class="breadcrumb">
			<li><a href="<?= site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Laporan Keuangan</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<div class="row">
			<div class="col-md-3">
				<?php $this->load->view('keuangan/menu_laporan');?>
			</div>
			<div class="col-md-9">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h4>Informasi Anggaran</h4>
						<div class="col-md-5">
							<select name="tahun_anggaran" id="tahun_anggaran">
								<option value="">Pilih Tahun</option>
								<?php foreach ($tahun_anggaran as $t) :?>
									<option value="<?= $t ?>"><?= $t ?></option>
								<?php endforeach ?>
							</select>
							<select id="semester" name="semester">
								<option value="">Pilih Semester</option>
								<option value="1">1</option>
								<option value="2">2</option>
							</select>
							<button class="btn btn-info" onclick="setData()"><i class="fa fa-search"></i> Cari</button>
						</div>
						<div id="alert" class="col-md-7 alert alert-warning alert-dismissible">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			                <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
			                Lengkapi Filter Data Dahulu.
			            </div>					
					</div>
					<div class="box-body">
						<div class="box box-danger">
							<div class="box-header with-border">
								<div class="col-md-4">
									<h5>Anggaran</h5>
									<h4><b id="data_anggaran">Rp . 0</b></h4>
								</div>
								<div class="col-md-4">
									<h5>Anggaran PAK</h5>
									<h4><b id="data_pak">Rp .0</b></h4>
								</div>
								<div class="col-md-4">
									<h5>Anggaran Setelah PAK</h5>
									<h4><b id="data_total">Rp . 0</b></h4>
								</div>
							</div>
							<div class="box-body">
								<div class="col-md-12">
									<div class="box box-danger">
										<div id="chart"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">

	$(document).ready(function ()
	{

	});

	function setData() 
	{
		var tahun = $('#tahun_anggaran').val();
		var semester = $('#semester').val();
		$('#alert').hide();

		get_anggaran(tahun, semester);
	}

	function numberWithCommas(x) {
	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function get_anggaran(tahun, semester) 
	{
		$.ajax({
			type  : 'GET',
			url   : '<?php echo site_url('keuangan/anggaran/')?>' + tahun + "/" + semester,
			dataType : 'json',
			success : function(data){
				var anggaran = "Rp. " + numberWithCommas(data.data_anggaran.Anggaran);
				var pak = "Rp. " + numberWithCommas(data.data_anggaran.AnggaranPAK);
				var total = "Rp. " + numberWithCommas(data.data_anggaran.AnggaranStlhPAK);
				console.log(data.data_realisasi.realisasi.Nilai);
				$('#data_anggaran').html(anggaran);
				$('#data_pak').html(pak);
				$('#data_total').html(total);

				Highcharts.setOptions({
					lang: {
						thousandsSep: '.'
					}
				})
				Highcharts.chart('chart', {
			    chart: {
			        type: 'bar'
			    },
			    title: {
			        text: 'Pagu Anggaran VS Realisasi'
			    },
			    subtitle: {
			        text: 'Tahun ' + tahun
			    },
			    xAxis: {
			        categories: ['Anggaran', 'Realisasi'],
			    },
			    yAxis: {
			        min: 0,
			        title: {
			            text: 'Anggaran vs Realisasi'
			        },
			        labels: {
			            overflow: 'justify',
			            enabled: false
			        }
			    },
			    tooltip: {
			        valueSuffix: ''
			    },
			    plotOptions: {
			        bar: {
			            dataLabels: {
			                enabled: true
			            }
			        }
			    },
			    legend: {
			        layout: 'vertical',
			        align: 'right',
			        verticalAlign: 'top',
			        x: 0,
			        y: 0,
			        floating: true,
			        borderWidth: 1,
			        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
			        shadow: true
			    },
			    credits: {
			        enabled: false
			    },
			    series: [{
			        name: 'Anggaran',
					color: '#2E8B57',
					dataLabels: {
			        	formatter: function () {
			        		return 'Rp. ' + Highcharts.numberFormat(this.y, '.', ',');
			        	}
			        },
			        data: [parseInt(data.data_realisasi.anggaran.AnggaranStlhPAK)]
			    }, {
			        name: 'Realisasi',
					color: '#FFD700',
					dataLabels: {
			        	formatter: function () {
			        		return 'Rp. ' + Highcharts.numberFormat(this.y, '.', ',');
			        	}
			        },
			        data: [parseInt(data.data_realisasi.realisasi.Nilai)]
			    }]
			});
			}

		});
	}
</script>