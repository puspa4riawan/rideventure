<?php include 'partials/html-head-start.php'; ?>


	<title>Buttons and Forms</title>

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

<div class="container c-inner">
	<h3>Buttons</h3>
	<p class="pt-3">Variasi</p>
	<button type="button" class="btn btn-primary capital">Primary</button>

	<button type="button" class="btn btn-primary">Primary</button>
	<button type="button" class="btn btn-secondary">Secondary</button>
	<button type="button" class="btn btn-success">Success</button>
	<button type="button" class="btn btn-danger">Danger</button>
	<button type="button" class="btn btn-warning">Warning</button>
	<button type="button" class="btn btn-info">Info</button>
	<button type="button" class="btn btn-light">Light</button>
	<button type="button" class="btn btn-dark">Dark</button>

	<button type="button" class="btn btn-link">Link</button>

	<button type="button" class="btn btn-merah">Link</button>
	<button type="button" class="btn btn-emas">Link</button>
	<button type="button" class="btn btn-p-emas">Link</button>

	<p class="pt-3">Ukuran</p>
	<button type="button" class="btn btn-primary btn-lg">Large button</button>
	<button type="button" class="btn btn-secondary btn-lg">Large button</button>
	<button type="button" class="btn btn-primary btn-sm">Small button</button>
	<button type="button" class="btn btn-secondary btn-sm">Small button</button>
	
	<p class="pt-3">Capital</p>
	<button type="button" class="btn btn-primary btn-capital">Large button</button>
	<hr>

	<h3>Forms</h3>
	<form>
	  <div class="form-group">
	    <label for="exampleFormControlInput1">Email address</label>
	    <input type="email" class="form-control" placeholder="name@example.com">
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlInput1">Valid input</label>
	    <input type="email" class="form-control is-valid" placeholder="name@example.com">
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlInput1">Invalid input</label>
	    <input type="email" class="form-control is-invalid" placeholder="name@example.com">
	    <p class="form-text invalid-feedback">
			  Salah
			</p>
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlInput1">Warning input</label>
	    <input type="email" class="form-control is-warning" placeholder="name@example.com">
	    <p class="form-text warning-feedback">
			  Warning
			</p>
	  </div>
	  <div class="form-group">
	  	<label for="">Checkbox and radio</label>
	  	<label class="custom-control custom-checkbox">
			  <input type="checkbox" class="custom-control-input">
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description">Check this custom checkbox</span>
			</label>
			<label class="custom-control custom-radio">
			  <input id="radio1" name="radio" type="radio" class="custom-control-input">
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description">Toggle this custom radio</span>
			</label>
			<label class="custom-control custom-radio">
			  <input id="radio2" name="radio" type="radio" class="custom-control-input">
			  <span class="custom-control-indicator"></span>
			  <span class="custom-control-description">Or toggle this other custom radio</span>
			</label>
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlSelect1">Example select</label>
	    <select class="form-control" id="exampleFormControlSelect1">
	      <option>1</option>
	      <option>2</option>
	      <option>3</option>
	      <option>4</option>
	      <option>5</option>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlSelect1">Example select with <code>.bs-select</code></label>
	    <div>
			  <select class="bs-select">
				  <option>Mustard</option>
				  <option>Ketchup</option>
				  <option>Relish</option>
				</select>
	    </div>
			<div class="dropdown is-valid">
			  <button class="btn btn-input dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    Dropdown button
			  </button>
			  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			    <a class="dropdown-item" href="#">Action</a>
			    <a class="dropdown-item" href="#">Another action</a>
			    <a class="dropdown-item" href="#">Something else here</a>
			  </div>
			</div>
	  </div>

	  <div class="form-group">
	    <label for="exampleFormControlSelect2">Example multiple select</label>
	    <select multiple class="form-control" id="exampleFormControlSelect2">
	      <option>1</option>
	      <option>2</option>
	      <option>3</option>
	      <option>4</option>
	      <option>5</option>
	    </select>
	  </div>
	  <div class="form-group">
	    <label for="exampleFormControlTextarea1">Example textarea</label>
	    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
	  </div>
	</form>
</div>



<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
	<script>
		
	</script>
<?php include 'partials/html-end.php'; ?>