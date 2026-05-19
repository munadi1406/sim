<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Manajemen Sekolah - <?= esc($web->nama_sekolah ?? 'SIMS') ?>">
    <title><?= isset($title) ? $title . ' - ' : '' ?><?= esc($web->nama_sekolah ?? 'SIMS') ?></title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- SB Admin 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body { font-family: 'Nunito', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #1a237e 0%, #283593 50%, #3949ab 100%) !important; }
        .sidebar .nav-item .nav-link { color: rgba(255,255,255,0.8) !important; }
        .sidebar .nav-item .nav-link:hover, .sidebar .nav-item.active .nav-link { color: #fff !important; }
        .sidebar-brand { background: rgba(0,0,0,0.15) !important; }
        .sidebar .nav-item .nav-link i { color: rgba(255,255,255,0.6); }
        .sidebar .nav-item.active .nav-link i { color: #fff; }
        .sidebar-divider { border-top: 1px solid rgba(255,255,255,0.15) !important; }
        .sidebar-heading { color: rgba(255,255,255,0.5) !important; }
        .topbar { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background: linear-gradient(135deg, #4e73df, #224abe); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #224abe, #1a3a9b); }
        .badge-aktif { background: #1cc88a; color: #fff; }
        .badge-nonaktif { background: #e74a3b; color: #fff; }
        .table td, .table th { vertical-align: middle; }
        .avatar-sm { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body id="page-top">
<div id="wrapper">
