<?php if (isset($breadcrumb_route) && $breadcrumb_route != false){ ?>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
                <?php echo (isset($current_module) && isset($current_module->parent)) ? $current_module->parent->name.'&nbsp;<i class="fa-regular fa-angle-right"></i>&nbsp;': ''; ?>

                <?php
                $hasPrevious = false;
                foreach ($breadcrumb_route as $key => $value) {
                    if ($hasPrevious)
                        echo "&nbsp;<i class='fa-regular fa-angle-right'></i>&nbsp;";
                    echo $value;
                    $hasPrevious = true;
                } ?>
            </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <?php
                foreach ($breadcrumb_route as $key => $value){
                    if ($key){ ?>
                        <li class="breadcrumb-item"><a href="<?php echo site_url($key); ?>"><?php echo $value; ?></a></li>
                    <?php } else { ?>
                        <li class="breadcrumb-item active"><?php echo $value;?></li>
                    <?php }
                } ?>
            </ol>
        </div>
    </div>
<?php } ?>