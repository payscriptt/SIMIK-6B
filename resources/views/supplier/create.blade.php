<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier - SIMIK</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Khusus Halaman Create -->
    <link rel="stylesheet" href="{{ asset('css/supplier.css') }}">
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
                    <li><a href="{{ url('/dashboard') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-house"></i> Home</a></li>
                </ul>
            </div>
            
            <div class="menu-section">
                <h4><i class="fa-solid fa-database"></i> Master Data</h4>
                <ul>
                    <li><a href="{{ url('/barang') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-folder"></i> Data Barang</a></li>
                    <li class="active"><a href="{{ url('/supplier') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-users"></i> Data Supplier</a></li>
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
        
        <div class="content" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 85vh; padding: 20px;">
    
    <div class="form-card" style="width: 100%; max-width: 500px; display: flex; flex-direction: column; align-items: center;">
        <h3 class="form-title" style="text-align: center; margin-bottom: 20px;">Supplier</h3>
        
        @if($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; width: 100%; box-sizing: border-box;">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form action="{{ url('/supplier') }}" method="POST" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            @csrf
            
            <div class="form-group" style="width: 100%; margin-bottom: 15px; display: flex; flex-direction: column;">
                <label style="margin-bottom: 5px; text-align: left;">Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="width: 100%; margin-bottom: 15px; display: flex; flex-direction: column;">
                <label style="margin-bottom: 5px; text-align: left;">NO Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="width: 100%; margin-bottom: 15px; display: flex; flex-direction: column;">
                <label style="margin-bottom: 5px; text-align: left;">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <div class="form-group" style="width: 100%; margin-bottom: 20px; display: flex; flex-direction: column;">
                <label style="margin-bottom: 5px; text-align: left;">ID Supplier</label>
                <input type="text" name="id_supplier" value="{{ old('id_supplier') }}" required style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            
            <button type="submit" class="btn-submit" style="width: 100%; padding: 10px;">SUBMIT</button>
        </form>
    </div>
</div>
    </div>
</div>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }
    </script>
</body>
</html>
