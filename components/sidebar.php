<nav id="sidebar" class="sidebar js-sidebar" >
    <div class="sidebar-content js-simplebar" style="background: rgb(22,30,61) !important;
background: linear-gradient(146deg, rgba(22,30,61,1) 57%, rgba(32,61,111,1) 79%, rgba(17,87,190,1) 100%) !important;">
        <a class="sidebar-brand" href="index.php">
            <span class="align-middle"><?= $_SESSION['app']['name'] ?? 'SiTatib' ?> </span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'dashboard' ? 'active' : ''  ?>">
                <a class="sidebar-link" href="index.php" style="background-color: #161e3d !important;">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>



            <li class="sidebar-item 
                <?= $_SESSION['user']['role'] != 1 ? 'd-none' : ''  ?>

                <?= $_SESSION['menu_active'] == 'admin' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'mahasiswa' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'dosen' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'staff' ? 'active' : ''  ?>
            ">
                <a href="#pengguna_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed" style="background-color: #161e3d !important;">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pengguna</span>
                </a>
                <ul id="pengguna_sidebar" class="sidebar-dropdown list-unstyled 
                    collapse<?= $_SESSION['menu_active'] == 'mahasiswa' || $_SESSION['menu_active'] == 'dosen' || $_SESSION['menu_active'] == 'staff' || $_SESSION['menu_active'] == 'admin' ? 'd' : ''  ?> 
                    
                    " data-bs-parent="#sidebar">
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'dosen' ? 'active' : ''  ?> "><a class='sidebar-link' href='dosen.php'>Dosen</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'staff' ? 'active' : ''  ?>"><a class='sidebar-link' href='staff.php'>Staff</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'mahasiswa' ? 'active' : ''  ?>"><a class='sidebar-link' href='mahasiswa.php'>Mahasiswa</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'admin' ? 'active' : ''  ?>"><a class='sidebar-link' href='admin.php'>Admin</a></li>
                </ul>
            </li>

            <li class="sidebar-item 
                <?= $_SESSION['menu_active'] == 'kategori' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'aduan-pelanggaran' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'list-pelanggaran' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'sanksi-pelanggaran' ? 'active' : ''  ?>
            " >
                <a href="#pelanggaran_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed" style="background-color: #161e3d !important;">
                    <i class="align-middle" data-feather="alert-octagon"></i> <span class="align-middle">Pelanggaran</span>
                </a>
                <ul id="pelanggaran_sidebar" class="sidebar-dropdown list-unstyled 
                    collapse<?= $_SESSION['menu_active'] == 'kategori' || $_SESSION['menu_active'] == 'aduan-pelanggaran' || $_SESSION['menu_active'] == 'list-pelanggaran' || $_SESSION['menu_active'] == 'sanksi-pelanggaran' ? 'd' : ''  ?> 
                    " data-bs-parent="#sidebar">

                    
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'kategori' ? 'active' : ''  ?>  <?= $_SESSION['user']['role'] != 1 ? 'd-none' : ''  ?>"><a class='sidebar-link' href='kategori.php'>Kategori</a></li>

                    <li class="sidebar-item 
                    <?= $_SESSION['menu_active'] == 'aduan-pelanggaran' ? 'active' : ''  ?>
                    <?= $_SESSION['user']['role'] == 4? 'd-none' : ''  ?>
                    "><a class='sidebar-link' href='aduan-pelanggaran.php'>Aduan Pelanggaran</a></li>
                   
                    <li class="sidebar-item 
                    <?= $_SESSION['user']['role'] == 4? 'd-none' : ''  ?>
                    <?= $_SESSION['user']['role'] == 3? 'd-none' : ''  ?>
                    <?= $_SESSION['menu_active'] == 'list-pelanggaran' ? 'active' : ''  ?>
                    "><a class='sidebar-link' href='list-pelanggaran.php'>List Pelanggaran</a></li>
                    
                    <li class="sidebar-item 
                    <?= $_SESSION['menu_active'] == 'sanksi-pelanggaran' ? 'active' : ''  ?>
                    <?= $_SESSION['user']['role'] == 2 ? 'd-none' : ''  ?>
                    <?= $_SESSION['user']['role'] == 3 ? 'd-none' : ''  ?>
                    "><a class='sidebar-link' href='sanksi-pelanggaran.php'>Sanksi Pelanggaran</a></li>
                  
                </ul>
            </li>
            <li class="sidebar-item 
                <?= $_SESSION['user']['role'] == 4 ? 'd-none' : ''  ?>

                <?= $_SESSION['menu_active'] == 'laporan-aduan-pelanggaran' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'laporan-pelanggaran' ? 'active' : ''  ?>
            ">
                <a href="#laporan_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed" style="background-color: #161e3d !important;">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Riwayat</span>
                </a>
                <ul id="laporan_sidebar" class="sidebar-dropdown list-unstyled 
                    collapse<?= $_SESSION['menu_active'] == 'laporan-aduan-pelanggaran' || $_SESSION['menu_active'] == 'laporan-pelanggaran' ? 'd' : ''  ?> 
                    " data-bs-parent="#sidebar">

                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'laporan-aduan-pelanggaran' ? 'active' : ''  ?>"><a class='sidebar-link' href='laporan-aduan-pelanggaran.php'>Riwayat Aduan Pelanggaran</a></li>

                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'laporan-pelanggaran' ? 'active' : ''  ?>"><a class='sidebar-link' href='laporan-pelanggaran.php'>Riwayat Pelanggaran</a></li>
                  
                </ul>
            </li>


            <li class="sidebar-item 
                <?= $_SESSION['user']['role'] != 1 ? 'd-none' : ''  ?>


                <?= $_SESSION['menu_active'] == 'jurusan' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'prodi' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'kelas' ? 'active' : ''  ?>
            ">
                <a href="#master_data_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed" style="background-color: #161e3d !important;">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Master Data</span>
                </a>
                <ul id="master_data_sidebar" class="sidebar-dropdown list-unstyled 

                    collapse<?=  $_SESSION['menu_active'] == 'jurusan' || $_SESSION['menu_active'] == 'prodi' || $_SESSION['menu_active'] == 'kelas' ? 'd' : ''  ?> 
                    
                    " data-bs-parent="#sidebar">
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'jurusan' ? 'active' : ''  ?>"><a class='sidebar-link' href='jurusan.php'>Jurusan</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'prodi' ? 'active' : ''  ?>"><a class='sidebar-link' href='prodi.php'>Prodi</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'kelas' ? 'active' : ''  ?>"><a class='sidebar-link' href='kelas.php'>Kelas</a></li>
                </ul>
            </li>


    </div>
</nav>