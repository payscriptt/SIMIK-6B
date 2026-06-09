<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar_toggle.css') }}">
</head>
<body>
    <div class="topbar">
         <div class="logo" style="display: flex; align-items: center; gap: 10px;">
    <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>
    
    <img src="{{ asset('JVS.png') }}" alt="Logo JVS" style="height: 50px; width: auto; object-fit: contain;">
    
</div>
       <div class="user-menu" style="display: flex; align-items: center;">
            <i class="fa-solid fa-circle-user" style="font-size: 20px;"></i> 
            <span style="margin-left: 5px; margin-right: 20px;">
                {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->username : 'Guest' }}
            </span>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; font: inherit; padding: 0;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> LogOut
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="menu-section">
                <h4><i class="fa-solid fa-house"></i> Dashboard</h4>
                <ul>
                    <li class="active"><a href="{{ url('/dashboard') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-house"></i> Home</a></li>
                </ul>
            </div>
            
            <div class="menu-section">
                <h4><i class="fa-solid fa-database"></i> Master Data</h4>
                <ul>
                    <li><a href="{{ url('/barang') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-folder"></i> Data Barang</a></li>
                    <li><a href="{{ url('/supplier') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-users"></i> Data Supplier</a></li>
                </ul>
            </div>

            <div class="menu-section">
                <h4><i class="fa-solid fa-file-invoice"></i> Transfer Data</h4>
                <ul>
                    <li><a href="{{ url('/barang_masuk') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-arrow-turn-down"></i> Barang Masuk</a></li>
                    <li><a href="{{ url('/barang_keluar') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-arrow-turn-up"></i> Barang Keluar</a></li>
                </ul>
            </div>
        </div>

        <div class="content">
            <div class="welcome-banner">
                <i class="fa-solid fa-house welcome-icon"></i>
                <div class="welcome-text">
                    <h2>Dashboard Admin</h2>
                    <p>Selamat Datang di Sistem Informasi Manajemen Inventaris Kantor</p>
                </div>
            </div>

            <div class="cards-grid">
                
                <div class="stat-card card-masuk">
                    <i class="fa-solid fa-arrow-turn-down bg-icon"></i>
                    <div class="card-content">
                        <h1 id="stat-barang-masuk">{{ $total_barang_masuk ?? 0 }}</h1>
                        <p>Barang<br>Masuk</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/barang_masuk') }}">More Info <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card card-supplier">
                    <i class="fa-solid fa-cart-flatbed bg-icon"></i>
                    <div class="card-content">
                        <h1 id="stat-supplier">{{ $total_supplier ?? 0 }}</h1>
                        <p>Supplier</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/supplier') }}">More Info <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card card-total">
                    <i class="fa-solid fa-folder bg-icon"></i>
                    <div class="card-content">
                        <h1 id="stat-total-barang">{{ $total_barang ?? 0 }}</h1>
                        <p>Total<br>Barang</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/barang') }}">More Info <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="stat-card card-keluar">
                    <i class="fa-solid fa-arrow-turn-up bg-icon"></i>
                    <div class="card-content">
                        <h1 id="stat-barang-keluar">{{ $total_barang_keluar ?? 0 }}</h1>
                        <p>Barang<br>Keluar</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/barang_keluar') }}">More Info <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('collapsed');
    }

    // Fungsi AJAX Fetch untuk mengambil data realtime dari Controller
    function updateDashboardStats() {
        fetch("{{ url('/api/dashboard-stats') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Gagal mengambil data statistik");
                }
                return response.json();
            })
            .then(data => {
                // Menyuntikkan angka dari database ke komponen HTML secara realtime
                document.getElementById('stat-barang-masuk').innerText = data.total_barang_masuk;
                document.getElementById('stat-supplier').innerText = data.total_supplier;
                document.getElementById('stat-total-barang').innerText = data.total_barang;
                document.getElementById('stat-barang-keluar').innerText = data.total_barang_keluar;
            })
            .catch(error => console.error('Error realtime polling:', error));
    }

    document.addEventListener('DOMContentLoaded', () => {
     
        setInterval(updateDashboardStats, 1000);
    });
</script>
</body>
</html>