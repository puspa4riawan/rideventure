<?php include 'partials/html-head-start.php'; ?>


	<title>Icon Pack</title>

	<!-- separate page style -->
	<link rel="stylesheet" href="">
	<style>
		.box{
			display: inline-block;
			width: 100px;
			height: 100px;
			margin-bottom: 4px;
		}
		.panjang{
			display: block;
			width: 100%;
		}
	</style>

<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->
<style type="text/css">
	body{
		background: #e3e3e3;
	}
	div{
		margin-bottom: 20px;
	}
	label{
		display: inline-block;
		width: 100px;
	}
</style>
<div class="container c-inner">
	<div class="row">
		<div class="col-12">
			<h1>Icon Pack</h1>
			<?php
			$file = file_get_contents(__DIR__.'/scss/wy/_icon.scss');
			// $file = json_encode($file, true);
			$file = explode('&.', $file);
			unset($file[0]);
			$target = 0;
			$plus = array();
			$child = false;
			$tmp = '';
			$n = 0;
			foreach ($file as $key => $class) {
				$a = explode('width:', $class);
				$a = str_replace('{', '', $a[0]);
				if (strpos($a, 'background-position') != false) {
					$a = explode('background-position', $a);
					$a = $a[0];
					$child = true;
					$n++;

					$tmp = $file[$key - $n];

					$tmp = explode('width:', $tmp);
					$tmp = str_replace('{', '', $tmp[0]);
				} else {
					$child = false;
					$tmp = '';
					$n = 0;
				}
				$a = $tmp.' '.$a;
				print_r('<div><label>'.$a.'</label><i class="i '.$a.'"></i></div><br>');
				if (!$child) {
					$tmp = '';
				}
			}
			?>
		</div>
	</div>
</div>

<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
		
	</script>
<?php include 'partials/html-end.php'; ?>