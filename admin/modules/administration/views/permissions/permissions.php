
<div class="row">
    <div class="col-lg-12 nome-modulo">
        <input type="checkbox" id="<?php echo slug($module->name); ?>" class="all-checkbox">
        <label class="mb-0" for="<?php echo slug($module->name); ?>"><?php echo $module->name; ?></label>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
        if ($module->action){
            $actions = explode(',', $module->action);
            foreach ($actions as $key => $action){ ?>
                <div class="checkbox">
                        <?php
                        $walkIds = explode('[', $parentsName);
                        unset($walkIds[0]);
                        $searchIn = isset($existing_permissions) ? $existing_permissions : array();
                        foreach ($walkIds as $j => $walkId){
                            $walkId = str_replace(']', '', $walkId);
                            if (isset($searchIn[$walkId]))
                                $searchIn = $searchIn[$walkId];
                            else {
                                $searchIn = false;
                            }
                        }
                        $searchIn = ($searchIn && isset($searchIn[$module->id])) ? $searchIn[$module->id] : false;
                        $checked = '';
                        if (isset($existing_permissions) && $searchIn && in_array(slug($action), $searchIn))
                            $checked = ' checked';
                        ?>
                        <input <?php echo $checked; ?> type="checkbox" name="permissions<?php echo $parentsName; ?>[<?php echo $module->id; ?>][]" value="<?php echo slug($action); ?>" data-module="<?php echo slug($module->name); ?>" id="modulo-<?php echo $module->id . slug($action); ?>" class="fcode-checkbox">
                        <label for="modulo-<?php echo $module->id . slug($action); ?>"><?php echo $action; ?></label>
                </div>
            <?php
            }

        }

        ?>
    </div>
</div>
