<?php

session_start();

$tahunIni = date('Y');

if (isset($_SESSION['username']) && (isset($_SESSION['password']))) {

    header('location:dashboard');
}

?>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div style="padding-top: 80px;" align="center">
                        <img src="../../assets/img/logo.png" alt="logo" style="width: 80px;">
                    </div>
                    <div style="padding-top: 10px;"></div>
                    <h4 style="text-align: center;">SMK MUHHAMADIYAH 1 PURBALINGGA</h4>
                    <div style="padding-bottom: 10px;"></div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Login</h4>
                            <form method="POST" action="proses.php" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label for="email">Username</label>
                                    <input id="username" type="text" class="form-control" name="username" required autofocus>
                                    <div class="invalid-feedback">
                                        Username is required
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
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; <?= $tahunIni ?> &mdash; SMK MUHHAMADIYAH 1 PURBALINGGA
                    </div>
                </div>
            </div>
        </div>
    </section>