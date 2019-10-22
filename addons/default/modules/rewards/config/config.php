<?php  defined('BASEPATH') OR exit('No direct script access allowed');

$config['default_path'] = '/uploads/default/files/article';
$config['max_width']	= '1600';
$config['max_height']	= '1600';
$config['max_size']		= '2048';

//ratio w=1.5 h=1
$config['use_pngquant'] =false;

//$config['default_photo_width'] = 300;
$config['default_photo_width'] = 500;
$config['default_photo_height'] = 500;
$config['default_photo_quality'] = 370;
$config['default_photo_thumb_width'] = 100;
$config['default_photo_thumb_height'] = 100;
$config['default_path_save_image'] = '';
$config['default_temporary'] = 'upload_temporary';
$config['article_route'] = 'smart-stories';
$config['article_route_milestone'] = array(
    'prakehamilan' => array(),
    'kehamilan' => array(),
    'trisemester1' => array('Bulan ke-1', 'Bulan ke-2', 'Bulan ke-3'),
    'trisemester2' => array('Bulan ke-4', 'Bulan ke-5', 'Bulan ke-6'),
    'trisemester3' => array('Bulan ke-7', 'Bulan ke-8', 'Bulan ke-9'),
    'bayi' => array(),
    'bayi0-6' => array('<span>1-2</span>Bulan', '<span>3-4</span>Bulan', '<span>5-6</span>Bulan'),
    'bayi7-12' => array('<span>7-8</span>Bulan', '<span>9-10</span>Bulan', '<span>11-12</span>Bulan'),
    'anak' => array(),
    'anak1-3' => array('<span>1</span>Tahun', '<span>2</span>Tahun', '<span>3</span>Tahun'),
    'anak4-6' => array('<span>4</span>Tahun', '<span>5</span>Tahun', '<span>6</span>Tahun'),
);
$config['article_copy_milestone'] = array(
    'prakehamilan' => array('Bagaimana cara tepat mempersiapkan kehamilan yang sehat? Apa yang harus dilakukan agar cepat hamil? Yuk, dapatkan informasi dan fitur seputar masa prakehamilan di sini.'),
    'kehamilan' => array('Tentunya banyak yang harus Mam ketahui dan perhatikan agar masa kehamilan Mam berjalan lancar. Di sini Mam bisa mendapatkan informasi lengkap tentang masa kehamilan dari trimester pertama sampai saat kelahiran nanti.'),
    'trisemester1' => array('Selamat atas kehamilan Mam! Di Trimester Pertama ini Mam mungkin merasa letih dan mual, tapi pastikan Mam dan janin tetap mendapat asupan nutrisi yang cukup, ya. Yuk, cari tau lebih banyak tentang Trimester Pertama bersama kami di sini.'),
    'trisemester2' => array('Banyak hal seru yang akan Mam temui di Trimester Kedua ini, lho. Perut yang mulai membuncit, gerakan si Kecil di dalam perut dan tiba waktunya mengintip si Kecil melalui USG. Banyak hal lain yang perlu Mam perhatikan agar kehamilan tetap lancar dan semua informasinya bisa Mam dapatkan di sini.'),
    'trisemester3' => array('Tak terasa Mam sudah memasuki Trimester Ketiga, Sudahkan Mam memilih tempat bersalin dan nama si Kecil? Mam juga akan disibukkan dengan belanja perlengkapan si Kecil, lho. Yuk, dapatkan info lengkap tentang Trimester terakhir ini di sini.'),
    'bayi' => array('Peran Mam penting dalam proses tumbuh kembang si Kecil, apalagi di masa awal kehidupanya ini. Yuk, dapatkan informasi lengkap seputar tumbuh kembang, parenting, stimulasi dan nutrisi si Kecil dari usia 0 - 12 bulan di sini.'),
    'bayi0-6' => array('Selemat menyambut kehadiran si Kecil! Memang banyak yang harus diperhatikan saat merawat bayi yang baru lahir. Tapi jangan khawatir, di sini kami siap membantu Mam dengan berbagai informasi seputar merawat bayi, memberi ASI dan tumbuh kembang bayi 0 - 6 bulan.'),
    'bayi7-12' => array('Kini si Kecil siap berkenalan dengan MPASI. Ia juga semakin pesat tumbuh dan aktif menunjukkan berbagai kebisaanya. Dapatkan berbagai info mengenai nutrisi, stimulasi dan serba-serbi lain seputar bayi usia 7 - 12 bulan di sini, karena dukungan Mam adalah yang utama bagi tumbuh kembang si Kecil.'),
    'anak' => array('Masa kanak - kanak akan membentuk kepintaran dan kehebatan si Kecil di masa yang akan datang. Karenanya ia akan terus membutuhkan dukungan Mam di periode tumbuh kembangnya ini. Yuk dapatkan informasi lengkap seputar tumbuh kembang, parenting, stimulasi dan nutrisi si Kecil dari usia 1 - 6 Tahun di sini.'),
    'anak1-3' => array('Di tahap ini otak si kecil masih berkembang dengan pesat. Ia juga membutuhkan stimulasi serta nutrisi yang tepat agar proses tumbuh kembangnya berjalan optimal. Yuk, terus dukung si Kecil. Di sini Mam bisa mendapatkan berbagai info dan fitur menarik seputar tumbuh kembang dan parenting bagi anak usia 1 - 3 Tahun.'),
    'anak4-6' => array('Di tahap ini si Kecil tentu semakin mandiri dan pandai bersosialisasi. Tetapi tentu ia masih memerlukan dukungan stimulasi dan nutrisi yang tepat dari Mam. Dapatkan informasi lengkap dan fitur menarik untuk dukung si Kecil yang berusia 4 - 6 Tahun di sini.'),
);
$config['sc_static_ids'] = array(
    'prakehamilan' => '159,166,168',
    'kehamilan' => '161,160,162',
    'trisemester1' => '161,160,162',
    'trisemester2' => '161,160,162',
    'trisemester3' => '161,160,162',
    'bayi' => '135,643,484',
    'bayi0-6' => '135,643,484',
    'bayi7-12' => '135,643,484',
    'anak' => '170,173,201',
    'anak1-3' => '170,173,201',
    'anak4-6' => '170,173,201',
);
