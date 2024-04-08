<?php

return [
    'jenis_hari' => [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jum\'at',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ],
    'jenis_kelamin' => [
        'L' => 'Laki-laki',
        'P' => 'Perempuan'
    ],
    'status_barang' => [
        'dijual' => 'Dijual',
        'khusus servis' => 'Khusus Servis',
        'dijual & untuk servis' => 'Dijual & Untuk Servis',
        'tidak dijual' => 'Tidak Dijual'
    ],
    'status_serial' => [
        'sn' => 'Serial Number',
        'non sn' => 'Non Serial Number',
    ],
    'status_serial_barang' => [
        'ready' => 'Ready',
        'return' => 'Return',
        'cancel transaction' => 'Cancel Transaction',
        'not sold' => 'Not Sold'
    ],
    'tipe_print' => [
        'thermal' => 'Thermal',
        'biasa' => 'Biasa',
    ],
    'tipe_diskon' => [
        'fix' => 'Fix',
        '%' => '%',
    ],
    'tipe_pembayaran' => [
        'cash' => 'Cash',
        'transfer' => 'Transfer',
        'deposit' => 'Deposit',
    ],
    'tipe_servis' => [
        'data langsung ke bengkel' => 'Datang Langsung Ke Bengkel',
        'booking online' => 'Booking Online',
    ],
    'status_kendaraan_servis' => [
        'antrian servis masuk' => 'Antrian Servis Masuk',
        'menunggu sparepart' => 'Menunggu Sparepart',
        'proses servis' => 'Proses Servis',
        'bisa diambil' => 'Bisa Diambil',
        'tidak bisa' => 'Tidak Bisa',
        'cancel' => 'Cancel',
    ],
    'servis_berkala' => [
        'hari' => 'Hari',
        'bulan' => 'Bulan',
        'tahun' => 'Tahun',
    ],
    'pesanwa_berkala' => 'Kendaraan Anda Sudah Waktunya Melakukan Servis Berkala sesuai dengan tanggal yang sudah ditentukan dari kami. Terimakasih',
    'pesanwa_hutang' => 'Transaksi anda sudah melebihi batas waktu pembayaran. Silahkan segera melakukan pembayaran.',
    'pesanwa_hutangsupplier' => 'Transaksi saya yang sebelumnya belum lunas, akan segera kami lunasi sebelum jatuh tempo.',
    'status_tstock' => [
        'proses kirim' => 'Proses Kirim',
        'diterima' => 'Diterima',
        'ditolak' => 'Ditolak',
    ],
    'pesanwa_estimasi' => 'Estimasi Waktu Servis Kendaraan anda sudah mencapai waktunya. Silahkan datang ke bengkel kami untuk servis kendaraan anda.',
    // status kendaraan servis estimas = estimasi servis
];
