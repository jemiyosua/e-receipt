<?php

session_start();

$tahunIni = date('Y');

if (isset($_SESSION['email']) && (isset($_SESSION['password']))) {

    header('location:index_.php');
}

?>

<!-- <body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div style="padding-top: 80px;" align="center">
                        <img src="img/bill.png" alt="logo" style="width: 80px;">
                    </div>

                    <div style="padding-top: 10px;"></div>

                    <h4 style="text-align: center;">E - Receipt</h4>

                    <div style="padding-bottom: 10px;"></div>

                    

                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Login</h4>
                            <form method="POST" action="prosesLogin.php" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                                    <div class="invalid-feedback">
                                        Email is required
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required data-eye>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block" name="login">
                                        Login
                                    </button>
                                </div>
                            </form>

                            <div style="padding-top: 30px;">Don't Have an Account? <a href="register.php" style="text-decoration: none;">Register</a></div>

                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; <?= $tahunIni ?> &mdash; E - Receipt by Psycodepath
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="img/bill.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="POST" action="prosesLogin.php">
					<span class="login100-form-title">
						E - Receipt
					</span>

					<?php

                    if (isset($_SESSION['pesan'])) {
                        // echo "<div class='alert alert-success' role='alert' style='border-radius:10px;'>" . $_SESSION['pesan'] . "</div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'success',
                            title: 'Good Job :)',
                            text: '".$_SESSION['pesan']."'
                        }).then(function() {
                            window.location.href='updateProfile.php';
                        });
                        </script>";
                        unset($_SESSION['pesan']);
                    } else if (isset($_SESSION['pesanError'])) {
						// echo "<div class='alert alert-danger' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanError'] . "</b></div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'error',
                            title: 'Sorry :(',
                            text: '".$_SESSION['pesanError']."'
                        }).then(function() {
                            window.location.href='index.php';
                        });
                        </script>";
						unset($_SESSION['pesanError']);
					}
					?>

					<div class="wrap-input100 validate-input" data-validate = "Email is Required">
						<input class="input100" type="email" name="email" placeholder="Email" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is Required">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" name="login" class="login100-form-btn">
                        Login
						</button>
					</div>

                    <div align="center" style="padding-top:20px">Don't Have an Account? <a href="register.php" style="text-decoration: none;">Register</a></div>

					<div class="text-center p-t-136"></div>

				</form>
			</div>
		</div>
	</div>