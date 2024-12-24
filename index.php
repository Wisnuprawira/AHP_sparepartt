<?php
include 'functions.php';
if (empty($_SESSION['login']))
	header("location:login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="icon" href="favicon.ico" />
	<link rel="icon" href="favicon.ico" />

	<title>Tugas Akhir Zamzam </title>
	<link href="assets/css/sandstone-bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/general.css" rel="stylesheet" />
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/highcharts.js"></script>
	<script src="assets/js/highcharts-3d.js"></script>
	<script src="assets/js/exporting.js"></script>
	<style>
		/* Custom Sidebar Style */
		.sidebar {
			position: fixed;
			top: 0;
			left: 0;
			width: 250px;
			height: 100%;
			background-color: #333;
			padding-top: 20px;
			z-index: 999;
			transition: all 0.3s ease;
		}

		.sidebar a {
			display: block;
			color: white;
			padding: 10px 15px;
			text-decoration: none;
			font-size: 18px;
		}

		.sidebar a:hover {
			background-color: #575757;
		}

		/* Dropdown Menu */
		.sidebar .dropdown {
			position: relative;
		}

		/* Display dropdown content vertically */
		.sidebar .dropdown-content {
			display: none;
			position: relative;
			background-color: #444;
			padding: 0;
			min-width: 250px;
		}

		.sidebar .dropdown-content a {
			padding: 10px 20px;
			font-size: 16px;
			color: #ddd;
			text-decoration: none;
		}

		/* Show dropdown when hovering over parent */
		.sidebar .dropdown.open .dropdown-content {
			display: block;
		}

		/* Toggle button */
		.sidebar .toggle-btn {
			position: absolute;
			top: 20px;
			left: 260px; /* Make sure it's outside the sidebar */
			font-size: 24px;
			cursor: pointer;
			background-color: #333; /* Matching color with sidebar */
			color: white;
			border: none;
			padding: 12px;
			border-radius: 50%;
			transition: all 0.3s ease;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
		}

		/* Hover effect for toggle button */
		.sidebar .toggle-btn:hover {
			background-color: #575757;
		}

		/* Content area, with adjusted z-index to ensure it's on top of the chart */
		.content {
			margin-left: 250px;
			padding: 20px;
			position: relative;
			transition: margin-left 0.3s ease;
		}

		/* When sidebar is closed, adjust content width */
		.sidebar.closed {
			left: -250px;
		}

		.content.sidebar-closed {
			margin-left: 0;
		}

		/* Mobile view: Stack sidebar on top */
		@media (max-width: 768px) {
			.sidebar {
				width: 100%;
				height: auto;
				position: relative;
			}

			.content {
				margin-left: 0;
			}

			.sidebar .toggle-btn {
				display: block;
				position: absolute;
				top: 15px;
				left: 15px;
			}
		}
	</style>
</head>

<body>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Button to toggle the sidebar -->
		<button class="toggle-btn" onclick="toggleSidebar()">☰</button>

		<a href="?">Dashboard</a>

		<!-- Dropdown for AHP -->
		<div class="dropdown">
			<a href="javascript:void(0)" onclick="toggleDropdown(event)" class="dropdown-toggle"><span class="glyphicon glyphicon-th-large"></span> AHP</a>
			<div class="dropdown-content">
				<!-- <a href="?m=kriteria"><span class="glyphicon glyphicon-th-large"></span> Kriteria</a>
				<a href="?m=sub"><span class="glyphicon glyphicon-user"></span> Subkriteria</a> -->
			</div>
		</div>
		<a href="?m=kriteria"><span class="glyphicon glyphicon-th-large"></span> Kriteria</a>
		<a href="?m=sub"><span class="glyphicon glyphicon-user"></span> Subkriteria</a>
		<a href="?m=rel_kriteria"><span class="glyphicon glyphicon-th-large"></span> Nilai Bobot Kriteria</a>
		<a href="?m=rel_sub"><span class="glyphicon glyphicon-user"></span> Nilai Bobot Subkriteria</a>
		<a href="?m=rel_alternatif"><span class="glyphicon glyphicon-user"></span> Nilai Bobot Alternatif</a>
		<a href="?m=alternatif"><span class="glyphicon glyphicon-calendar"></span> alternatif</a>
		<a href="?m=hitung"><span class="glyphicon glyphicon-calendar"></span> Perhitungan</a>

		<!-- Dropdown for SAW -->
		<!-- <div class="dropdown">
			<a href="javascript:void(0)" onclick="toggleDropdown(event)" class="dropdown-toggle"><span class="glyphicon glyphicon-tasks"></span> SAW</a>
			<div class="dropdown-content">
				<a href="?m=kriteria_saw"><span class="glyphicon glyphicon-th-large"></span> Kriteria SAW</a>
				<a href="?m=rel_alternatif_saw"><span class="glyphicon glyphicon-user"></span> Nilai Alternatif SAW</a>
				<a href="?m=hitung_saw"><span class="glyphicon glyphicon-stats"></span> Perhitungan SAW</a>
			</div>
		</div> -->

		<!-- <a href="?m=ranking_gabungan"><span class="glyphicon glyphicon-list-alt"></span> Ranking Gabungan</a> -->
		<a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a>
		<a href="?m=user"><span class="glyphicon glyphicon-user"></span> User</a>
		<a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
	</div>

	<!-- Content -->
	<div class="content">
		<?php
			include_once 'functions.php';
			if (empty($_SESSION['login']))
				header("location:login.php");

			$mod = _get('m', 'home'); // Halaman default 'home'

			if (file_exists("$mod.php")) {
				include "$mod.php";
			} else {
				include 'home.php';
			}
		?>

		<!-- Chart -->
		<div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

		</div>
		<script type="text/javascript">
		$(function() {
			$('#chart1').highcharts(<?= json_encode(get_chart1()) ?>);
		})

		// Toggle Sidebar Function
		function toggleSidebar() {
			var sidebar = document.querySelector('.sidebar');
			var content = document.querySelector('.content');
			sidebar.classList.toggle('closed');
			content.classList.toggle('sidebar-closed');
		}

		// Toggle Dropdown Menu
		function toggleDropdown(event) {
			event.preventDefault();  // Prevent default link behavior
			var dropdown = event.target.closest('.dropdown');
			dropdown.classList.toggle('open');  // Toggle open class to show/hide dropdown
		}

		$('.form-control').attr('autocomplete', 'off');
	</script>

</body>
</html>
