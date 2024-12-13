<div class="page-header">
    <h1>Nilai Bobot Sub Kriteria</h1>
</div>
<?php
$kode_kriteria = _get('kode_kriteria');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="rel_sub" />
            <div class="form-group">
                <select class="form-control" name="kode_kriteria" onchange="this.form.submit()">
                    <option value="">Pilih kriteria</option>
                    <?= get_kriteria_option($kode_kriteria) ?>
                </select>
            </div>
        </form>
    </div>
    <div class="panel-body">
        <?php
        if ($_POST) include 'aksi.php';
        $rows = $db->get_results("SELECT r.ID1, r.ID2, nilai 
            FROM tb_rel_sub r 
            INNER JOIN tb_sub s1 ON s1.kode_sub=r.ID1
            INNER JOIN tb_sub s2 ON s2.kode_sub=r.ID2
            WHERE s1.kode_kriteria='$kode_kriteria' AND s2.kode_kriteria='$kode_kriteria'     
            ORDER BY ID1, ID2");
        $criterias = array();
        $matriks = array();
        foreach ($rows as $row) {
            $matriks[$row->ID1][$row->ID2] = $row->nilai;
        }
        $total = get_baris_total($matriks);
        $normal = normalize($matriks, $total);
        $rata = get_rata($normal);
        $mmult = mmult($matriks, $rata);
        foreach ($rata as $key => $val) {
            $db->query("UPDATE tb_sub SET nilai_sub='$val' WHERE kode_sub='$key'");
        }
        $cm = consistency_measure($matriks, $rata);
        ?>
        <form class="form-inline" action="?m=rel_sub&kode_kriteria=<?= $kode_kriteria ?>" method="post">
            <div class="form-group">
                <select class="form-control" name="ID1">
                    <?= get_sub_option(set_value('ID1'), $kode_kriteria) ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="nilai">
                    <?= get_nilai_option(set_value('nilai')) ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="ID2">
                    <?= get_sub_option(set_value('ID2'), $kode_kriteria) ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
            </div>
        </form>
    </div>
    <?php if ($matriks) : ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <?php foreach ($matriks as $key => $val) : ?>
                            <th><?= $key ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <?php foreach ($matriks as $key => $val) : ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= $SUB[$key]['nama'] ?></td>
                        <?php foreach ($val as $k => $v) : ?>
                            <td><?= round($v, 3) ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                <tfoot>
                    <td>&nbsp;</td>
                    <td>Total</td>
                    <?php foreach ($total as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                </tfoot>
            </table>
        </div>
        <div class="panel-body">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($matriks as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                    <th>Prioritas</th>
                </tr>
            </thead>
            <?php foreach ($normal as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                    <td><?= round($rata[$key], 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="panel-body">

        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($matriks as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                    <th>Total</th>
                    <th>CM (Total/Prioritas)</th>
                </tr>
            </thead>
            <?php foreach ($mmult as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                    <td><?= round(array_sum($val), 3) ?></td>
                    <td><?= round($cm[$key], 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <div class="panel-body">
            <?php
            $CI = ((array_sum($cm) / count($cm)) - count($cm)) / (count($cm) - 1);
            $RI = $nRI[count($matriks)];
            $CR = $RI == 0 ? 0 : $CI / $RI;
            echo "<p>Consistency Index: " . round($CI, 3) . "<br />";
            echo "Ratio Index: " . round($RI, 3) . "<br />";
            echo "Consistency Ratio: " . round($CR, 3);
            if ($CR > 0.10) {
                echo " (Tidak konsisten)<br />";
            } else {
                echo " (Konsisten)<br />";
            }
            ?>
        </div>
    <?php endif ?>
</div>