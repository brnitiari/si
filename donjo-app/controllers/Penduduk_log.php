<?php

/*
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
 * Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
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
 * @package   OpenSID
 * @author    Tim Pengembang OpenDesa
 * @copyright Hak Cipta 2009 - 2015 Combine Resource Institution (http://lumbungkomunitas.net/)
 * @copyright Hak Cipta 2016 - 2024 Perkumpulan Desa Digital Terbuka (https://opendesa.id)
 * @license   http://www.gnu.org/licenses/gpl.html GPL V3
 * @link      https://github.com/OpenSID/OpenSID
 *
 */

defined('BASEPATH') || exit('No direct script access allowed');

class Penduduk_log extends Admin_Controller
{
    private $set_page;
    private $list_session;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['penduduk_model', 'penduduk_log_model']);
        $this->modul_ini     = 'kependudukan';
        $this->sub_modul_ini = 'penduduk';
        $this->set_page      = ['20', '50', '100'];
        $this->list_session  = ['filter_tahun', 'filter_bulan', 'kode_peristiwa', 'status_dasar', 'sex', 'agama', 'dusun', 'rw', 'rt', 'cari'];
    }

    public function clear()
    {
        $this->session->unset_userdata($this->list_session);
        $this->session->filter_bulan = date('n');
        $this->session->filter_tahun = date('Y');
        $this->session->per_page     = 20;

        redirect($this->controller);
    }

    public function index($p = 1, $o = 0)
    {
        $data['p'] = $p;
        $data['o'] = $o;

        foreach ($this->list_session as $list) {
            if (in_array($list, ['dusun', 'rw', 'rt'])) {
                ${$list} = $this->session->{$list};
            } else {
                $data[$list] = $this->session->{$list} ?: '';
            }
        }

        if (isset($dusun)) {
            $data['dusun']   = $dusun;
            $data['list_rw'] = $this->wilayah_model->list_rw($dusun);

            if (isset($rw)) {
                $data['rw']      = $rw;
                $data['list_rt'] = $this->wilayah_model->list_rt($dusun, $rw);

                if (isset($rt)) {
                    $data['rt'] = $rt;
                } else {
                    $data['rt'] = '';
                }
            } else {
                $data['rw'] = '';
            }
        } else {
            $data['dusun'] = $data['rw'] = $data['rt'] = '';
        }
        $data['tahun'] = $this->session->filter_tahun;
        $data['bulan'] = $this->session->filter_bulan;

        $per_page = $this->input->post('per_page');
        if (isset($per_page)) {
            $this->session->per_page = $per_page;
        }

        $data['func']                 = 'index';
        $data['per_page']             = $this->session->per_page;
        $data['set_page']             = $this->set_page;
        $data['paging']               = $this->penduduk_log_model->paging($p, $o);
        $data['main']                 = $this->penduduk_log_model->list_data($o, $data['paging']->offset, $data['paging']->per_page);
        $data['keyword']              = $this->penduduk_model->autocomplete();
        $data['tahun_log_pertama']    = $this->penduduk_log_model->tahun_log_pertama();
        $data['list_jenis_peristiwa'] = $this->referensi_model->list_data('ref_peristiwa');
        $data['list_sex']             = $this->referensi_model->list_data('tweb_penduduk_sex');
        $data['list_agama']           = $this->referensi_model->list_data('tweb_penduduk_agama');
        $data['list_dusun']           = $this->wilayah_model->list_dusun();

        $this->render('penduduk_log/penduduk_log', $data);
    }

    public function filter($filter)
    {
        $value = $this->input->post($filter);
        if ($value != '') {
            $this->session->{$filter} = $value;
        } else {
            $this->session->unset_userdata($filter);
        }

        redirect($this->controller);
    }

    public function dusun()
    {
        $this->session->unset_userdata(['rw', 'rt']);
        $dusun = $this->input->post('dusun');
        if ($dusun != '') {
            $this->session->dusun = $dusun;
        } else {
            $this->session->unset_userdata('dusun');
        }

        redirect($this->controller);
    }

    public function rw()
    {
        $this->session->unset_userdata('rt');
        $rw = $this->input->post('rw');
        if ($rw != '') {
            $this->session->rw = $rw;
        } else {
            $this->session->unset_userdata('rw');
        }

        redirect($this->controller);
    }

    public function rt()
    {
        $rt = $this->input->post('rt');
        if ($rt != '') {
            $this->session->rt = $rt;
        } else {
            $this->session->unset_userdata('rt');
        }

        redirect($this->controller);
    }

    public function tahun_bulan()
    {
        if ($bln = $this->input->post('bulan')) {
            $this->session->filter_bulan = $bln;
        } else {
            $this->session->unset_userdata('filter_bulan');
        }
        if ($thn = $this->input->post('tahun')) {
            $this->session->filter_tahun = $thn;
        } else {
            // Kalau tidak tentukan tahun, tampilkan semua
            $this->session->unset_userdata('filter_tahun');
            $this->session->unset_userdata('filter_bulan');
        }

        redirect($this->controller);
    }

    public function edit($p = 1, $o = 0, $id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['log_status_dasar'] = $this->penduduk_log_model->get_log($id) ?? show_404();
        $data['list_ref_pindah']  = $this->referensi_model->list_data('ref_pindah');
        $data['sebab']            = $this->referensi_model->list_ref(SEBAB);
        $data['penolong_mati']    = $this->referensi_model->list_ref(PENOLONG_MATI);
        $data['form_action']      = site_url("{$this->controller}/update/{$p}/{$o}/{$id}");

        $this->load->view('penduduk_log/ajax_edit', $data);
    }

    public function update($p = 1, $o = 0, $id = '')
    {
        $this->redirect_hak_akses('u');
        $this->penduduk_log_model->update($id);

        redirect("{$this->controller}/index/{$p}/{$o}");
    }

    public function kembalikan_status($id_log)
    {
        $this->redirect_hak_akses('u');

        if (! data_lengkap()) {
            show_404();
        }

        unset($_SESSION['success']);
        $this->penduduk_log_model->kembalikan_status($id_log);

        redirect($this->controller);
    }

    public function ajax_kembalikan_status_pergi($id = 0)
    {
        $this->redirect_hak_akses('u');
        $data['nik']         = $this->penduduk_model->get_penduduk($id);
        $data['form_action'] = site_url("{$this->controller}/kembalikan_status_pergi/{$id}");

        $this->load->view('sid/kependudukan/ajax_edit_status_dasar_pergi', $data);
    }

    public function kembalikan_status_pergi($id_log = 0)
    {
        $this->redirect_hak_akses('u');

        if (! data_lengkap()) {
            show_404();
        }

        unset($_SESSION['success']);
        $this->penduduk_log_model->kembalikan_status_pergi($id_log);

        redirect($this->controller);
    }

    public function kembalikan_status_all()
    {
        $this->redirect_hak_akses('u');

        if (! data_lengkap()) {
            show_404();
        }

        $this->penduduk_log_model->kembalikan_status_all();

        redirect($this->controller);
    }

    public function cetak($o = 0, $aksi = '', $privasi_nik = 0)
    {
        $data['main'] = $this->penduduk_log_model->list_data($o, 0);
        if ($privasi_nik == 1) {
            $data['privasi_nik'] = true;
        }

        $this->load->view("penduduk_log/penduduk_log_{$aksi}", $data);
    }

    public function ajax_cetak($o = 0, $aksi = '')
    {
        $data['o']                   = $o;
        $data['aksi']                = $aksi;
        $data['form_action']         = site_url("{$this->controller}/cetak/{$o}/{$aksi}");
        $data['form_action_privasi'] = site_url("{$this->controller}/cetak/{$o}/{$aksi}/1");

        $this->load->view('sid/kependudukan/ajax_cetak_bersama', $data);
    }
}
