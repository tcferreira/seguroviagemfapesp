<?php
$now_slug = implode('/', $this->uri->segment_array());
?>

<?php if (!empty($module->is_title)) { ?>
    <li class="nav-label first"><?php echo $module->name; ?></li>
<?php } else { ?>
    <li class="<?php echo (strstr($now_slug, $module->slug)) ? 'mm-active' : ''; ?>">
        <?php $validhttp = !preg_match("~^(?:f|ht)tps?://~i", $module->slug); ?>
        <a class="ai-icon has-tooltip" data-placement="right" title="<?php echo $module->name; ?>" target="<?php echo $validhttp ? '' : '_blank' ?>" href="<?php echo $validhttp ? site_url($module->slug) : $module->slug; ?>" aria-expanded="false">
            <?php if (empty($module->parent_id)) { ?>
                <i class="<?php echo $module->icon; ?>"></i>
                <span class="nav-text"><?php echo $module->name; ?></span>
            <?php } else { ?>
                <?php echo $module->name; ?>
            <?php } ?>
        </a>
    </li>
<?php } ?>