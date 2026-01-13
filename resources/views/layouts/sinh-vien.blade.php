<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sinh viên') - Hệ thống quản lý</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255,255,255,0.2);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        .sidebar .nav-section {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            opacity: 0.7;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .user-info {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .user-info .user-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .user-info .user-role {
            font-size: 0.9rem;
            opacity: 0.8;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="bi bi-mortarboard-fill"></i> QLSV
        </div>
        
        <div class="user-info">
            <div class="user-name">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->sinhVien->ho_ten }}
            </div>
            <div class="user-role">
                <i class="bi bi-tag"></i> {{ Auth::user()->sinhVien->ma_sinh_vien }}<br>
                <i class="bi bi-building"></i> {{ Auth::user()->sinhVien->lop->ten_lop }}
            </div>
        </div>
        
        <nav class="nav flex-column">
            <a href="{{ route('sinh-vien.dashboard') }}" class="nav-link {{ request()->routeIs('sinh-vien.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <div class="nav-section">Học tập</div>
            <a href="{{ route('sinh-vien.diems.index') }}" class="nav-link {{ request()->routeIs('sinh-vien.diems.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Xem điểm
            </a>
            
            <div class="nav-section" style="margin-top: auto; padding-top: 30px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </nav>
    </div>
    
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
