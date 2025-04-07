
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Hospital EMR Test</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?= base_url() ?>assets/appui/img/favicon.png">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?= base_url() ?>assets/appui/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/appui/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/appui/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/appui/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/appui/css/themes.css">
        <!-- END Stylesheets -->
        <style>
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
                display: none; /* Hidden by default */
                z-index: 9999; /* Make sure it appears above other elements */
            }

            .loader {
                border: 4px solid #f3f3f3; /* Light grey border for the spinner */
                border-top: 4px solid #3498db; /* Blue border for the spinner */
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -25px; /* Center the spinner vertically */
                margin-left: -25px; /* Center the spinner horizontally */
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .thead-sm {
                font-size: 14px;
            }

        </style>
        <script src="<?= base_url() ?>assets/appui/js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
       
                       