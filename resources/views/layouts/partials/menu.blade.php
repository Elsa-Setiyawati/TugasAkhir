<nav class="sidebar-nav">
    <ul id="sidebarnav"> 
    @if (auth::user()->role_id == 1)
    <b><li class="nav-small-cap">MASTER</li></b>
        <li> <a class="has-arrow waves-effect waves-dark" href="/home" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">MASTER</span></a>
            <ul aria-expanded="false" class="collapse">
            <li> <a class="waves-effect waves-dark" href="/home" aria-expanded="false">
            <!-- <i class="mdi mdi-gauge"></i> -->
            <span class="hide-menu">Dashboard </span></a> </li>
            <li> <a class="waves-effect waves-dark" href="/kategori" aria-expanded="false">
            <!-- <i class="mdi mdi-apps"></i> -->
            <span class="hide-menu">Kategori </span></a> </li>
            <li> <a class="waves-effect waves-dark" href="/barang" aria-expanded="false">
            <!-- <i class="mdi mdi-library-books"></i> -->
            <span class="hide-menu">Barang </span></a> </li>
            <li> <a class="waves-effect waves-dark" href="/pemasok" aria-expanded="false">
            <!-- <i class="mdi  mdi-folder-account"></i> -->
            <span class="hide-menu">Pemasok </span></a> </li>
            <li> <a class="waves-effect waves-dark" href="/users" aria-expanded="false">
            <!-- <i class="mdi mdi-account-card-details"></i> -->
            <span class="hide-menu">User </span></a> </li>
            </ul>
            <b><li class="nav-small-cap">TRANSAKSI</li></b>
            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cart-outline"></i><span class="hide-menu">TRANSAKSI</span></a> 
            <li> <a class="waves-effect waves-dark" href="/pembelian" aria-expanded="false">
            <!-- <i class="mdi mdi-gauge"></i> -->
            <span class="hide-menu">Pembelian </span></a> </li>

            <b><li class="nav-small-cap">LAPORAN</li></b>
            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">LAPORAN</span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="/lap_pembelian_periode">Laporan Pembelian</a></li>
                <li><a href="/lap_retur_pembelian_periode">Laporan Retur Pembelian</a></li>
                <li><a href="/lap_penjualan_periode">Laporan Penjualan</a></li>
                <li><a href="/lap_retur_penjualan_periode">Laporan Retur Penjualan</a></li>
                <li><a href="/lap_kartu_gudang">Kartu Gudang </a></li>
                <li><a href="/lap_kartu_persediaan">Kartu Persediaan</a></li>

                @elseif (auth::user()->role_id == 2)
                <b> <li class="nav-small-cap">MASTER</li></b>
                    <li> <a class="has-arrow waves-effect waves-dark" href="/home" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">MASTER</span></a>
                    <ul aria-expanded="false" class="collapse">
                    <li> <a class="waves-effect waves-dark" href="/home" aria-expanded="false">
                    <!-- <i class="mdi mdi-gauge"></i> -->
                    <span class="hide-menu">Dashboard </span></a> </li>
                    <li> <a class="waves-effect waves-dark" href="/kategori" aria-expanded="false">
                    <!-- <i class="mdi mdi-apps"></i> -->
                    <span class="hide-menu">Kategori </span></a> </li>
                    <li> <a class="waves-effect waves-dark" href="/barang" aria-expanded="false">
                    <!-- <i class="mdi mdi-library-books"></i> -->
                    <span class="hide-menu">Barang </span></a> </li>
                    <li> <a class="waves-effect waves-dark" href="/pelanggan" aria-expanded="false">
                    <!-- <i class="mdi  mdi-folder-account"></i> -->
                    <span class="hide-menu">Pelanggan </span></a> </li>
                    <li> <a class="waves-effect waves-dark" href="/users" aria-expanded="false">
                    <!-- <i class="mdi mdi-account-circle"></i> -->
                    <span class="hide-menu">User </span></a> </li>
                    
                </ul>
                    <b><li class="nav-small-cap">TRANSAKSI</li></b>
                    <li> <a class="waves-effect waves-dark" href="/penjualan" aria-expanded="false">
                    <!-- <i class="mdi mdi-gauge"></i> -->
                    <span class="hide-menu">Penjualan </span></a> </li>

                    <b><li class="nav-small-cap">LAPORAN</li></b>
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">LAPORAN</span></a>
                    <ul aria-expanded="false" class="collapse">
                    <li><a href="/lap_pembelian_periode">Laporan Pembelian</a></li>
                    <li><a href="/lap_retur_pembelian_periode">Laporan Retur Pembelian</a></li>
                    <li><a href="/lap_penjualan_periode">Laporan Penjualan</a></li>
                    <li><a href="/lap_retur_penjualan_periode">Laporan Retur Penjualan</a></li>
                    <li><a href="/lap_kartu_gudang">Kartu Gudang </a></li>
                    <li><a href="/lap_kartu_persediaan">Kartu Persediaan</a></li>

                @elseif (auth::user()->role_id == 3)
                <b> <li class="nav-small-cap">MASTER</li></b>
                <li> <a class="has-arrow waves-effect waves-dark" href="/home" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">MASTER</span></a>
                <ul aria-expanded="false" class="collapse">
                <li> <a class="waves-effect waves-dark" href="/home" aria-expanded="false">
                <!-- <i class="mdi mdi-gauge"></i> -->
                <span class="hide-menu">Dashboard </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/kategori" aria-expanded="false">
                <!-- <i class="mdi mdi-apps"></i> -->
                <span class="hide-menu">Kategori </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/barang" aria-expanded="false">
                <!-- <i class="mdi mdi-library-books"></i> -->
                <span class="hide-menu">Barang </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/pemasok" aria-expanded="false">
                <!-- <i class="mdi  mdi-folder-account"></i> -->
                <span class="hide-menu">Pemasok </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/pelanggan" aria-expanded="false">
                <!-- <i class="mdi mdi-account-card-details"></i> -->
                <span class="hide-menu">Pelanggan </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/users" aria-expanded="false">
                <!-- <i class="mdi mdi-account-circle"></i> -->
                <span class="hide-menu">User </span></a> </li>
                </ul>
                <b><li class="nav-small-cap">TRANSAKSI</li></b>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cart-outline"></i><span class="hide-menu">TRANSAKSI</span></a> 
                <ul aria-expanded="false" class="collapse">
                <li> <a class="waves-effect waves-dark" href="/pembelian" aria-expanded="false">
                <!-- <i class="mdi mdi-gauge"></i> -->
                <span class="hide-menu">Pembelian </span></a> </li>
                <li> <a class="waves-effect waves-dark" href="/penjualan" aria-expanded="false">
                <!-- <i class="mdi mdi-gauge"></i> -->
                <span class="hide-menu">Penjualan </span></a> </li>
                </ul>
                   <b><li class="nav-small-cap">LAPORAN</li></b>
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">LAPORAN</span></a>
                    <ul aria-expanded="false" class="collapse">
                    <li><a href="/lap_pembelian_periode">Laporan Pembelian</a></li>
                    <li><a href="/lap_retur_pembelian_periode">Laporan Retur Pembelian</a></li>
                    <li><a href="/lap_penjualan_periode">Laporan Penjualan</a></li>
                    <li><a href="/lap_retur_penjualan_periode">Laporan Retur Penjualan</a></li>
                    <li><a href="/lap_kartu_gudang">Kartu Gudang </a></li>
                    <li><a href="/lap_kartu_persediaan">Kartu Persediaan</a></li>
                    </ul>
                    @elseif (auth::user()->role_id == '')
                    <b> <li class="nav-small-cap">MASTER</li></b>
                    <li> <a class="has-arrow waves-effect waves-dark" href="/home" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">MASTER</span></a>
                    <ul aria-expanded="false" class="collapse">
                    <li> <a class="waves-effect waves-dark" href="/users" aria-expanded="false">
                <!-- <i class="mdi mdi-account-circle"></i> -->
                <span class="hide-menu">User </span></a> </li>
                @endif
        </li>
    </ul>
</nav>