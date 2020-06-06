<?php
class keuangan_grafik_manual_model extends CI_model {

  public function __construct()
  {
		parent::__construct();
  }

  public function rp_apbd_widget($thn, $opt=false)
  {
		$this->db->select('Akun, Nama_Akun');

    if ($opt)
		{
      $this->db->where("Akun NOT LIKE '1.%'");
  		$this->db->where("Akun NOT LIKE '2.%'");
  		$this->db->where("Akun NOT LIKE '3.%'");
  		$this->db->where("Akun NOT LIKE '7.%'");
    }
    else
    {
      $this->db->where("Akun NOT LIKE '1.%'");
  		$this->db->where("Akun NOT LIKE '7.%'");
    }

		$this->db->order_by('Akun', 'asc');
		$this->db->group_by('Akun');
		$this->db->group_by('Nama_Akun');
		$data['jenis_pelaksanaan'] = $this->db->get('keuangan_manual_ref_rek1')->result_array();

		$this->db->select('LEFT(Kd_Rincian, 2) AS jenis_pelaksanaan, SUM(Nilai_Anggaran) AS pagu');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('jenis_pelaksanaan');
		$data['anggaran'] = $this->db->get('keuangan_manual_rinci')->result_array();

		$this->db->select('LEFT(Kd_Rincian, 2) AS jenis_pelaksanaan, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->group_by('jenis_pelaksanaan');
		$this->db->where('Tahun', $thn);
		$data['realisasi_pendapatan'] = $this->db->get('keuangan_manual_rinci')->result_array();

		$this->db->select('LEFT(Kd_Rincian, 2) AS jenis_pelaksanaan, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('jenis_pelaksanaan');
		$this->db->like('Kd_Rincian', '5.', 'after');
		$data['realisasi_belanja'] = $this->db->get('keuangan_manual_rinci')->result_array();

		return $data;
  }

  public function r_pd_widget($thn, $opt=false)
  {
		$this->db->select('keuangan_manual_ref_rek3.Jenis, keuangan_manual_ref_rek3.Nama_Jenis');

    if ($opt)
		{
      $this->db->where("keuangan_manual_ref_rek3.Jenis LIKE '4.%'");
    }
    else
    {
  		$this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '1.%'");
  		$this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '5.%'");
  		$this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '6.%'");
  		$this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '7.%'");
    }

    $this->db->where("keuangan_manual_ref_rek3.Nama_Jenis NOT LIKE '%Hutang%'");
    $this->db->where("keuangan_manual_ref_rek3.Nama_Jenis NOT LIKE '%Ekuitas SAL%'");
    $this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '4.3.2%'");
    $this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '4.3.3%'");
    $this->db->where("keuangan_manual_ref_rek3.Nama_Jenis NOT LIKE 'Lain-lain Pendapatan Desa Yang Sah%'");
    $this->db->where("keuangan_manual_ref_rek3.Jenis NOT LIKE '4.3.9%'");

		$this->db->order_by('keuangan_manual_ref_rek3.Jenis', 'asc');
		$data['jenis_pendapatan'] = $this->db->get('keuangan_manual_ref_rek3')->result_array();

		$this->db->select('LEFT(Kd_Rincian, 6) AS jenis_pendapatan, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', '4.', 'after');
		$this->db->group_by('jenis_pendapatan');
		$this->db->where('Tahun', $thn);
		$data['anggaran'] = $this->db->get('keuangan_manual_rinci')->result_array();

		$this->db->select('LEFT(Kd_Rincian, 6) AS jenis_pendapatan, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', '4.', 'after');
		$this->db->group_by('jenis_pendapatan');
		$this->db->where('Tahun', $thn);
		$data['realisasi_pendapatan'] = $this->db->get('keuangan_manual_rinci')->result_array();

		return $data;
  }

  public function r_bd_widget($thn, $opt=false)
  {
    $this->db->select('Kd_Bid, Nama_Bidang');
    if ($opt)
		{
      $this->db->where("Kd_Bid NOT LIKE '01%'");
      $this->db->where("Kd_Bid NOT LIKE '02%'");
      $this->db->where("Kd_Bid NOT LIKE '03%'");
    }
    else
    {
      $this->db->where("Kd_Bid NOT LIKE '01%'");
    }

    $this->db->order_by('Kd_Bid', 'asc');
    $data['jenis_belanja'] = $this->db->get('keuangan_manual_ref_bidang')->result_array();
    // Perlu ditambahkan baris berikut untuk memaksa menampilkan semua bidang di grafik keuangan
    // TODO: lihat apakah bisa diatasi langsung di script penampilan
    if (!$opt)
    {
	    array_unshift($data['jenis_belanja'] , array('Kd_Bid' => '03', 'Nama_Bidang' => 'ROW_SPACER'));
	    array_unshift($data['jenis_belanja'] , array('Kd_Bid' => '02', 'Nama_Bidang' => 'ROW_SPACER'));
    }

    $this->db->select('LEFT(Kd_Keg, 10) AS jenis_belanja, SUM(Nilai_Anggaran) AS pagu');
    $this->db->like('Kd_Rincian', '5.', 'after');
    $this->db->group_by('jenis_belanja');
    $this->db->where('Tahun', $thn);
    $data['anggaran'] = $this->db->get('keuangan_manual_rinci')->result_array();

    $this->db->select('LEFT(Kd_Keg, 10) AS jenis_belanja, SUM(Nilai_Realisasi) AS realisasi');
    $this->db->like('Kd_Rincian', '5.', 'after');
    $this->db->where('Tahun', $thn);
    $this->db->group_by('jenis_belanja');
    $data['realisasi_belanja'] = $this->db->get('keuangan_manual_rinci')->result_array();

		return $data;
  }

  private function data_widget_pendapatan($tahun, $opt=false)
  {
    if ($opt)
		{
      $raw_data = $this->r_pd_widget($tahun, $opt=true);
  		$res_pendapatan = array();
  		$tmp_pendapatan = array();
  		foreach ($raw_data['jenis_pendapatan'] as $r)
  		{
  		  $tmp_pendapatan[$r['Jenis']]['nama'] = $r['Nama_Jenis'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_pendapatan[$r['jenis_pendapatan']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_pendapatan'] as $r)
  		{
  		  $tmp_pendapatan[$r['jenis_pendapatan']]['realisasi'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}

    }
    else
    {
      $raw_data = $this->r_pd_widget($tahun, $opt=false);
  		$res_pendapatan = array();
  		$tmp_pendapatan = array();
  		foreach ($raw_data['jenis_pendapatan'] as $r)
  		{
  		  $tmp_pendapatan[$r['Jenis']]['nama'] = $r['Nama_Jenis'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_pendapatan[$r['jenis_pendapatan']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_pendapatan'] as $r)
  		{
  		  $tmp_pendapatan[$r['jenis_pendapatan']]['realisasi_pendapatan'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}
    }

		foreach ($tmp_pendapatan as $key => $value)
		{
		  array_push($res_pendapatan, $value);
		}

		return $res_pendapatan;
  }

  private function data_widget_belanja($tahun, $opt=false )
  {
    if ($opt)
		{
      $raw_data = $this->r_bd_widget($tahun, $opt=true);
  		$res_belanja = array();
  		$tmp_belanja = array();
      foreach ($raw_data['jenis_belanja'] as $r)
  		{
  		  $tmp_belanja[$r['Kd_Bid']]['nama'] = $r['Nama_Bidang'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_belanja[$r['jenis_belanja']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_belanja'] as $r)
  		{
  		  $tmp_belanja[$r['jenis_belanja']]['realisasi'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}

    }
    else
    {
      $raw_data = $this->r_bd_widget($tahun, $opt=false);
  		$res_belanja = array();
  		$tmp_belanja = array();
      foreach ($raw_data['jenis_belanja'] as $r)
  		{
  		  $tmp_belanja[$r['Kd_Bid']]['nama'] = $r['Nama_Bidang'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_belanja[$r['jenis_belanja']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_belanja'] as $r)
  		{
  		  $tmp_belanja[$r['jenis_belanja']]['realisasi_belanja'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}
    }

    foreach ($tmp_belanja as $key => $value)
    {
      array_push($res_belanja, $value);
    }

		return $res_belanja;
  }

  private function data_widget_pelaksanaan($tahun, $opt=false)
  {
    if ($opt)
		{
      $raw_data = $this->rp_apbd_widget($tahun, $opt=true);
  		$res_pelaksanaan = array();
  		$tmp_pelaksanaan = array();
  		foreach ($raw_data['jenis_pelaksanaan'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['Akun']]['nama'] = $r['Nama_Akun'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['jenis_pelaksanaan']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_pendapatan'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['jenis_pelaksanaan']]['realisasi'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}
    }
    else
    {
      $raw_data = $this->rp_apbd_widget($tahun, $opt=false);
  		$res_pelaksanaan = array();
  		$tmp_pelaksanaan = array();

  		foreach ($raw_data['jenis_pelaksanaan'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['Akun']]['nama'] = $r['Nama_Akun'];
  		}

  		foreach ($raw_data['anggaran'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['jenis_pelaksanaan']]['anggaran'] = ($r['pagu'] ? $r['pagu'] : 0);
  		}

  		foreach ($raw_data['realisasi_pendapatan'] as $r)
  		{
  		  $tmp_pelaksanaan[$r['jenis_pelaksanaan']]['realisasi_pendapatan'] = ($r['realisasi'] ? $r['realisasi'] : 0);
  		}
    }

		foreach ($tmp_pelaksanaan as $key => $value)
		{
		  array_push($res_pelaksanaan, $value);
		}

		return $res_pelaksanaan;
  }

  public function widget_keuangan()
  {
		$data = $this->keuangan_manual_model->list_tahun_anggaran_manual();

		foreach ($data as $tahun)
		{
		  $res[$tahun]['res_pendapatan'] = $this->data_widget_pendapatan($tahun, $opt=true);
		  $res[$tahun]['res_belanja'] = $this->data_widget_belanja($tahun, $opt=true);
		  $res[$tahun]['res_pelaksanaan'] = $this->data_widget_pelaksanaan($tahun, $opt=true);
		}

		$result = array(
		  //Encode ke JSON
		  'data' => json_encode($res),
		  'tahun' => $this->keuangan_manual_model->list_tahun_anggaran_manual_manual(),
		  //Cari tahun anggaran terbaru (terbesar secara value)
		  'tahun_terbaru' => $this->keuangan_manual_model->list_tahun_anggaran_manual()[0]
		);

		return $result;
  }

  private function data_keuangan_tema($tahun)
  {
		$data['res_pelaksanaan'] = $this->data_widget_pelaksanaan($tahun, $opt=false);
		$data['res_pelaksanaan']['laporan'] = 'APBDes '. $tahun . ' Pelaksanaan';
		$data['res_pendapatan'] = $this->data_widget_pendapatan($tahun, $opt=false);
		$data['res_pendapatan']['laporan'] = 'APBDes '. $tahun . ' Pendapatan';
		$data['res_belanja'] = $this->data_widget_belanja($tahun, $opt=false);
		$data['res_belanja']['laporan'] = 'APBDes '. $tahun . ' Pembelanjaan';

		return $data;
  }

  public function grafik_keuangan_tema($tahun = NULL)
  {
		if (is_null($tahun)) $tahun = date('Y');
		$thn = $this->keuangan_manual_model->list_tahun_anggaran_manual();
		if (empty($thn))
		{
		  return null;
		}

		if (!in_array($tahun, $thn))
		{
		  $tahun = $thn[0];
		}
		$raw_data = $this->data_keuangan_tema($tahun);
		foreach ($raw_data as $keys => $raws)
		{
		  foreach ($raws as $key => $raw)
		  {
  			if ($key == 'laporan')
  			{
  			  $result['data_widget'][$keys]['laporan'] = $raw;
  			  continue;
  			}

        $data['judul'] = $raw['nama'];
  			$data['anggaran'] = $raw['anggaran'];
  			$data['realisasi'] = $raw['realisasi']+$raw['realisasi_pendapatan']+$raw['realisasi_belanja'];

  			if ($data['anggaran'] != 0 && $data['realisasi'] != 0)
  			{
  			  $data['persen'] = $data['realisasi'] / $data['anggaran'] * 100;
  			}
  			elseif ($data['realisasi'] != 0)
  			{
  			  $data['persen'] = 100;
  			}
  			else
  			{
  			  $data['persen'] = 0;
  			}
  			$data['persen'] = round($data['persen'], 2);

  			$result['data_widget'][$keys][] = $data;
		  }
		}
		$result['tahun'] = $tahun;
		return $result;
  }

  //Table Laporan Pelaksanaan Realisasi
  public function lap_rp_apbd($thn)
  {
		$this->db->select('Akun, Nama_Akun');
		$this->db->where("Akun = '4.'");

		$data['pendapatan'] = $this->db->get('keuangan_manual_ref_rek1')->result_array();

		foreach ($data['pendapatan'] as $i => $p)
		{
		  $data['pendapatan'][$i]['anggaran'] = $this->pagu_akun($p['Akun'], $thn);
		  $data['pendapatan'][$i]['realisasi'] = $this->real_akun_pendapatan($p['Akun'], $thn);
		  $data['pendapatan'][$i]['sub_pendapatan'] = $this->get_subval_pendapatan( $p['Akun'], $thn);
		}

		$this->db->select('Akun, Nama_Akun');
		$this->db->where("Akun = '5.'");

		$data['belanja'] = $this->db->get('keuangan_manual_ref_rek1')->result_array();

		foreach ($data['belanja'] as $i => $p)
		{
		  $data['belanja'][$i]['anggaran'] = $this->pagu_akun($p['Akun'], $thn);
		  $data['belanja'][$i]['realisasi'] = $this->real_akun_belanja($p['Akun'], $thn);
		  $data['belanja'][$i]['sub_belanja'] = $this->get_subval_belanja( $p['Akun'], $thn);
		}

    $this->db->select('Kd_Bid, Nama_Bidang');

		$data['belanja_bidang'] = $this->db->get('keuangan_manual_ref_bidang')->result_array();

		foreach ($data['belanja_bidang'] as $i => $p)
		{
      $data['belanja_bidang'][$i]['anggaran'] = $this->pagu_akun_bidang($p['Kd_Bid'], $thn);
		  $data['belanja_bidang'][$i]['realisasi'] = $this->real_akun_belanja_bidang($p['Kd_Bid'], $thn);
      $data['belanja_bidang'][$i]['sub_belanja'] = $this->get_subval_belanja_bidang( $p['Kd_Bid'], $thn);
		}

		$this->db->select('Akun, Nama_Akun');
		$this->db->where("Akun = '6.'");

		$data['pembiayaan'] = $this->db->get('keuangan_manual_ref_rek1')->result_array();
		foreach ($data['pembiayaan'] as $i => $p)
		{
		  $data['pembiayaan'][$i]['anggaran'] = $this->pagu_akun($p['Akun'], $thn);
		  $data['pembiayaan'][$i]['realisasi'] = $this->real_akun_pembiayaan($p['Akun'], $thn);
		  $data['pembiayaan'][$i]['sub_pembiayaan'] = $this->get_subval_pembiayaan( $p['Akun'], $thn);
		}

		$this->db->select('Akun, Nama_Akun');
		$this->db->where("Akun = '6.'");

		$data['pembiayaan_keluar'] = $this->db->get('keuangan_manual_ref_rek1')->result_array();
		foreach ($data['pembiayaan_keluar'] as $i => $p)
		{
		  $data['pembiayaan_keluar'][$i]['anggaran'] = $this->pagu_akun($p['Akun'], $thn);
		  $data['pembiayaan_keluar'][$i]['realisasi'] = $this->real_akun_pembiayaan($p['Akun'], $thn);
		  $data['pembiayaan_keluar'][$i]['sub_pembiayaan_keluar'] = $this->get_subval_pembiayaan_keluar( $p['Akun'], $thn);
		}
		return $data;
  }

  private function pagu_akun($akun, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 2) AS Akun, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $akun, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_akun_bidang($akun, $thn)
  {
    $this->db->select('LEFT(Kd_Keg, 10) AS Akun, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('LEFT(Kd_Keg, 10)', $akun, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_akun_pendapatan($akun, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 2) AS Akun, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $akun, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_akun_pendapatan_bunga($akun, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 2) AS Akun, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $akun, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_akun_belanja($akun, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 2) AS Akun, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $akun, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_akun_belanja_bidang($akun, $thn=false)
  {
		$this->db->select('LEFT(Kd_Keg, 10) AS Akun, SUM(Nilai_Realisasi) AS realisasi');
    $this->db->like('LEFT(Kd_Keg, 10)', $akun, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_akun_pembiayaan($akun, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 2) AS Akun, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $akun, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Akun');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function get_subval_pendapatan( $akun, $thn=false)
  {
		$this->db->select('Kelompok, Nama_Kelompok');
		$this->db->where('Akun', $akun);

		$data = $this->db->get('keuangan_manual_ref_rek2')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_subval_pendapatan($d['Kelompok'], $thn);
		  $data[$i]['realisasi'] = $this->real_subval_pendapatan($d['Kelompok'], $thn);
		  $data[$i]['sub_pendapatan2'] = $this->sub_pendapatan2( $d['Kelompok'], $thn);
		}
		return $data;
  }

  private function get_subval_belanja( $akun, $thn=false)
  {
		$this->db->select('Kelompok, Nama_Kelompok');
		$this->db->where('Akun', $akun);

		$data = $this->db->get('keuangan_manual_ref_rek2')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_subval_belanja($d['Kelompok'], $thn);
		  $data[$i]['realisasi'] = $this->real_subval_belanja($d['Kelompok'], $thn);
		  $data[$i]['sub_belanja2'] = $this->sub_belanja2( $d['Kelompok'], $thn);
		}
		return $data;
  }

  private function get_subval_belanja_bidang( $akun, $thn=false)
  {
		$this->db->select('ID_Keg, Nama_Kegiatan');
    $this->db->like('LEFT(ID_Keg, 10)', $akun, 'after');

    $this->db->order_by('ID_Keg');
		$data = $this->db->get('keuangan_manual_ref_kegiatan')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_subval_belanja_bidang($d['ID_Keg'], $thn);
		  $data[$i]['realisasi'] = $this->real_subval_belanja_bidang($d['ID_Keg'], $thn);
		}
		return $data;
  }

  private function get_subval_pembiayaan( $akun, $thn=false)
  {
		$this->db->select('Kelompok, Nama_Kelompok');
		$this->db->where('Akun', $akun);

		$this->db->where('Kelompok', '6.1.');
		$data = $this->db->get('keuangan_manual_ref_rek2')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_subval_pembiayaan($d['Kelompok'], $thn);
		  $data[$i]['realisasi'] = $this->real_subval_pembiayaan($d['Kelompok'], $thn);
		  $data[$i]['sub_pembiayaan2'] = $this->sub_pembiayaan2( $d['Kelompok'], $thn);
		}
		return $data;
  }

  private function get_subval_pembiayaan_keluar( $akun, $thn=false)
  {
		$this->db->select('Kelompok, Nama_Kelompok');
		$this->db->where('Akun', $akun);

		$this->db->where('Kelompok', '6.2.');
		$data = $this->db->get('keuangan_manual_ref_rek2')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_subval_pembiayaan_keluar($d['Kelompok'], $thn);
		  $data[$i]['realisasi'] = $this->real_subval_pembiayaan_keluar($d['Kelompok'], $thn);
		  $data[$i]['sub_pembiayaan_keluar2'] = $this->sub_pembiayaan_keluar2( $d['Kelompok'], $thn);
		}
		return $data;
  }

  private function pagu_subval_pendapatan($kelompok, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_subval_belanja($kelompok, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_subval_belanja_bidang($kelompok, $thn)
  {
		$this->db->select('Kd_Keg AS Kelompok, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Keg', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kd_Keg');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_subval_pembiayaan($kelompok, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_subval_pembiayaan_keluar($kelompok, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_pendapatan($kelompok, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_bunga($kelompok, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_belanja($kelompok, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_belanja_bidang($kelompok, $thn=false)
  {
		$this->db->select('Kd_Keg AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Keg', $kelompok, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_pembiayaan($kelompok, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_subval_pembiayaan_keluar($kelompok, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 4) AS Kelompok, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $kelompok, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kelompok');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function sub_pendapatan2( $kelompok, $thn=false)
  {
		$this->db->select('Kelompok, Jenis, Nama_Jenis');
		$this->db->where('Kelompok', $kelompok);

		$data = $this->db->get('keuangan_manual_ref_rek3')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_pendapatan2($d['Jenis'], $thn);
		  $data[$i]['realisasi'] = $this->real_pendapatan2($d['Jenis'], $thn);
		}
		return $data;
  }

  private function sub_belanja2($kelompok, $thn=false)
  {
		$this->db->select('Kelompok, Jenis, Nama_Jenis');
		$this->db->where('Kelompok', $kelompok);

		$data = $this->db->get('keuangan_manual_ref_rek3')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_belanja2($d['Jenis'], $thn);
		  $data[$i]['realisasi'] = $this->real_belanja2($d['Jenis'], $thn);
		}
		return $data;
  }

  private function sub_pembiayaan2($kelompok, $thn=false)
  {
		$this->db->select('Kelompok, Jenis, Nama_Jenis');
		$this->db->where('Kelompok', '6.1.');
		$this->db->where('Kelompok', $kelompok);

		$data = $this->db->get('keuangan_manual_ref_rek3')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_pembiayaan2($d['Jenis'], $thn);
		  $data[$i]['realisasi'] = $this->real_pembiayaan2($d['Jenis'], $thn);
		}
		return $data;
  }

  private function sub_pembiayaan_keluar2($kelompok, $thn=false)
  {
		$this->db->select('Kelompok, Jenis, Nama_Jenis');
		$this->db->where('Kelompok', '6.2.');
		$this->db->where('Kelompok', $kelompok);

		$data = $this->db->get('keuangan_manual_ref_rek3')->result_array();
		foreach ($data as $i => $d)
		{
		  $data[$i]['anggaran'] = $this->pagu_pembiayaan_keluar2($d['Jenis'], $thn);
		  $data[$i]['realisasi'] = $this->real_pembiayaan_keluar2($d['Jenis'], $thn);
		}
		return $data;
  }

  private function pagu_pendapatan2($jenis, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_belanja2($jenis, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_pembiayaan2($jenis, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function pagu_pembiayaan_keluar2($jenis, $thn)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Anggaran) AS pagu');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_pendapatan2($jenis, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_belanja2($jenis, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_pembiayaan2($jenis, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Kd_Rincian');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }

  private function real_pembiayaan_keluar2($jenis, $thn=false)
  {
		$this->db->select('LEFT(Kd_Rincian, 6) AS Jenis, SUM(Nilai_Realisasi) AS realisasi');
		$this->db->like('Kd_Rincian', $jenis, 'after');
		$this->db->where('keuangan_manual_rinci.Tahun', $thn);
		$this->db->group_by('Jenis');
		return $this->db->get('keuangan_manual_rinci')->result_array();
  }
}