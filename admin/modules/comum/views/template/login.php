<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="theme-color" content="#FF7900" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo !empty($title) ? $title : null; ?></title>

    <?php echo !empty($metadata) ? $metadata : null; ?>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>',
            module_slug = '',
            environment = '<?php echo ENVIRONMENT; ?>',
            base_img = '<?php echo base_img(); ?>',
            module = '<?php echo $slug; ?>',
            <?php echo isset($i18n) ? 'i18n = '.$i18n.',' : ''; ?>
            segments = ('<?php echo $this->uri->uri_string(); ?>').split('/'),
            site_name = '<?php echo $csrf_input_name; ?>',
            csrf_test_name = '<?php echo $csrf_test_name; ?>';
    </script>
    <script type="text/javascript" src="https://js.iugu.com/v2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formatter.js/0.1.5/formatter.min.js"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script> -->
    <link rel="shortcut icon"  type="image/x-icon" href="<?php echo base_url('modules/comum/assets/img/favicon.png'); ?>">

    <?php echo $head_styles, $head_scripts; ?>

    <style>
        :root, [data-primary="color_12"] {
            --primary: #FF7900 !important;
            --primary-hover: #e06d00 !important;
            --primary-light: #fff3e6 !important;
            --primary-dark: #b35500 !important;
            --rgba-primary-1: rgba(255, 121, 0, 0.1) !important;
            --rgba-primary-2: rgba(255, 121, 0, 0.2) !important;
            --rgba-primary-3: rgba(255, 121, 0, 0.3) !important;
            --rgba-primary-4: rgba(255, 121, 0, 0.4) !important;
            --rgba-primary-5: rgba(255, 121, 0, 0.5) !important;
            --rgba-primary-6: rgba(255, 121, 0, 0.6) !important;
            --rgba-primary-7: rgba(255, 121, 0, 0.7) !important;
            --rgba-primary-8: rgba(255, 121, 0, 0.8) !important;
            --rgba-primary-9: rgba(255, 121, 0, 0.9) !important;
        }
    </style>
</head>


<body class="vh-100">
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1" style="background:var(--primary);"></div>
            <div class="sk-child sk-bounce2" style="background:var(--primary);"></div>
            <div class="sk-child sk-bounce3" style="background:var(--primary);"></div>
        </div>
    </div>

    <!-- <div id="postLoad" style="display:none;"> -->
    <?php echo $content; ?>
    <!-- </div> -->

    <script src="<?php echo base_url(APPPATH."modules/comum/assets/plugins/jquery.min.js"); ?>"></script>
    <?php echo $body_scripts; ?>
</body>
</html>
