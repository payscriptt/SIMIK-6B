<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar - SIMIK</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Khusus Barang Keluar -->
    <link rel="stylesheet" href="{{ asset('css/barang_keluar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print_preview.css') }}">
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
                    <li><a href="{{ url('/') }}" style="text-decoration:none; color:inherit; display:flex; gap:10px; align-items:center;"><i class="fa-solid fa-house"></i> Home</a></li>
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
                    <li class="active"><i class="fa-solid fa-arrow-turn-up"></i> Barang Keluar</li>
                </ul>
            </div>
        </div>
        
        <div class="content">
            <div class="form-table-container">
                <div class="form-card-wrapper">
                    <div class="form-card">
                        <h3 class="form-title">Input barang Keluar</h3>
                       @if($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ $errors->first() }}
    </div>
@endif

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<form action="{{ url('/barang_keluar') }}" method="POST" id="form-barang-keluar">
    @csrf
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required>
    </div>
    
    <div class="form-group">
        <label>ID Barang</label>
        <input type="text" name="id_barang" required>
    </div>
    
    <div class="form-group">
        <label>ID Keluar</label>
        <input type="text" name="id_keluar" required>
    </div>
    
    <div class="form-group">
        <label>Tanggal</label>
        <input type="date" name="tanggal" required>
    </div>
    
    <div class="form-group">
        <label>Jumlah</label>
        <input type="number" name="jumlah" min="1" required>
    </div>
</form>
</div>

<button type="submit" form="form-barang-keluar" class="btn-submit">SUBMIT</button>
<button type="button" class="btn-print">Cetak PDF <i class="fa-solid fa-file"></i></button>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="5%">NO</th>
                                <th width="30%">NAMA BARANG</th>
                                <th width="20%">ID BARANG</th>
                                <th width="25%">TANGGAL</th>
                                <th width="20%">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang_keluars ?? [] as $index => $bk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $bk->barang->nama_barang ?? 'Barang tidak ditemukan' }}</td>
                                <td>{{ $bk->id_barang }}</td>
                                <td>{{ \Carbon\Carbon::parse($bk->tanggal_keluar)->format('d/m/Y') }}</td>
                                <td>{{ $bk->jumlah_barang_keluar }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center;">Data Barang Keluar Kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Preview Modal -->
    <div id="printPreviewModal" class="print-modal-overlay">
        <div class="print-modal-content">
            <div class="print-modal-header">
                <span><i class="fa-solid fa-triangle-exclamation"></i> Preview</span>
                <button class="close-print-modal" onclick="closePrintPreview()">&times;</button>
            </div>
            <div class="print-modal-body">
                <!-- PDF Preview Area -->
            </div>
            <div class="print-modal-footer">
                <button type="button" class="btn-print-confirm">Cetak PDF <i class="fa-solid fa-file"></i></button>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        }

        function openPrintPreview() {
            const modalBody = document.querySelector('.print-modal-body');
            
            // 1. Mengambil baris data dari tabel Barang Keluar
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            let rowsHtml = '';

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if(cells.length > 1) {
                    rowsHtml += `
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[0].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: left;">${cells[1].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[2].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[3].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[4].innerText}</td>
                        </tr>
                    `;
                } else {
                    rowsHtml += `<tr><td colspan="5" style="padding: 20px; text-align:center; border: 1px solid #dddddd;">Data Barang Keluar Kosong</td></tr>`;
                }
            });

            // 2. Memetakan struktur CSS cetak ke dalam preview area
            modalBody.innerHTML = `
                <div style="padding: 30px; font-family: 'Segoe UI', Arial, sans-serif; color: #333333; background: #ffffff;" id="printableArea">
                    <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px double #333333; padding-bottom: 15px;">
                        <h2 style="margin: 0; text-transform: uppercase; font-size: 22px; letter-spacing: 1px;">Laporan Transaksi Barang Keluar</h2>
                        <p style="margin: 5px 0 0 0; color: #555555; font-size: 14px; font-weight: bold;">JVS Group Inventory Management System</p>
                        <small style="color: #777777; font-size: 12px;">Dicetak pada: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</small>
                    </div>
                    
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
                        <thead>
                            <tr style="background-color: #2c3e50; color: #ffffff;">
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 8%; text-align: center; font-weight: 600;">NO</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 37%; text-align: left; font-weight: 600;">NAMA BARANG</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 20%; text-align: center; font-weight: 600;">ID BARANG</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 20%; text-align: center; font-weight: 600;">TANGGAL OUT</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 15%; text-align: center; font-weight: 600;">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rowsHtml}
                        </tbody>
                    </table>

                    <div style="margin-top: 50px; display: flex; justify-content: flex-end; font-size: 14px;">
                        <div style="text-align: center; width: 200px;">
                            <p style="margin-bottom: 60px;">Kepala Gudang,</p>
                            <p style="font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 5px;">
                                ${document.querySelector('.user-menu span') ? document.querySelector('.user-menu span').innerText.trim() : 'Admin'}
                            </p>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('printPreviewModal').style.display = 'flex';
        }

        function closePrintPreview() {
            document.getElementById('printPreviewModal').style.display = 'none';
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            const printBtns = document.querySelectorAll('.btn-print, .btn-pdf');
            printBtns.forEach(btn => {
                btn.addEventListener('click', openPrintPreview);
            });

            const confirmPrintBtn = document.querySelector('.btn-print-confirm');
            if(confirmPrintBtn) {
                confirmPrintBtn.addEventListener('click', () => {
                    const printContent = document.getElementById('printableArea').innerHTML;
                    const originalContent = document.body.innerHTML;

                    // Mengisolasi layar cetak dari DOM utama
                    document.body.innerHTML = printContent;
                    window.print();
                    
                    // Mengembalikan keadaan DOM asal
                    document.body.innerHTML = originalContent;
                    window.location.reload();
                });
            }
        });
    </script>
</body>
</html>
