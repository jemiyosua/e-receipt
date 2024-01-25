<?php

session_start();

include('headerLogin.php');

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
                            <h4 class="card-title">Register</h4>
                            <div class="alert alert-info" role="alert">
                                Please register your account using your <b>EMAIL</b>
                                <hr>
                                Using your <b>EMAIL</b> for login to this system
                            </div>
                            <form method="POST" action="prosesRegister.php" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required autofocus>
                                    <div class="invalid-feedback">
                                        Username is required
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Create Your Password
                                    </label>
                                    <input id="password" type="password" class="form-control" name="password" required data-eye>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Your Password
                                    </label>
                                    <input id="password2" type="password" class="form-control" name="password2" required data-eye>
                                    <div class="invalid-feedback">
                                        Password is required
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block" name="register">
                                        Register
                                    </button>
                                </div>
                            </form>

                            <div style="padding-top: 30px;">Already Have an Account? <a href="index.php" style="text-decoration: none;">Login</a></div>

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

				<form class="login100-form validate-form" method="POST" action="prosesRegister.php">
					<span class="login100-form-title">
						E - Receipt | Register
					</span>

					<?php
					if (isset($_SESSION['pesanError'])) {
						// echo "<div class='alert alert-danger' role='alert' style='border-radius:10px;'><b>" . $_SESSION['pesanError'] . "</b></div>";
                        echo "<script>
                        Swal.fire({
                            allowEnterKey: false,
                            allowOutsideClick: false,
                            icon: 'error',
                            title: 'Sorry :(',
                            text: '".$_SESSION['pesanError']."'
                        }).then(function() {
                            window.location.href='register.php';
                        });
                        </script>";
						unset($_SESSION['pesanError']);
					}
					?>
                    
                    <div class="alert alert-info" role="alert">
                        Please register your account using your <b>EMAIL</b>
                    </div>

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

                    <div class="wrap-input100 validate-input" data-validate = "Password is Required">
						<input class="input100" type="password" name="password2" placeholder="Confirm Your Password" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" name="register" class="login100-form-btn">
							Register
						</button>
					</div>

                    <div align="center" style="padding-top: 20px;">Already Have an Account? <a href="index.php" style="text-decoration: none;">Login</a></div>

					<div class="text-center p-t-136"></div>

				</form>
			</div>
		</div>
	</div>

    <?php

    include('footerLogin.php');

    ?>