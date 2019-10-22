<style>
.thank-you-page{
	background-color:#f3f3f3;
	min-height: 520px;
	color:#4a4a4a;
	background-image: url(addons/default/themes/wyeth/img/about-top-left-ornamen.png), url(addons/default/themes/wyeth/img/answer-top-right.png), url(addons/default/themes/wyeth/img/awan.png), url(addons/default/themes/wyeth/img/anak-kecil-balon.png);
	background-position: 4.25% 20px, right 40px, 24% 364px, right bottom;
	background-repeat: no-repeat;
}
.bergabung{
	font-family: 'RockoFLF';
  font-weight: bold;
	font-size:30px;
}
.page-title{
	font-family: 'RockoUltraFLF';
	font-size:60px;
	margin-bottom: -0.5rem;
}
p.caption{
	font-family:'Lato';
	font-weight:bold;
}
#thank-you-copy {
    text-align: center;
    width: 51%;
}
@media screen and (max-width: 1024px){
	#thank-you-copy{
		width: 80%;
	}
}
@media screen and (max-width: 768px){
	#thank-you-copy{
		min-height: 360px;
	}
}
@media screen and (max-width: 640px){
	#thank-you-copy{
		min-height: 400px;
	}
}
@media screen and (max-width: 480px){
	#thank-you-copy{
		width: 90%;
    min-height: 423px;
	}
}
@media screen and (max-width: 371px){
	#thank-you-copy{
    min-height: 500px;
	}
	.dicopy, a.dicopy{
		line-height: 1px;
	}
}
</style>
<!-- #main-container -->
<div id="main-container" class="search-page thank-you-page">
	<div class="container p-t-3">
		<h2 class="page-title">Terima kasih,</h2>
		<p class="text-xs-center lead bergabung">Sudah mendaftar untuk menjadi Mam Blogger</p>
	</div>
	<div class="container p-t-2" id="thank-you-copy">
		<div class="row">
			<p class="caption">Cek email Anda dan aktivasikan akun Anda pada folder inbox atau spam.</p>
			<p>
				Saat ini Anda sedang dalam proses seleksi untuk menjadi Mam Blogger. 
			</p>
		</div>
		<div class="row m-t-2 m-x-0 text-xs-center action">
			<a href="{{ url:site }}" class="btn btn-yellow round" id="load-more">Kembali ke Homepage</a>
		</div>
	</div>

</div>

<!-- Lightning Bolt Begins -->
 <script type="text/javascript">
     var lbTrans = '';
     var lbValue = '';
     var lbData = '';
     var lb_rn = new String(Math.random()); var lb_rns = lb_rn.substring(2, 12);
     var boltProtocol = ('https:' == document.location.protocol) ? 'https://' : 'http://';
     try {
         var newScript = document.createElement('script');
         var scriptElement = document.getElementsByTagName('script')[0];
         newScript.type = 'text/javascript';
         newScript.id = 'lightning_bolt_' + lb_rns;
         newScript.src = boltProtocol + 'cdn-akamai.mookie1.com/LB/LightningBolt.js';
         scriptElement.parentNode.insertBefore(newScript, scriptElement);
         scriptElement = null; newScript = null;
     } catch (e) { }
       </script>
 <!-- Lightning Bolt Ends -->
