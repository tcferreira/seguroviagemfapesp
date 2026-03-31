<?php if (count($parent->children) > 0) { ?>
    <br/>
    <br/>
    <h4><?php echo $parent->name; ?></h4>

    <div class="widget-body">
        <div class="row" style="background-color: rgba(0, 0, 0, .15));">
            <?php echo $modules; ?>
        </div>
    </div>
<?php } else echo $modules; ?>