<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="/src/assets/img/favicon.ico" />
    <link href="/layouts/modern-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="/layouts/modern-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="/layouts/modern-light-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="/layouts/modern-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/src/assets/css/light/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />

    <link href="/layouts/modern-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/src/assets/css/dark/authentication/auth-boxed.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">

    <link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/plugins/css/light/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />

    <link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/plugins/css/dark/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <form onsubmit="login(); return false;">
        <div class="auth-container d-flex">

            <div class="container mx-auto align-self-center">

                <div class="row">

                    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                        <div class="card mt-3 mb-3">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 mb-3">

                                        <h2>Login</h2>
                                        <p>Masukkan username dan password untuk login</p>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" id="username" name="username" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-secondary w-100">Login</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/src/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script>
        const login = () => {
            let data = {
                user: $('#username').val(),
                pass: $('#password').val(),
            }

            $.ajax({
                type: "POST",
                url: '<?= base_url() ?>api/auth/login',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res?.messages?.success || "Berhasil Login, Anda akan segera dialihkan",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        window.location.href = "<?= base_url() ?>";

                    }, 1500);
                },
                error: function(err) {
                    $('#password').val('')
                    $('#username').val('').focus()

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err?.responseJSON?.messages?.error || 'Username tidak ditemukan!',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    console.log(err);
                }
            });

        }
    </script>


</body>

</html>