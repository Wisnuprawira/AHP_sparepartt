<?php
error_reporting(~E_NOTICE);
session_start();

include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/paging.php';

function is_able($mod)
{
    $role = array(
        'admin' => array(
            'user',
            'alternatif',
            'kriteria',
            'kriteria_saw',
            'nilai',
            'rel_alternatif',
            'hitung',
        ),
        'user' => array(
            'alternatif',
            'kriteria',
            'rel_alternatif',
            'hitung',
        ),
        'guest' => array(),
    );
    if (!_session('level'))
        $_SESSION['level'] = 'guest';
    if (!isset($role[_session('level')]))
        $_SESSION['level'] = 'guest';
    $level = strtolower(_session('level'));
    return in_array($mod, (array)$role[$level]);
}

function is_hidden($mod)
{
    return (is_able($mod)) ? '' : 'hidden';
}

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$nRI = array(
    1 => 0,
    2 => 0,
    3 => 0.58,
    4 => 0.9,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.46,
    10 => 1.49
);

$rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
foreach ($rows as $row) {
    $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
}

$rows = $db->get_results("SELECT kode_kriteria, nama_kriteria FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $KRITERIA[$row->kode_kriteria] = $row->nama_kriteria;
}


$rows = $db->get_results("SELECT * FROM tb_sub ORDER BY kode_sub");
foreach ($rows as $row) {
    $SUB[$row->kode_sub] = array(
        'nama' => $row->nama_sub,
        'kode_kriteria' => $row->kode_kriteria,
        'nilai_sub' => $row->nilai_sub,
    );
}

function get_relkriteria()
{
    global $db;
    $data = array();
    $rows = $db->get_results("SELECT k.nama_kriteria, rk.ID1, rk.ID2, nilai 
        FROM tb_rel_kriteria rk INNER JOIN tb_kriteria k ON k.kode_kriteria=rk.ID1 
        ORDER BY ID1, ID2");
    foreach ($rows as $row) {
        $data[$row->ID1][$row->ID2] = $row->nilai;
    }
    return $data;
}

function get_rel_alternatif($kriteria = '')
{
    global $db;
    $rows = $db->get_results("SELECT
       a.kode_alternatif, ra.kode_kriteria, s.kode_sub                	            
       FROM tb_rel_alternatif ra 
       INNER JOIN tb_alternatif a ON a.kode_alternatif = ra.kode_alternatif
       LEFT JOIN tb_sub s ON s.kode_sub=ra.kode_sub
       WHERE nama_alternatif LIKE '%" . esc_field(_get('q')) . "%'
       ORDER BY kode_alternatif, ra.kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->kode_alternatif][$row->kode_kriteria]  = $row->kode_sub;
    }
    return $arr;
}

function get_kriteria_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT kode_kriteria, nama_kriteria FROM tb_kriteria ORDER BY kode_kriteria");
    $a = '';
    foreach ($rows as $row) {
        if ($row->kode_kriteria == $selected)
            $a .= "<option value='$row->kode_kriteria' selected>$row->kode_kriteria - $row->nama_kriteria</option>";
        else
            $a .= "<option value='$row->kode_kriteria'>$row->kode_kriteria - $row->nama_kriteria</option>";
    }
    return $a;
}

function get_alternatif_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
    $a = '';
    foreach ($rows as $row) {
        if ($row->kode_alternatif == $selected)
            $a .= "<option value='$row->kode_alternatif' selected>$row->kode_alternatif - $row->nama_alternatif</option>";
        else
            $a .= "<option value='$row->kode_alternatif'>$row->kode_alternatif - $row->nama_alternatif</option>";
    }
    return $a;
}

function get_nilai_option($selected = '')
{
    $nilai = array(
        '1' => 'Sama penting dengan',
        '2' => 'Mendekati sedikit lebih penting dari',
        '3' => 'Sedikit lebih penting dari',
        '4' => 'Mendekati lebih penting dari',
        '5' => 'Lebih penting dari',
        '6' => 'Mendekati sangat penting dari',
        '7' => 'Sangat penting dari',
        '8' => 'Mendekati mutlak dari',
        '9' => 'Mutlak sangat penting dari',
    );
    $a = '';
    foreach ($nilai as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$key - $value</option>";
        else
            $a .= "<option value='$key'>$key - $value</option>";
    }
    return $a;
}

function get_sub_option($selected = '', $kode_kriteria)
{
    global $db;
    $where = "WHERE kode_kriteria='$kode_kriteria'";
    $rows = $db->get_results("SELECT kode_sub, nama_sub FROM tb_sub $where ORDER BY kode_sub");
    $a = '';
    foreach ($rows as $row) {
        if ($row->kode_sub == $selected)
            $a .= "<option value='$row->kode_sub' selected>$row->kode_sub - $row->nama_sub</option>";
        else
            $a .= "<option value='$row->kode_sub'>$row->kode_sub - $row->nama_sub</option>";
    }
    return $a;
}

function get_baris_total($matriks = array())
{
    $total = array();
    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            if (!isset($total[$k]))
                $total[$k] = 0;
            $total[$k] += $v;
        }
    }
    return $total;
}

function normalize($matriks = array(), $total = array())
{

    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            $matriks[$key][$k] = $matriks[$key][$k] / $total[$k];
        }
    }
    return $matriks;
}

function get_rata($normal)
{
    $rata = array();
    foreach ($normal as $key => $value) {
        $rata[$key] = array_sum($value) / count($value);
    }
    return $rata;
}

function mmult($matriks = array(), $rata = array())
{
    $arr = array();
    foreach ($matriks as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = $v * $rata[$k];
        }
    }
    return $arr;
}

function consistency_measure($matriks, $rata)
{
    $matriks = mmult($matriks, $rata);
    $arr = array();
    foreach ($matriks as $key => $value) {
        $arr[$key] = array_sum($value) / $rata[$key];
    }
    return $arr;
}

function get_rank($array)
{
    $data = $array;
    arsort($data);
    $no = 1;
    $new = array();
    foreach ($data as $key => $value) {
        $new[$key] = $no++;
    }
    return $new;
}

function FAHP_save($total = array())
{
    global $db;
    arsort($total);// Mengurutkan total secara descending
    $no = 1;
    foreach ($total as $key => $val) {
        $db->query("UPDATE tb_alternatif SET total='$val', rank='$no' WHERE kode_alternatif='$key'");
        $no++;
    }
}
function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

function kode_oto($field, $table, $prefix, $length)
{
    global $db;
    $var = (string)$db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . ((int)substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}
function get_level_option($selected = '')
{
    $arr = array(
        'admin' => 'Admin',
        'user' => 'User',
    );
    $a = '';
    foreach ($arr as $key => $val) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}

function esc_field($str)
{
    if ($str)
        return addslashes($str);
}

function get_option($option_name)
{
    global $db;
    return $db->get_var("SELECT option_value FROM tb_options WHERE option_name='$option_name'");
}

function update_option($option_name, $option_value)
{
    global $db;
    return $db->query("UPDATE tb_options SET option_value='$option_value' WHERE option_name='$option_name'");
}

function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}

function alert($url)
{
    echo '<script type="text/javascript">alert("' . $url . '");</script>';
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function ses_id()
{
    return session_id();
}

function get_jk_radio($selected)
{
    $array = array('Laki-laki', 'Perempuan');
    $a = '';
    foreach ($array as $arr) {
        if ($arr == $selected)
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr' checked> $arr
                </label>";
        else
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr'> $arr
                </label>";
    }
    return '<div class="radio">' . $a . '</div>';
}

function print_error($msg)
{
    die('<!DOCTYPE html>
    <html>
        <head><title>Error</title>
        <link href="../assets/css/united-bootstrap.min.css" rel="stylesheet"/>
        <body>
            <div class="container" style="margin:20px auto; width:400px">
                <p class="alert alert-warning">' . $msg . ' <a href="javascript:history.back(-1)">Kembali</a></p>                
            </div>
        </body>
    </html>');
}

function tgl_indo($date)
{
    $tanggal = explode('-', $date);

    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $bulan = $array_bulan[$tanggal[1] * 1];

    return $tanggal[2] . ' ' . $bulan . ' ' . $tanggal[0];
}

function terbilang($x)
{
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . "belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return " seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return " seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}
