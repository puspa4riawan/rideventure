<?php include 'partials/html-head-start.php'; ?>
	<title>Vaksin Homepage</title>
	<!-- separate page style -->
	<link rel="stylesheet" href="css/p-vaksin.css">
<?php include 'partials/html-head-end.php'; ?>
<!-- END HTML-HEADER, START PAGE -->


<?php include 'partials/mainNav-unreg.php'; ?>

<main id="mainContent">
  <section class="bg-cream mainMargin-b">
    <div class="container c-inner text-center mainPadding">
      <div class="vaksin-section-subtitle text-body">
        <h2 class="text-inherit strong">Mam, yuk hitung jadwal imunisasi si kecil</h2>
      </div>

      <p>Kami akan membantu Mam mengingat jadwal pemberian imunisasi sekaligus memberikan panduan lengkap imunisasi. Untuk memulai, lengkapi dulu riwayat imunisasi si kecil ya Mam.</p>
    </div>

    <div class="container c-inner text-center mainPadding-b">
      <div class="vaksin-section-title text-emas3">
        <h2 class="text-inherit">Riwayat Imunisasi</h2>
      </div>

      <div class="anak-wrap">
        <div class="btn-group dd-select-anak">
          <div class="anak-current">
            <div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
            <div>
              <span class="anak-name">Abyan Nandana</span>
              <a href="">Edit</a>
            </div>
          </div>
          <button type="button" class="btn btn-link dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
          </button>

          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">
              <div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
              <span class="anak-name">Nama Anak Panjang Banget dah</span>
            </a>
            <a class="dropdown-item" href="#">
              <div class="anak-img"><img src="uploads/avatar-01.jpg" alt=""></div>
              <span class="anak-name">Nama Anak</span>
            </a>
            <a href="" class="dropdown-item">
              <div class="btn btn-link w-100">+ Tambah anak</div>
            </a>
          </div>
        </div>

        <hr>

        <dl class="anak-detail">
          <dt>Usia</dt>
          <dd>3 Bulan</dd>

          <dt>Jenis imunisasi berikutnya</dt>
          <dd>
            Hepatitis B 1/3, Polio 1/3, PVC 2/3 <br>
            Hepatitis B 3/3, Polio 1/3
          </dd>
        </dl>
      </div>
    </div>

    <div class="sw-vaksin-flag">
      <div class="flag-wrap">
        <div class="bulans">
          <button class="flag bulan"><span>1</span></button>
          <button class="flag bulan"><span>2</span></button>
          <button class="flag bulan"><span>3</span></button>
          <button class="flag bulan"><span>4</span></button>
          <button class="flag bulan"><span>5</span></button>
          <button class="flag bulan"><span>6</span></button>
          <button class="flag bulan"><span>9</span></button>
          <button class="flag bulan"><span>12</span></button>
          <button class="flag bulan"><span>15</span></button>
          <button class="flag bulan"><span>18</span></button>
          <button class="flag bulan"><span>24</span></button>
        </div>
        <div class="tahuns">
          <button class="flag tahun"><span>3</span></button>
          <button class="flag tahun"><span>5</span></button>
          <button class="flag tahun"><span>6</span></button>
          <button class="flag tahun"><span>7</span></button>
          <button class="flag tahun"><span>8</span></button>
          <button class="flag tahun"><span>9</span></button>
          <button class="flag tahun"><span>10</span></button>
          <button class="flag tahun"><span>12</span></button>
          <button class="flag tahun"><span>18</span></button>
        </div>
      </div>
    </div>


    <div class="bg-emas-gr">
      <div class="container c-inner">
        <div class="row align-items-center">
          <div class="col">
            <div class="vaksin-section-subtitle vaksin-section-subtitle-bulan">
              <h2 class="text-inherit">Bulan 1</h2>
            </div>
          </div>
          <div class="col-auto">
            <!-- <span class="badge bg-white badge-imunisasi">
              <i class="icon-check-green" aria-hidden="true"></i> 
              <span class="small strong text-success">Imunisasi lengkap</span>
            </span> -->
            <span class="badge bg-success badge-imunisasi">
              <i class="icon-check-white" aria-hidden="true"></i> 
              <span class="small strong text-white">Imunisasi lengkap</span>
            </span>
           <!--  <span class="badge bg-danger badge-imunisasi">
              <i class="icon-times-white" aria-hidden="true"></i> 
              <span class="small strong text-white">Imunisasi belum lengkap</span>
            </span> -->
          </div>
        </div>
      </div>
    </div>

    <div class="container c-inner mainPadding">


<div class="accordion jadwal-accordion" id="jadwalImunisasiTerlaksana">
  <h3 class="h5 mb-3 strong">Jadwal Imunisasi Bulan Ini</h3>
  <div class="jadwal">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong">Polio - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>03/09/2018 - 03/10/2018</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlaksana">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            <span class="text-muted">Belum ada catatan</span>
          </div>
          <button class="btn btn-text-gray" data-toggle="modal" data-target="#puCatatanVaksin"><i class="fa fa-sticky-note" aria-label="Catatan"></i></button>
        </div>
        
        <div class="jadwal-content">
          <h6 class="strong">Mengapa Anak Perlu Mendapat Imunisasi Polio?</h6>
          <ol>
            <li>Polio atau poliomielitis adalah penyakit demam akut yang disebabkan oleh virus polio.</li>
            <li>Infeksi virus polio dapat menyebabkan kerusakan saraf dan mengakibatkan kelumpuhan.</li>
            <li>Penyakit dapat berjalan tanpa gejala hingga kelumpuhan total dan mengecilnya otot yang dapat menetap selamanya, bahkan dapat menimbulkan kematian.</li>
            <li>Penularannya adalah melalui memakan makanan dan minuman yang tercemar virus polio.</li>
            <li>Untuk itu, pencegahan yang paling utama adalah dengan menjaga kebersihan makanan dan minuman serta mendapatkan imunisasi.</li>
          </ol>

          <h6 class="strong">Kapan Saja Anak Harus Mendapat Imunisasi Polio?</h6>
          <ul>
            <li>Imunisasi polio perlu diberikan sebanyak 6 kali.</li>
            <li>Imunisasi pertama harus diberikan segera setelah lahir, diikuti pada usia 2 bulan, 4 bulan, 6 bulan, pada 18-24 bulan, dan pada usia 5 tahun.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <p class="small strong">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasi">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>
  <div class="jadwal">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong">Hepatitis B - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>09/10/2018 - 16/10/2018</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseOne">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlaksana">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            <span class="text-muted">Belum ada Catatan</span>
          </div>
          <button class="btn btn-text-gray" data-toggle="modal" data-target="#puCatatanVaksin"><i class="fa fa-sticky-note" aria-label="Catatan"></i></button>
        </div>

        <div class="jadwal-content">
          <h6 class="strong">Mengapa Anak Perlu Mendapat Imunisasi Hepatitis B?</h6>
          <ol>
            <li>Hepatitis B merupakan penyakit yang disebabkan oleh infeksi virus hepatitis B yang menyerang organ hati.</li>
            <li>Infeksi ini dapat terjadi pada awal masa anak-anak atau pada saat dewasa dan belum dapat ditangani oleh antivirus dengan memuaskan.</li>
            <li>Penyakit dapat berjalan tanpa gejala hingga berkembang menjadi kronis terutama pada mereka yang terkena infeksi hepatitis B sejak anak-anak, dan dapat berkembang menjadi keganasan (kanker).</li>
            <li>Untuk itu, pencegahan yang paling utama adalah dengan mencegah penyakit hepatitis B terjadi pada usia sedini mungkin melalui vaksinasi pada saat bayi baru lahir.</li>
          </ol>

          <h6 class="strong">Kapan Saja Anak Harus Mendapat Imunisasi Hepatitis B?</h6>
          <ul>
            <li>Imunisasi hepatitis B ini perlu diberikan sebanyak 3 kali.</li>
            <li>Imunisasi pertama harus diberikan segera setelah lahir, diikuti pada usia 1 bulan dan 6 bulan.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <h6 class="strong mb-4">Belum Melakukan Imunisasi?</h6>
        <p class="small strong">Ingatkan Melalui:</p>
        <div class="btns d-flex justify-content-center">
          <a href="" class="btn btn-white btn-maw10rem btn-icon-left btn-capital" data-toggle="modal" data-target="#puAllowCalendar"><i class="wy wy-calendar" aria-hidden="true"></i> Calendar</a>
          <a href="" class="btn btn-white btn-maw10rem btn-icon-left btn-capital" data-toggle="modal" data-target="#puEmailReminder"><i class="wy wy-envelope" aria-hidden="true"></i> Email</a>          
        </div>

        <p class="small strong mt-6">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puCatatTanggalOnly">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>
  <div class="jadwal jadwal-incomplete">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong">Polio - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>1 Januari 2010</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapse-04" aria-expanded="false" aria-controls="collapse-04">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapse-04" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlewat">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            Belum ada catatan
          </div>
          <button class="btn btn-text-gray" data-toggle="modal" data-target="#puCatatanVaksin"><i class="fa fa-sticky-note" aria-label="Catatan"></i></button>
        </div>
        
        <div class="jadwal-content">
          <h6 class="strong">Mengapa Anak Perlu Mendapat Imunisasi Polio?</h6>
          <ol>
            <li>Polio atau poliomielitis adalah penyakit demam akut yang disebabkan oleh virus polio.</li>
            <li>Infeksi virus polio dapat menyebabkan kerusakan saraf dan mengakibatkan kelumpuhan.</li>
            <li>Penyakit dapat berjalan tanpa gejala hingga kelumpuhan total dan mengecilnya otot yang dapat menetap selamanya, bahkan dapat menimbulkan kematian.</li>
            <li>Penularannya adalah melalui memakan makanan dan minuman yang tercemar virus polio.</li>
            <li>Untuk itu, pencegahan yang paling utama adalah dengan menjaga kebersihan makanan dan minuman serta mendapatkan imunisasi.</li>
          </ol>

          <h6 class="strong">Kapan Saja Anak Harus Mendapat Imunisasi Polio?</h6>
          <ul>
            <li>Imunisasi polio perlu diberikan sebanyak 6 kali.</li>
            <li>Imunisasi pertama harus diberikan segera setelah lahir, diikuti pada usia 2 bulan, 4 bulan, 6 bulan, pada 18-24 bulan, dan pada usia 5 tahun.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <h6 class="strong mb-3">Ingin melakukan imunisasi yang terlewat</h6>
        <p>Untuk penanganan yang tepat, konsultasikan dengan dokter anak anda secara langsung atau konsultasi dengan tim ahli kami</p>
        <a href="" class="my-5 d-block mx-auto">Konsultasi dengan ahli</a>
        <p class="small strong">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puCatatTanggalOnly">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>

</div>

<!-- <div class="accordion jadwal-accordion" id="jadwalImunisasiTerlewat">
  <h3 class="h5 mb-3 strong text-danger">Jadwal Imunisasi Terlewat</h3>
  <div class="jadwal jadwal-incomplete">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong">Polio - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>1 Januari 2010</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapse-04" aria-expanded="false" aria-controls="collapse-04">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapse-04" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlewat">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            Belum ada catatan
          </div>
          <button class="btn btn-text-gray">Note</button>
        </div>
        
        <div class="jadwal-content">
          <h6 class="strong">Mengapa</h6>
          <ol>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis harum mollitia numquam sapiente illum maxime? Ipsa, quos, adipisci fugiat blanditiis nesciunt alias asperiores ullam vero quis, fuga error rem! Ducimus.</li>
            <li>Numquam, explicabo, saepe. Repellat architecto laboriosam vero ratione accusamus nobis totam alias laudantium enim laborum unde, earum, delectus pariatur tempore veniam excepturi autem molestiae similique odio, necessitatibus et voluptatibus recusandae.</li>
            <li>Necessitatibus, rem possimus sed unde voluptas qui aliquam, id placeat animi, dicta repudiandae. Ab voluptatum quo officia, minus. Molestiae dolorum corporis obcaecati ullam iste accusamus vel, et commodi quo? Et.</li>
          </ol>

          <h6 class="strong">Kapan</h6>
          <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos laudantium reprehenderit, eum est distinctio illo quisquam quos et maxime architecto unde hic sit omnis facilis aspernatur, cumque voluptate, expedita. Voluptatem.</li>
            <li>Veniam vitae, dolores quasi qui ex consequatur accusantium dolorum? Perspiciatis, nisi! Harum deleniti delectus expedita modi adipisci quod veritatis molestias ipsam officia odio repellendus, hic eius. Error debitis quaerat, rerum.</li>
            <li>Iste cum officiis, numquam illo molestiae maiores quaerat earum quis est nobis corrupti ratione deserunt obcaecati reprehenderit. Fugit unde totam, quia atque dicta cupiditate magni, officiis eum ad, nulla voluptate.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <h6 class="strong mb-3">Ingin melakukan imunisasi yang terlewat</h6>
        <p>Untuk penanganan yang tepat, konsultasikan dengan dokter anak anda secara langsung atau konsultasi dengan tim ahli kami</p>
        <a href="" class="my-5 d-block mx-auto">Konsultasi dengan ahli</a>
        <p class="small strong">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasi">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>
  <div class="jadwal">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong text-success">Polio - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>1 Januari 2010</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapse-05" aria-expanded="false" aria-controls="collapse-05">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapse-05" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlewat">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            Belum ada catatan
          </div>
          <button class="btn btn-text-gray">Note</button>
        </div>
        
        <div class="jadwal-content">
          <h6 class="strong">Mengapa</h6>
          <ol>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis harum mollitia numquam sapiente illum maxime? Ipsa, quos, adipisci fugiat blanditiis nesciunt alias asperiores ullam vero quis, fuga error rem! Ducimus.</li>
            <li>Numquam, explicabo, saepe. Repellat architecto laboriosam vero ratione accusamus nobis totam alias laudantium enim laborum unde, earum, delectus pariatur tempore veniam excepturi autem molestiae similique odio, necessitatibus et voluptatibus recusandae.</li>
            <li>Necessitatibus, rem possimus sed unde voluptas qui aliquam, id placeat animi, dicta repudiandae. Ab voluptatum quo officia, minus. Molestiae dolorum corporis obcaecati ullam iste accusamus vel, et commodi quo? Et.</li>
          </ol>

          <h6 class="strong">Kapan</h6>
          <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos laudantium reprehenderit, eum est distinctio illo quisquam quos et maxime architecto unde hic sit omnis facilis aspernatur, cumque voluptate, expedita. Voluptatem.</li>
            <li>Veniam vitae, dolores quasi qui ex consequatur accusantium dolorum? Perspiciatis, nisi! Harum deleniti delectus expedita modi adipisci quod veritatis molestias ipsam officia odio repellendus, hic eius. Error debitis quaerat, rerum.</li>
            <li>Iste cum officiis, numquam illo molestiae maiores quaerat earum quis est nobis corrupti ratione deserunt obcaecati reprehenderit. Fugit unde totam, quia atque dicta cupiditate magni, officiis eum ad, nulla voluptate.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <p class="small strong">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasi">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>
  <div class="jadwal">
    <div class="jadwal-header" id="headingOne">
      <div>
        <h4 class="h5 strong">Polio - 1/3</h4>
        <span class="small strong">Tanggal rekomendasi imunisasi</span>
        <p>1 Januari 2010</p>
      </div>
      <button class="btn btn-text-gray collapsed" type="button" data-toggle="collapse" data-target="#collapse-06" aria-expanded="false" aria-controls="collapse-06">
        <i class="fa" aria-label="View detail"></i>
      </button>
    </div>

    <div id="collapse-06" class="collapse" aria-labelledby="headingOne" data-parent="#jadwalImunisasiTerlewat">
      <div class="jadwal-body">
        <div class="jadwal-note">
          <div class="jadwal-note-content">
            Belum ada catatan
          </div>
          <button class="btn btn-text-gray">Note</button>
        </div>
        
        <div class="jadwal-content">
          <h6 class="strong">Mengapa</h6>
          <ol>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis harum mollitia numquam sapiente illum maxime? Ipsa, quos, adipisci fugiat blanditiis nesciunt alias asperiores ullam vero quis, fuga error rem! Ducimus.</li>
            <li>Numquam, explicabo, saepe. Repellat architecto laboriosam vero ratione accusamus nobis totam alias laudantium enim laborum unde, earum, delectus pariatur tempore veniam excepturi autem molestiae similique odio, necessitatibus et voluptatibus recusandae.</li>
            <li>Necessitatibus, rem possimus sed unde voluptas qui aliquam, id placeat animi, dicta repudiandae. Ab voluptatum quo officia, minus. Molestiae dolorum corporis obcaecati ullam iste accusamus vel, et commodi quo? Et.</li>
          </ol>

          <h6 class="strong">Kapan</h6>
          <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos laudantium reprehenderit, eum est distinctio illo quisquam quos et maxime architecto unde hic sit omnis facilis aspernatur, cumque voluptate, expedita. Voluptatem.</li>
            <li>Veniam vitae, dolores quasi qui ex consequatur accusantium dolorum? Perspiciatis, nisi! Harum deleniti delectus expedita modi adipisci quod veritatis molestias ipsam officia odio repellendus, hic eius. Error debitis quaerat, rerum.</li>
            <li>Iste cum officiis, numquam illo molestiae maiores quaerat earum quis est nobis corrupti ratione deserunt obcaecati reprehenderit. Fugit unde totam, quia atque dicta cupiditate magni, officiis eum ad, nulla voluptate.</li>
          </ul>
        </div>
      </div>
      <div class="jadwal-footer text-center">
        <p class="small strong">Update tanggal jika telah melakukan</p>
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasi">Update tanggal <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>

      </div>
    </div>
  </div>
</div> -->


    </div>

    <div class="container c-inner">
      <div class="row pb-5">
        <div class="col-6 col-md-3">
          <a href="" class="btn btn-link btn-capital btn-icon-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Sebelumnya</a>
        </div>
        <div class="col-6 col-md-3 order-md-3 text-right">
          <a href="" class="btn btn-link btn-capital btn-icon-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Selanjutnya</a>
        </div>
        <div class="col-12 col-md-6 order-md-2 text-center">
          <a href="" class="btn btn-outline-primary btn-capital btn-icon-right bg-white btn-wider text-primary">Download jadwal imunisasi</a>
        </div>
      </div>

      <!-- <p class="pb-5 text-center">
        <a href="" class="btn btn-primary btn-icon-right btn-capital btn-maw20rem" data-toggle="modal" data-target="#puJadwalImunisasiTerlaksana">Selesai <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </p> -->
      
      <p class="pb-5 text-center">
        <a href="vaksin-landing-tidak-ingat.php">Lewati proses ini</a>
      </p>
    </div>

  </section>

  <div class="container c-inner mainPadding-b">
    <div class="vaksin-section-title text-emas3 text-center mb-4">
      <h2 class="text-inherit">Fitur Lainnya</h2>
    </div>

    <div class="vaksin-fitur-card">
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_5W1H_Small.png');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_5W1H_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-right">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Kenapa si Kecil harus Imunisasi?</h3>
        </div>

        <p>Pelajari lebih dalam tentang imunisasi agar si Kecil selalu sehat terbebas wabah penyakit yang bisa diantisipasi jauh-jauh hari.</p>

        <a href="" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </div>
    </div>

    <div class="vaksin-fitur-card">
      <div class="bg hidden-sm-down" style="background-image: url('uploads/Ft_Mitos dan Fakta_Small.png');"></div>
      <div class="bg hidden-md-up" style="background-image: url('uploads/Ft_Mitos dan Fakta_Small-m.png');"></div>

      <div class="vaksin-fitur-card-text vaksin-fitur-card-text-left">
        <div class="vaksin-fitur-card-title">
          <h3 class="text-inherit">Mitos atau Fakta mengenai Imunisasi</h3>          
        </div>

        <p>Lengkapi wawasan Mam tentang mitos dan fakta imunisasi.</p>

        <a href="" class="btn btn-primary btn-icon-right btn-capital">Cari tahu sekarang <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>

</main>

<?php include 'partials/puIntroVaksin.php'; ?>
<?php include 'partials/puCatatTanggal.php'; ?>
<?php include 'partials/puCatatanVaksin.php'; ?>
<?php include 'partials/puJadwalImunisasiTerlaksana.php'; ?>
<?php include 'partials/puTanggalImunisasiUpdated.php'; ?>
<?php include 'partials/puAllowCalendar.php'; ?>
<?php include 'partials/puEmailReminder.php'; ?>
<?php include 'partials/puEmailReminderUpdated.php'; ?>

<?php include 'partials/footerAbout.php'; ?>

<?php include 'partials/mainFooter.php'; ?>


<!-- END PAGE, START HTML-FOOTER -->
	<?php include 'partials/html-script.php'; ?>
	<!-- custom script goes below -->
  <script>
    var lg= 992;

    function fFlags(){
      if ( $('.flag-wrap').outerWidth() >= $(window).outerWidth() ) {
        $('.sw-vaksin-flag').mCustomScrollbar({
          axis: 'x',
          theme: 'dark',
          autoHideScrollbar: true,
          scrollbarPosition: 'outside'
        });
      } else {
        $('.sw-vaksin-flag').mCustomScrollbar('destroy');
      }
    }

    $(document).ready(function(){
      // open popup intro vaksin
      // $('#puIntroVaksin').modal('show');

      fFlags();

      varSwVaksin = new Swiper('.sw-vaksin .swiper-container', {
        centeredSlides: true,
        slidesPerView: 'auto',
        touchMoveStopPropagation:false,
        simulateTouch : false, 
        allowSwipeToNext: false, 
        allowSwipeToPrev: false,
        allowTouchMove: false,
        touchRatio: 0, 
        navigation: {
          nextEl: '.next-pane',
          prevEl: '.prev-pane',
        },
      });

      varSwVaksin.on( 'slideChangeTransitionStart', function(){
        console.log('blah');
        $('.flag[role="button"]').last().addClass('flag-mark');
        $('.flag[role="button"]').prevAll().removeClass('flag-mark');
      })

      varSwVaksin.on( 'slideNextTransitionStart', function () {
        // ubah ke button
        $('.flag').eq(varSwVaksin.activeIndex)
          .attr({
            'tabindex': '0',
            'role': 'button',
            'aria-label': 'Lihat riwayat vaksin bulan ke-' + (varSwVaksin.activeIndex + 1)
          })
          .addClass('flag-mark');

        // bulan sebelumnya ubah ke button
        $('.flag').eq((varSwVaksin.activeIndex - 1))
          .attr({
            'tabindex': '0',
            'role': 'button',
            'aria-label': 'Lihat riwayat vaksin bulan ke-' + (varSwVaksin.activeIndex)
          })
          .removeClass('flag-mark');

        // click prev bulan to slide
        $('.flag[role="button"]').click(function(){
          // console.log( $('.bulan').index(this) );
          varSwVaksin.slideTo( $('.flag').index(this) );
          $(this).addClass('flag-mark');
        })
      });

      $('.flag').eq(0).addClass('flag-mark');
      // $('.flag').eq(1).addClass('flag-complete');
      // $('.flag').eq(2).addClass('flag-incomplete');

    });

    $(window).on('resize', function(){
      fFlags();
    });

    $('#closePuEmailReminder').click(function(){
      $('#puEmailReminder').modal('hide'); //close the current modal
      $("#puEmailReminder").on("hidden.bs.modal",function(){
        $("#puEmailReminderUpdated").modal("show");
      });
    });
  </script>

<?php include 'partials/html-end.php'; ?>