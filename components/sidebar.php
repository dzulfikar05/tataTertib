<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle"><?= $_SESSION['app']['name'] ?? 'SiTatib' ?> </span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item <?= $_SESSION['menu_active'] == 'dashboard' ? 'active' : ''  ?>">
                <a class="sidebar-link" href="index.php">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>



            <li class="sidebar-item 
                <?= $_SESSION['menu_active'] == 'mahasiswa' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'dosen' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'staff' ? 'active' : ''  ?>
            ">
                <a href="#pengguna_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pengguna</span>
                </a>
                <ul id="pengguna_sidebar" class="sidebar-dropdown list-unstyled 
                    collapse<?= $_SESSION['menu_active'] == 'mahasiswa' || $_SESSION['menu_active'] == 'dosen' || $_SESSION['menu_active'] == 'staff' ? 'd' : ''  ?> 
                    
                    " data-bs-parent="#sidebar">
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'dosen' ? 'active' : ''  ?>"><a class='sidebar-link' href='dosen.php'>Dosen</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'staff' ? 'active' : ''  ?>"><a class='sidebar-link' href='staff.php'>Staff</a></li>
                    <li class="sidebar-item <?= $_SESSION['menu_active'] == 'mahasiswa' ? 'active' : ''  ?>"><a class='sidebar-link' href='mahasiswa.php'>Mahasiswa</a></li>
                </ul>
            </li>


            <li class="sidebar-item 
                <?= $_SESSION['menu_active'] == 'jurusan' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'prodi' ? 'active' : ''  ?>
                <?= $_SESSION['menu_active'] == 'kelas' ? 'active' : ''  ?>
            ">
                <a href="#master_data_sidebar" data-bs-toggle="collapse" class="sidebar-link collapsed">
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