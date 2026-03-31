<?php
if(!isset($tabname))
    $tabname = 'tablang';
?>

<nav>
    <div class="nav nav-tabs mb-3" id="nav-<?php echo $tabname; ?>" role="tablist">
        <?php foreach($languages as $key => $language){ ?>
            <a class="nav-item nav-link <?php echo ($key == 0) ? 'active' : ''; ?>" id="nav-home-tab" data-toggle="tab" href="#<?php echo $tabname.$key; ?>" role="tab" aria-controls="nav-home" aria-selected="<?php echo ($key == 0) ? 'true' : 'false'; ?>">
                <?php if (is_file(base_img($language->image))) { ?>
                    <i class="lang-flag">
                        <img src="<?php echo base_img($language->image);?>" alt="<?php echo $language->name; ?>">
                    </i>
                <?php } ?>

                <?php echo $language->name; ?>
            </a>
        <?php } ?>
    </div>
</nav>