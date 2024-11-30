<?php
session_start();

if (isset($_SESSION['user'])) {
    // header("location:pages/login/login.html");
    header("location:/tataTertib");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="assets/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>SiTatib | Sistem Tata Tertib </title>


	<link href="assets/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" 
	rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800;900&display=swap" rel="stylesheet">



	<script src="assets/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background-color: #000; /* Fallback jika gambar tidak dimuat */
			background-image: url('assets/img/bg-login.png');
			background-size: cover; /* Memastikan gambar mencakup seluruh area */
			background-repeat: no-repeat; /* Tidak mengulangi gambar */
			background-position: center; /* Pusatkan gambar */
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card bg-light">
							<div class="card-body">
								<div class="d-flex justify-content-center align-items-center mb">

									<img src="assets/img/logoPolinema.png" alt="logo" width="100" class="" style="position: absolute; top: -55px; left: ">
								</div>
								<div class=" text-center" style="margin-top: 50px;">
									<p class="fw-bold text-dark mt-5 mb-3" style="font-size: 44px;font-weight: 800;">SiTatib</p>
								</div>
								<div class="m-sm-3">
									<form id="form-login" onsubmit="return onLogin(event)">
										
										<div class="input-group mb-3 mt-5">
											<span class="input-group-text" id="basic-addon1"><i data-feather="user"></i></span>
											<input type="text" class="form-control" name="username"  placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
										</div>

										<div class="input-group mb-5">
											<span class="input-group-text" id="basic-addon1"><i data-feather="lock"></i></span>
											<input type="password" class="form-control" name="password"  placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
										</div>


										<!-- <div class="mb-3">
											<input class="form-control form-control-lg" type="text" name="username" placeholder="Enter your username" required/>
										</div>
										<div class="mb-5">
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" required/>
										</div> -->
										<div class="d-grid gap-2 mt-3">
											<button type="submit" onclick="onLogin()" id="btn-login" class="btn btn-lg text-white" style="background: rgb(17,87,190);
background: linear-gradient(146deg, rgba(17,87,190,1) 0%, rgba(22,30,61,1) 35%, rgba(22,31,64,1) 62%, rgba(17,87,190,1) 100%);

">LOGIN</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</main>

    <?php include 'pages/login/login.php'; ?>
    
	<script src="assets/js/app.js"></script>
	<script>

		<?php include 'helper/helper.js';?>
	</script>
</body>

</html>