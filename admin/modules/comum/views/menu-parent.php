<?php
//Busca se tem um filho com a classe active
$isActivated = strstr($children, 'class="active"') ? true : false;

$slug_parent = "";
if($children){
    $slug_parent = slug($module->name) . "Menu";
}
// echo '<pre>';die(var_dump());
?>

<li class="<?php echo ($isActivated) ? 'mm-active' : ''; ?>">

    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="<?php echo ($isActivated) ? 'true' : 'false'; ?>">
        <i class="<?php echo $module->icon; ?>"></i>
        <span class="nav-text"><?php echo $module->name ;?></span>
    </a>

    <?php if (isset($children) && !empty($children)) { ?>
        <ul aria-expanded="<?php echo ($isActivated) ? 'true' : 'false'; ?>">
            <?php echo $children; ?>
        </ul>
    <?php } ?>
</li>