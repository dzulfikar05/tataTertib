<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative ">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator notif_count" >0</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                    <span class=" notif_count" >0</span>
                     Notifikasi Baru
                    </div>
                    <div class="list-group list-notification">
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                
                                <div class="col-12">
                                    <div class="text-dark">Update completed</div>
                                    <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                                    <div class="text-muted small mt-1">30m ago</div>
                                </div>
                            </div>
                        </a>
                        
                    </div>
                    
                </div>
            </li>
             
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                <?php
                    $ppUser = $_SESSION['user']['photo']['path'] ? "/tataTertib/". $_SESSION['user']['photo']['path'] : "/tataTertib/assets/img/userNoImage.jpg";
                    $username = $_SESSION['user']['username'] ?? '-';
                ?>
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="<?= $ppUser?>" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?= $username?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item profile-btn" onclick="onProfile()" href="#"><i class="align-middle me-1 " data-feather="user"></i> Profil</a>
                    <div class="dropdown-divider profile-btn"></div>
                    <a class="dropdown-item" href="#" onclick="logout()"><i class="align-middle me-1" data-feather="log-out"></i>Keluar</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php 
    include 'profile.php';
?>
