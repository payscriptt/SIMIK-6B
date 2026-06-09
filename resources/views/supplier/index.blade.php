<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Supplier - SIMIK</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/supplier_dashboard.css') }}">
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
                    <li class="active"><i class="fa-solid fa-users"></i> Data Supplier</li>
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
            <div class="dashboard-header">
                <div class="hero-banner">
                    <div class="hero-icon">
                        <i class="fa-solid fa-cart-flatbed"></i>
                    </div>
                    <div class="hero-text">
                        <h1>Supplier</h1>
                        <p>Lihat dan mengelola data supplier</p>
                    </div>
                </div>

                <div class="actions-right">
                    <a href="{{ url('/supplier/create') }}" style="text-decoration:none;">
                        <button class="btn-add">Tambah Supplier <i class="fa-solid fa-plus"></i></button>
                    </a>
                    <button class="btn-print">Cetak PDF <i class="fa-solid fa-file"></i></button>
                    
                    <div class="search-box">
                        <input type="text" id="tableSearch" class="search-input" placeholder="Search...">
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="25%">NAMA SUPPLIER</th>
                            <th width="20%">NO TELEPON</th>
                            <th width="30%">ALAMAT</th>
                            <th width="12%">ID SUPPLIER</th>
                            <th width="8%"></th> </tr>
                    </thead>
                    @if(session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <tbody>
                        @forelse($suppliers ?? [] as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $s->nama_supplier }}</td>
                            <td>{{ $s->no_tlp }}</td>
                            <td>{{ $s->alamat }}</td>
                            <td>{{ $s->id_supplier }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ url('/supplier/' . $s->id_supplier) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Yakin hapus supplier {{ $s->nama_supplier }}?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="noDataRow">
                            <td colspan="6" style="text-align:center;">Data Supplier Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="printPreviewModal" class="print-modal-overlay">
        <div class="print-modal-content">
            <div class="print-modal-header">
                <span><i class="fa-solid fa-triangle-exclamation"></i> Preview</span>
                <button class="close-print-modal" onclick="closePrintPreview()">&times;</button>
            </div>
            <div class="print-modal-body">
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
            
            // 1. Mengambil baris data dari tabel utama (Hanya yang lolos filter / sedang tampil)
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            let rowsHtml = '';
            let visibleCounter = 1;

            tableRows.forEach(row => {
                if(row.style.display === 'none' || row.id === 'noDataRow' || row.classList.contains('no-match-row')) return;

                const cells = row.querySelectorAll('td');
                if(cells.length > 1) {
                    rowsHtml += `
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${visibleCounter++}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: left;">${cells[1].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[2].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: left;">${cells[3].innerText}</td>
                            <td style="padding: 12px 10px; border: 1px solid #dddddd; text-align: center;">${cells[4].innerText}</td>
                        </tr>
                    `;
                }
            });

            if(rowsHtml === '') {
                rowsHtml = `<tr><td colspan="5" style="padding: 20px; text-align:center; border: 1px solid #dddddd;">Data Supplier Tidak Ditemukan</td></tr>`;
            }

            // 2. Menyusun dokumen cetak resmi dengan CSS Table yang rapat & kokoh
            modalBody.innerHTML = `
                <div style="padding: 30px; font-family: 'Segoe UI', Arial, sans-serif; color: #333333; background: #ffffff;" id="printableArea">
                    <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px double #333333; padding-bottom: 15px;">
                        <h2 style="margin: 0; text-transform: uppercase; font-size: 22px; letter-spacing: 1px;">Laporan Data Mitra Supplier</h2>
                        <p style="margin: 5px 0 0 0; color: #555555; font-size: 14px; font-weight: bold;">JVS Group Inventory Management System</p>
                        <small style="color: #777777; font-size: 12px;">Dicetak pada: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</small>
                    </div>
                    
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px;">
                        <thead>
                            <tr style="background-color: #2c3e50; color: #ffffff;">
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 6%; text-align: center; font-weight: 600;">NO</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 28%; text-align: left; font-weight: 600;">NAMA SUPPLIER</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 18%; text-align: center; font-weight: 600;">NO TELEPON</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 33%; text-align: left; font-weight: 600;">ALAMAT MALANG</th>
                                <th style="border: 1px solid #2c3e50; padding: 12px 10px; width: 15%; text-align: center; font-weight: 600;">ID SUPPLIER</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rowsHtml}
                        </tbody>
                    </table>

                    <div style="margin-top: 50px; display: flex; justify-content: flex-end; font-size: 14px;">
                        <div style="text-align: center; width: 200px;">
                            <p style="margin-bottom: 60px;">Purchasing Manager,</p>
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
            // --- LOGIKA REAL-TIME SEARCH BOX SUPPLIER ---
            const searchInput = document.getElementById('tableSearch');
            const tableBody = document.querySelector('.data-table tbody');
            
            if(searchInput && tableBody) {
                searchInput.addEventListener('keyup', function() {
                    const filterValue = this.value.toLowerCase().trim();
                    const rows = tableBody.querySelectorAll('tr:not(#noDataRow):not(.no-match-row)');
                    let hasVisibleRow = false;

                    // Hapus pesan lama jika ada
                    const existingAlert = tableBody.querySelector('.no-match-row');
                    if(existingAlert) existingAlert.remove();

                    rows.forEach(row => {
                        const namaSupplier = row.cells[1] ? row.cells[1].innerText.toLowerCase() : '';
                        const noTlp        = row.cells[2] ? row.cells[2].innerText.toLowerCase() : '';
                        const alamat       = row.cells[3] ? row.cells[3].innerText.toLowerCase() : '';
                        const idSupplier   = row.cells[4] ? row.cells[4].innerText.toLowerCase() : '';

                        // Periksa kecocokan data kata kunci
                        if (namaSupplier.includes(filterValue) || noTlp.includes(filterValue) || alamat.includes(filterValue) || idSupplier.includes(filterValue)) {
                            row.style.display = '';
                            hasVisibleRow = true;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Jika tidak ditemukan mitra supplier yang cocok
                    if (!hasVisibleRow && rows.length > 0) {
                        const alertRow = document.createElement('tr');
                        alertRow.className = 'no-match-row';
                        alertRow.innerHTML = `<td colspan="6" style="text-align:center; color:#e74c3c; padding: 15px;">Data supplier "${this.value}" tidak ditemukan</td>`;
                        tableBody.appendChild(alertRow);
                    }
                });
            }
            // --------------------------------------------

            const printBtns = document.querySelectorAll('.btn-print, .btn-pdf');
            printBtns.forEach(btn => {
                btn.addEventListener('click', openPrintPreview);
            });

            const confirmPrintBtn = document.querySelector('.btn-print-confirm');
            if(confirmPrintBtn) {
                confirmPrintBtn.addEventListener('click', () => {
                    const printContent = document.getElementById('printableArea').innerHTML;
                    const originalContent = document.body.innerHTML;

                    document.body.innerHTML = printContent;
                    window.print();
                    
                    document.body.innerHTML = originalContent;
                    window.location.reload();
                });
            }
        });
    </script>
</body>
</html>