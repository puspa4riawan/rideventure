<!-- #main-container -->
<div id="main-container">
	<div class="container">
		<h3>Selamat Datang Mam, </h3>
		<?php echo form_open('', '', '', array('id'=>'formUpdate')); ?>
			<div class="form-group">
				<label class="control-label">Nama Depan</label>
				<input type="text" name="first_name" class="form-control round" value="<?php echo isset($profile->first_name) ? $profile->first_name : ''; ?>">
				<?php if($error = form_error('first_name')){ echo '<p class="error first_name">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Nama Belakang</label>
				<input type="text" name="last_name" class="form-control round" value="<?php echo isset($profile->last_name) ? $profile->last_name : ''; ?>">
				<?php if($error = form_error('last_name')){ echo '<p class="error last_name">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Tanggal Lahir</label>
				<input type="text" name="dob" class="form-control round" value="<?php echo isset($profile->dob) ? $profile->dob : ''; ?>" onfocus="(this.type='date')" onblur="(this.type='text')">
				<?php if($error = form_error('dob')){ echo '<p class="error dob">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Phone</label>
				<input type="text" name="phone" class="form-control round" value="<?php echo isset($profile->phone) ? $profile->phone : ''; ?>">
				<?php if($error = form_error('phone')){ echo '<p class="error phone">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Alamat</label>
				<input type="text" name="address" class="form-control round" value="<?php echo isset($profile->address) ? $profile->address : $profile->address_line1; ?>">
				<?php if($error = form_error('address')){ echo '<p class="error address">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Provinsi</label>
				<?php echo form_dropdown('region', $region, isset($profile->region) ? $profile->region : '', 'class="form-control round"'); ?>
				<?php if($error = form_error('region')){ echo '<p class="error region">'.$error.'</p>'; } ?>
			</div>
			<div class="form-group">
				<label class="control-label">Kabupaten</label>
				<?php 
					if($city){
						echo form_dropdown('city', $city, isset($profile->city) ? $profile->city : '', 'class="form-control round"');
					}
				?>
				<?php if($error = form_error('city')){ echo '<p class="error city">'.$error.'</p>'; } ?>
			</div>
			<div class="" style="width:250px;height:250px">
				<img src="{{theme:image_url file='article01.jpg'}}" style="width:250px;height:250px" id="profile_image">
				<input type="file" name="photo_profile" class="sr-only" id="profileInput">
				<button type="button" id="gantiFoto" class="btn btn-red round">Ganti Foto</button>
			</div>
			<br><br>
			<h4>Data Anak</h4>
			<div class="radio">
				<label><input type="radio" name="child_gender" value="1"> Laki-laki</label>
				<label><input type="radio" name="child_gender" value="2"> Perempuan</label>
				<p class="error child_gender"></p>
			</div>
			<div class="form-group">
				<label class="control-label">Nama Anak</label>
				<input type="text" name="child_name" class="form-control round">
				<p class="error child_name"></p>
			</div>
			<div class="form-group">
				<label class="control-label">Tanggal Lahir Anak</label>
				<input type="date" name="child_dob" class="form-control round" onfocus="(this.type='date')" onblur="(this.type='text')">
				<p class="error child_dob"></p>
			</div>
			<div class="child">
				
			</div>
			<button type="button" id="addChild" class="btn btn-red round">Tambah Anak</button>
			<br><br>
			<h4>Apakah Mam, Sedang Hamil?</h4>
			<div class="checkbox">
				<label><input type="checkbox" name="pregnant" value="1" <?php echo isset($profile->pregnant) && $profile->pregnant ? 'checked' : ''; ?>>Saya sekarang lagi hamil, usia kandungan</label>
			</div>
			<div class="form-group">
				<label class="control-label">Usia Kandungan</label>
				<select class="form-control round" name="pregnancy_age">
					<option value="">Pilih Usia Kandungan</option>
					<option value="1" <?php echo isset($profile->pregnancy_age) && $profile->pregnancy_age==1 ? 'selected' : ''; ?>>Trimester 1</option>
					<option value="2" <?php echo isset($profile->pregnancy_age) && $profile->pregnancy_age==2 ? 'selected' : ''; ?>>Trimester 2</option>
					<option value="3" <?php echo isset($profile->pregnancy_age) && $profile->pregnancy_age==3 ? 'selected' : ''; ?>>Trimester 3</option>
				</select>
				<p class="error pregnancy_age"></p>
			</div>
			<input type="hidden" name="image">
			<button type="submit" name="" class="btn btn-red round">Update Profile</button>
		<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var $profile_image = $('#profile_image');
		$profile_image.cropper({
			aspectRatio: 1 / 1,
			viewMode: 3,
	        dragMode: 'move',
	        autoCropArea: 1,
	        restore: false,
	        guides: false,
	        highlight: false,
	        background: false,
			cropBoxMovable: false,
			cropBoxResizable: false,
			cropend: function(e) {
				var image = $profile_image.cropper('getCroppedCanvas', {width:250, height:250}).toDataURL('image/jpeg');
				$('input[name=image]').val(image);
			},
		});

		$(document).on('click', '#gantiFoto', function(e){
			e.preventDefault();
			$('#profileInput').click();
		});

		$(document).on('change', 'select[name=region]', function(e){
			e.preventDefault();
			var region_id = $(this).val();
			$.ajax({
				type:'POST',
				url: SITE_URL+'users/get_city',
				dataType:'json',
				data:$.extend(tokens, {region_id:region_id}),
				success:function(res){
					var html = '<option value="">Pilih Kabupaten</option>';

					$.each(res, function(i, val){
						html += '<option value="'+i+'">'+val+'</option>'
					});

					$('select[name=city]').html(html);
				},
		   });
		});

		$(document).on('click', '#addChild', function(e){
			e.preventDefault();
			var valid = true;

			var child_gender = $('input[name=child_gender]:checked').val();
			if(!child_gender){
				valid = false;
				$('.error.child_gender').html('Jenis Kelamin Anak Dibutuhkan');
				$('.error.child_gender').show();
			}else{
				$('.error.child_gender').hide();
			}

			var child_name = $('input[name=child_name]').val();
			if(!child_name){
				valid = false;
				$('.error.child_name').html('Nama Anak Dibutuhkan');
				$('.error.child_name').show();
			}else{
				$('.error.child_name').hide();
			}

			var child_dob = $('input[name=child_dob]').val();
			if(!child_dob){
				valid = false;
				$('.error.child_dob').html('Tanggal Lahir Anak Dibutuhkan');
				$('.error.child_dob').show();
			}else{
				$('.error.child_dob').hide();
			}

			if(valid){
				$.ajax({
					type:'POST',
					url: SITE_URL+'users/add_child',
					dataType:'json',
					data:$.extend(tokens, {child_name:child_name, child_gender:child_gender, child_dob:child_dob}),
					success:function(res){
						if(res.status){
							var html  = '<div class="single-child">';
								html += '<p>'+res.data.name+'</p>';
								html += '<p>'+res.data.umur.y+' Tahun</p>';
								html += '<p>'+res.data.umur.m+' Bulan</p>';
								html += '<p>'+res.data.umur.d+' Hari</p>';
								html += '</div>';

							$('.child').append(html);
							$('input[name=child_name]').val('');
							$('input[name=child_dob]').val('');
						}else{
							$.each(res.errors, function(i, val){
								$('.'+i).html(val);
								$('.'+i).show();
							});
						}
					},
			   });
			}
		});

		// Import image
		var $inputImage = $('#profileInput');
		var URL = window.URL || window.webkitURL;
		var blobURL;

		if (URL) {
			$inputImage.change(function () {
				var files = this.files;
				var file;

				if (!$profile_image.data('cropper')) {
					return;
				}

				if (files && files.length) {
					file = files[0];

					if (/^image\/\w+$/.test(file.type)) {
						blobURL = URL.createObjectURL(file);
						$profile_image.one('built.cropper', function () {
							// Revoke when load complete
							URL.revokeObjectURL(blobURL);
						}).cropper('reset').cropper('replace', blobURL);
						$inputImage.val('');
					} else {
						window.alert('Silahkan memilih file photo dengan format yang sesuai');
					}
				}
			});
		} else {
			$inputImage.prop('disabled', true).parent().addClass('disabled');
		}
	});
</script>