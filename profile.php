<?php
    session_start();
    $user = $_SESSION['user'];
    $id = $user['id'];
    $role = $user['role'];
    $idUserByRole = $user['id_userByRole'];

    if($role == 2) {
        include 'pages/profile/staff.php';
    }else if($role == 3) {
        include 'pages/profile/dosen.php';
    }else if($role == 4) {
        include 'pages/profile/mahasiswa.php';
    }

?>

<script>
    $(() => {
        if('<?= $role?>' == 1) {
            $('.profile-btn').addClass('d-none');
        }else {
            $('.profile-btn').removeClass('d-none');
        }
    });

    onProfile = () => {
        pOnEdit('<?= $idUserByRole?>');
    }
</script>