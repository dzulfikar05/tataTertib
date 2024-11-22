<script>
	onLogin = () => {
		var form = $('#form-login').get(0);
			var formData = new FormData(form);
			formData.append('action', 'verify_login');
			$.ajax({
				url: '/tataTertib/system/auth.php',
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				success: (data) => {
					
					if (data) {
						setTimeout(() => {
							window.location.href = 'index.php';
						}, 1000); // 1000ms = 1 detik

					} else {
						Swal.fire({
							title: "Login Gagal!",
							text: "Username atau Password tidak sesuai",
							icon: "warning",
							confirmButtonColor: "#3B7DDD",
						});
					}
				},
				error: (jqXHR, textStatus, errorThrown) => {
					console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
				}
			});
	}

	logout = () => {
		$.ajax({
			url: '/tataTertib/system/auth.php',
			data: {
				action: 'logout'
			},
			type: 'POST',
			success: (data) => {
				if (data.trim() === 'logout_success') {
					window.location.href = 'index.php'; 
				} else {
					console.error('Logout failed: ' + data);
				}
			},
			error: (jqXHR, textStatus, errorThrown) => {
				console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
			}
		});
	}
</script>