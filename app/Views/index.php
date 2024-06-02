<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SPP APP - <?= $page ?? 'Dashboard'; ?> </title>
    <link rel="icon" type="image/x-icon" href="/src/assets/img/favicon.ico" />
    <link href="/layouts/modern-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="/layouts/modern-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="/layouts/modern-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="/src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="/src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="/src/plugins/css/dark/table/datatable/dt-global_style.css">

    <link href="/layouts/modern-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/layouts/modern-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->


    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/src/plugins/src/animate/animate.css" rel="stylesheet" type="text/css" />

    <link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />

    <link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/src/plugins/src/sweetalerts2/sweetalerts2.css">

    <link href="/src/assets/css/light/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/plugins/css/light/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />

    <link href="/src/assets/css/dark/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="/src/plugins/css/dark/sweetalerts2/custom-sweetalert.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->

    <?= $this->renderSection('style'); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <?= $this->include('layout/header.php'); ?>
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?= $this->include('layout/sidebar.php'); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">
                    <?= $this->renderSection('content'); ?>
                </div>

            </div>

            <!--  BEGIN FOOTER  -->
            <?= $this->include('layout/footer.php') ?>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!--  BEGIN FOOTER  -->
    <?= $this->renderSection('modal'); ?>
    <!--  END FOOTER  -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="/src/plugins/src/waves/waves.min.js"></script>
    <script src="/layouts/modern-light-menu/app.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="/src/plugins/src/font-icons/feather/feather.min.js"></script>

    <script src="/src/plugins/src/sweetalerts2/sweetalerts2.min.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


    <script src="/src/plugins/src/table/datatable/datatables.js"></script>
    <script>
        feather.replace();
        let base_url = '<?= base_url(); ?>';
        let akses = '<?= base64_encode(json_encode((session()->get('user') ?? []) ? ['userNHK' => session()->get('user')] : [])) ?>'

        // Setup ajax for global request
        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + akses);
            }
        });

        const formatRupiah = (event) => {
            let angka = $(event).val();

            if (angka == '') return '';

            let split = (angka.toString().replaceAll(',', '')).split(".");
            let angka1 = split[0];
            let angka2 = split[1];

            let parsed = angka2 != undefined ?
                angka2 == "" ? parseInt(isNaN(angka1) ? 0 : angka1).toLocaleString() + "." : parseFloat(isNaN(angka1) ? 0 : angka1 + '.' + angka2).toLocaleString() :
                parseInt(isNaN(angka1) ? 0 : angka1).toLocaleString();

            $(event).val(parsed);
        };

        const formatNumber = (event) => {
            $(event).val($(event).val().replace(/[^\d]+/g, ''));
        }
    </script>
    <?= $this->renderSection('script'); ?>
</body>

</html>