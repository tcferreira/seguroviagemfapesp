<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="theme-color" content="#FF7900" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <?php echo $metadata; ?>
    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>',
            base_img = '<?php echo base_img(); ?>',
            module_slug = '<?php echo $slug; ?>',
            environment = '<?php echo ENVIRONMENT; ?>',
            <?php echo isset($i18n) ? 'i18n = ' . $i18n . ',' : ''; ?>
        segments = ('<?php echo $this->uri->uri_string(); ?>').split('/'),
            current_lang = '<?php echo $lang; ?>',
            receitaws_key = '<?php echo RECEITAWS_KEY; ?>',
            gmaps_key = '<?php echo GMAPS_KEY; ?>',
            site_name = '<?php echo $csrf_input_name; ?>',
            csrf_test_name = '<?php echo $csrf_test_name; ?>',
            group_id = '<?php echo $this->auth->data('id_grupo'); ?>';
    </script>
    

    <link rel="icon" type="image/x-icon" href="<?php echo base_url(APPPATH . 'modules/comum/assets/img/favicon.ico'); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(APPPATH . 'modules/comum/assets/img/favicon.png'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <?php echo $head_styles, $head_scripts; ?>

    <style>
        :root {
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
        .nav-header { background: #FF7900; }
        .nav-header .brand-logo img { filter: brightness(0) invert(1); }
    </style>
</head>

<body data-theme-version="light">
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1" style="background:var(--primary);"></div>
            <div class="sk-child sk-bounce2" style="background:var(--primary);"></div>
            <div class="sk-child sk-bounce3" style="background:var(--primary);"></div>
        </div>
    </div>


    <div class="p-4">
        <?php echo $content; ?>
    </div>


    <div id="fast-loading" class="fade">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Carregando...</span>
        </div>
    </div>

    <script src="<?php echo base_url(APPPATH . "modules/comum/assets/plugins/jquery.min.js"); ?>"></script>
    <?php echo $body_scripts; ?>

    <?php if (isset($company->google_tag_manager) && $company->google_tag_manager != '') { ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $company->google_tag_manager; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '<?php echo $company->google_tag_manager; ?>');
        </script>
    <?php } ?>
</body>