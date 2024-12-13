<?php
session_start();
?>

<div class="page-header">
    <h1>Tambah Kriteria SAW</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <form method="post" action="aksi.php?action=tambah">
            <div class="form-group">
                <label>Kode Kriteria</label>
                <input type="text" name="kode" class="form-control" required />
                <?php if (isset($_SESSION['error']) && $_SESSION['error'] == "Kode kriteria telah digunakan!"): ?>
                    <small class="text-danger"><?= $_SESSION['error'] ?></small>
                <?php unset($_SESSION['error']); endif; ?>
            </div>
            <div class="form-group">
                <label>Nama Kriteria</label>
                <input type="text" name="nama_kriteria" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Bobot</label>
                <input type="number" name="bobot" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="kriteria_saw.php" class="btn btn-default">Batal</a>
        </form>
    </div>
</div>
