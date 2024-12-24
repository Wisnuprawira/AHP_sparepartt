<div class="page-header">
    <h1>Perhitungan</h1>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Mengukur Konsistensi Kriteria</h3>
    </div>
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Matriks Perbandingan Kriteria</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <?php
                            $matriks = get_relkriteria();
                            $total = get_baris_total($matriks);
                            foreach ($matriks as $key => $val) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <?php foreach ($matriks as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= $KRITERIA[$key] ?></td>
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
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Normalisasi SAW</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <?php
                            $normal = normalize($matriks, $total);
                            $rata = get_rata($normal);
                            foreach ($matriks as $key => $val) : ?>
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
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Perkalian Matriks dengan Prioritas</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <?php
                            $mmult = mmult($matriks, $rata);
                            $cm = consistency_measure($matriks, $rata);
                            foreach ($matriks as $key => $val) : ?>
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
            </div>
            <div class="panel-body">
                Berikut tabel ratio index berdasarkan ordo matriks.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Ordo matriks</th>
                        <?php
                        foreach ($nRI as $key => $value) {
                            if (count($matriks) == $key)
                                echo "<td class='text-primary'>$key</td>";
                            else
                                echo "<td>$key</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Ratio index</th>
                        <?php
                        foreach ($nRI as $key => $value) {
                            if (count($matriks) == $key)
                                echo "<td class='text-primary'>$value</td>";
                            else
                                echo "<td>$value</td>";
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <div class="panel-body">
                <?php
                $CI = ((array_sum($cm) / count($cm)) - count($cm)) / (count($cm) - 1);
                $RI = $nRI[count($matriks)];
                $CR = $CI / $RI;
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
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Analisa</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            $data = get_rel_alternatif();
            foreach ($data as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= $SUB[$v]['nama'] ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php
function get_hasil_bobot($data)
{
    global $SUB;
    $arr = array();
    foreach ($data as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = $SUB[$v]['nilai_sub'];
        }
    }
    return $arr;

}
$hasil_bobot = get_hasil_bobot($data);
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Pembobotan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Kode</th>
                    <th rowspan="2">Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach ($rata as $key => $val) : ?>
                        <th><?= round($val, 4) ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            foreach ($hasil_bobot as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Perangkingan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            function get_total($hasil_bobot, $rata)
            {
                $arr = array();
                foreach ($hasil_bobot as $key => $val) {
                    $arr[$key] = 0;
                    foreach ($val as $k => $v) {
                        $arr[$key] += $v * $rata[$k];
                    }
                }
                return $arr;
            }
            $total = get_total($hasil_bobot, $rata);
            FAHP_save($total);
            $rows = $db->get_results("SELECT * FROM tb_alternatif  ORDER BY total DESC");
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->rank ?></td>
                    <td><?= $row->kode_alternatif ?></td>
                    <td><?= $row->nama_alternatif ?></td>
                    <td><?= round($row->total, 4) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <?php
        $best = $rows[0]->kode_alternatif;
        ?>
        <p>Jadi pilihan terbaik adalah <strong><?= $ALTERNATIF[$best] ?></strong> dengan nilai <strong><?= round($total[$best], 3) ?></strong></p>
        <p><a class="btn btn-default" target="_blank" href="cetak.php?m=hitung"><span class="glyphicon glyphicon-print"></span> Cetak</a></p>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-body">
        <style>
            .highcharts-credits {
                display: none;
            }
        </style>
        <?php
        function get_chart1()
        {
            global $db;
            $rows = $db->get_results("SELECT * FROM tb_alternatif ORDER BY total DESC");

            foreach ($rows as $row) {
                $data[$row->nama_alternatif] = $row->total * 1;
            }

            $chart = array();

            // Mengubah jenis chart menjadi 'line' (grafik garis)
            $chart['chart']['type'] = 'column'; 
            $chart['title']['text'] = 'Grafik Hasil Perangkingan';
            $chart['xAxis'] = array(
                'categories' => array_keys($data),
            );
            $chart['yAxis'] = array(
                'min' => 0,
                'title' => array('text' => 'Total'),
            );
            $chart['tooltip'] = array(
                'headerFormat' => '<span style="font-size:10px">{point.key}</span><table>',
                'pointFormat' => '<tr><td style="color:{series.color};padding:0">{series.name}: </td>
                    <td style="padding:0"><b>{point.y:.3f}</b></td></tr>',
                'footerFormat' => '</table>',
                'shared' => true,
                'useHTML' => true,
            );

            $chart['series'] = array(
                array(
                    'name' => 'Total nilai',
                    'data' => array_values($data),
                )
            );
            return $chart;
        }

        ?>
        <script>
            $(function() {
                $('#chart1').highcharts(<?= json_encode(get_chart1()) ?>);
            })
        </script>
        <div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>