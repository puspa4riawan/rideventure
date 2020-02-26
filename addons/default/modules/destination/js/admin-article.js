$(document).ready(function() {
	$('body').on('click', '.set-featured', function(e){
		id_data = $(this).attr('data-id');
		featured 	= $(this).attr('data-featured');
		idx 	= $('.set-featured').index($(this));

		$.ajax({
			type: "POST",
			url: SITE_URL+ADMIN_URL+'/article/set_featured',
			data: $.extend(tokens,{id_data:id_data, featured:featured}),
			dataType: 'json',
			async: false,
			success: function(ret){
				tmlft();
				if(ret.status==false){
					alert(ret.msg);
					return false;
				}else{
					if(featured==1){
						$('.set-featured').eq(idx).attr('data-featured', '0');
						$('.info-featured').eq(idx).text('YES');
					}else{
						$('.set-featured').eq(idx).attr('data-featured', '1');
						$('.info-featured').eq(idx).text('NO');
					}
				}
	  		},
		});
	});

	$('body').on('click', '.set-featured-milestone', function(e) {
		var idx = $('.set-featured-milestone').index($(this)),
			featured = $(this).attr('data-featured'),
			submit = {
				id_data: $(this).attr('data-id'),
				featured: featured
			};

		$.ajax({
			type: 'POST',
			url: SITE_URL+ADMIN_URL+'/article/set_featured_milestone',
			data: $.extend(tokens, submit),
			dataType: 'json',
			async: false,
			success: function(ret) {
				tmlft();

				if (ret.status == false) {
					alert(ret.msg);
					return false;
				} else {
					if (featured == 1) {
						$('.set-featured-milestone').eq(idx).attr('data-featured', '0');
						$('.info-featured-milestone').eq(idx).text('NO');
					} else {
						$('.set-featured-milestone').eq(idx).attr('data-featured', '1');
						$('.info-featured-milestone').eq(idx).text('YES');
					}
				}
	  		},
		});
	});

	$('body').on('click', '.set-featured-afs', function(e){
		id_data = $(this).attr('data-id');
		featured_afs 	= $(this).attr('data-featured-afs');
		idx 	= $('.set-featured-afs').index($(this));

		$.ajax({
			type: "POST",
			url: SITE_URL+ADMIN_URL+'/article/set_featured_afs',
			data: $.extend(tokens,{id_data:id_data, featured_afs:featured_afs}),
			dataType: 'json',
			async: false,
			success: function(ret){
				tmlft();
				if(ret.status==false){
					alert(ret.msg);
					return false;
				}else{
					if(featured_afs==1){
						$('.set-featured-afs').eq(idx).attr('data-featured-afs', '0');
						$('.info-featured-afs').eq(idx).text('YES');
					}else{
						$('.set-featured-afs').eq(idx).attr('data-featured-afs', '1');
						$('.info-featured-afs').eq(idx).text('NO');
					}
				}
	  		},
		});
	});

	$('body').on('click', '.set-featured-kecilhebat', function(e){
		id_data = $(this).attr('data-id');
		featured_kecilhebat 	= $(this).attr('data-featured-kecilhebat');
		idx 	= $('.set-featured-kecilhebat').index($(this));

		$.ajax({
			type: "POST",
			url: SITE_URL+ADMIN_URL+'/article/set_featured_kecilhebat',
			data: $.extend(tokens,{id_data:id_data, featured_kecilhebat:featured_kecilhebat}),
			dataType: 'json',
			async: false,
			success: function(ret){
				tmlft();
				if(ret.status==false){
					alert(ret.msg);
					return false;
				}else{
					if(featured_kecilhebat==1){
						$('.set-featured-kecilhebat').eq(idx).attr('data-featured-kecilhebat', '0');
						$('.info-featured-kecilhebat').eq(idx).text('YES');
					}else{
						$('.set-featured-kecilhebat').eq(idx).attr('data-featured-kecilhebat', '1');
						$('.info-featured-kecilhebat').eq(idx).text('NO');
					}
				}
	  		},
		});
	});
});