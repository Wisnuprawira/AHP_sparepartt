<?php
$row = $db->get_row("SELECT * FROM tb_kriteria_saw WHERE kode_kriteria='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Ubah Kriteria SAW</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if ($_POST) include 'aksi.php' ?>
        <form method="post" action="aksi.php?action=ubah&kode=<?= $_GET['ID'] ?>">
            <div class="form-group">
                <label>Kode Kriteria <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" readonly="readonly" value="<?= $row->kode_kriteria ?>" />
            </div>
            <div class="form-group">
                <label>Nama Kriteria <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_kriteria" value="<?= $row->nama_kriteria ?>" required />
            </div>
            <div class="form-group">
                <label>Bobot <span class="text-danger">*</span></label>
                <input class="form-control" type="number" name="bobot" value="<?= $row->bobot ?>" required />
            </div>
            <div class="form-group">
                <label>Type <span class="text-danger">*</span></label>
                <select name="type" class="form-control">
                    <option value="benefit" <?= $row->type == 'benefit' ? 'selected' : '' ?>>Benefit</option>
                    <option value="cost" <?= $row->type == 'cost' ? 'selected' : '' ?>>Cost</option>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=kriteria_saw"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
