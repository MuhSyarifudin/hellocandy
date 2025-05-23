<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href=/admin/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href=/admin/assets/img/favicon.png">
    <title>
        Candy Craft | Login Page
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href=/admin/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href=/admin/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href=/admin/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <style>
    .input-group-outline input:focus+label,
    .input-group-outline input:not(:placeholder-shown)+label {
        top: -10px;
        left: 10px;
        font-size: 12px;
        color: #5e72e4;
    }

    .input-group-outline {
        position: relative;
        margin: 1rem 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
    }

    .input-group-outline input {
        border: none;
        outline: none;
        width: 100%;
    }

    .input-group-outline label {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        transition: 0.2s ease;
        color: #999;
    }

    .input-group-outline input:focus {
        border-color: #5e72e4;
    }

    #toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }
    </style>
</head>

<body class="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <!-- Navbar -->
                <nav
                    class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                    <div class="container-fluid ps-2 pe-0">
                        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="#">
                            <img src="/admin/assets/img/CANDY.png" alt="Logo" class="img-fluid"
                                style="max-width: 120px; height: auto;">
                        </a>
                        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon mt-2">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navigation">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2"
                                        href="https://www.instagram.com/your_instagram_account" target="_blank">
                                        <i class="fab fa-instagram opacity-6 text-dark me-1"></i>
                                        Instagram
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2"
                                        href="https://www.tiktok.com/@your_tiktok_account" target="_blank">
                                        <i class="fab fa-tiktok opacity-6 text-dark me-1"></i>
                                        TikTok
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2"
                                        href="https://www.facebook.com/your_facebook_account" target="_blank">
                                        <i class="fab fa-facebook opacity-6 text-dark me-1"></i>
                                        Facebook
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center me-2"
                                        href="https://twitter.com/your_twitter_account" target="_blank">
                                        <i class="fab fa-twitter opacity-6 text-dark me-1"></i>
                                        Twitter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if($errors->any())
                                <div
                                    class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 text-white text-center">
                                    {{ $errors->first('login_error') }}
                                </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="input-group-outline">
                                        <input type="text" class="form-control" id="username" name="username" required
                                            placeholder=" " />
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="input-group-outline position-relative">
                                        <input type="password" class="form-control" id="password" name="password"
                                            required placeholder=" ">
                                        <label for="password">Password</label>
                                        <i id="toggle-password" class="fa fa-eye position-absolute"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign
                                            In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer position-absolute bottom-2 py-2 w-100">
                <div class="container">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-12 col-md-12 my-auto">
                            <div class="copyright text-center text-sm text-white text-lg-start">
                                © <script>
                                document.write(new Date().getFullYear())
                                </script>,
                                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold text-white"
                                    target="_blank">Aish</a>
                                for present
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src=/admin/assets/js/core/popper.min.js"></script>
    <script src=/admin/assets/js/core/bootstrap.min.js"></script>
    <script src=/admin/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src=/admin/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    </script>
    <script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
    });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src=/admin/assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>


</html>