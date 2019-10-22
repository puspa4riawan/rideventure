<div class="container" style="padding-top: 0px;">
  <h1 class="page-header">Profile</h1>
  <div class="row">
	<!-- left column -->
	<div class="col-md-4 col-sm-6 col-xs-12">
	  <div class="text-center">
		<img src="<?php echo $_SESSION['user']->profilepic ?>" class="avatar img-circle img-thumbnail" alt="avatar">
	  </div>
	</div>
	<!-- edit form column -->
	<div class="col-md-8 col-sm-6 col-xs-12 personal-info">
	  <h3>Personal info</h3>
	  <form class="form-horizontal" role="form">
		<div class="form-group">
		  <label class="col-lg-3 control-label">Uid:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->uid ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">First name:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->firstname ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Last name:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->lastname ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Email:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->email ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-3 control-label">Username:</label>
		  <div class="col-md-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->username ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-3 control-label">Birthday:</label>
		  <div class="col-md-8">
			<input class="form-control" value="<?php echo date('F d, Y', strtotime($_SESSION['user']->birthday)); ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-md-3 control-label">Gender:</label>
		  <div class="col-md-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->gender == 'm' ? 'Male' : ($_SESSION['user']->gender == 'f' ? 'Female' : 'Unknown'); ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Phone:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->phone ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">City:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->city ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Registered Client:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->client_name ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Registered At:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->date_registered ?>" type="text" readonly>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-lg-3 control-label">Last Updated At:</label>
		  <div class="col-lg-8">
			<input class="form-control" value="<?php echo $_SESSION['user']->date_last_updated ?>" type="text" readonly>
		  </div>
		</div>
	  </form>
	</div>
  </div>
</div>
