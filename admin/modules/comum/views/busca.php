<div class="card">
    <div class="card-body">
        <!-- <?php if (!isset($hide_buttons) || (isset($hide_buttons) && !$hide_buttons)) { ?>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <?php if (isset($session_permissions) && is_array($session_permissions) && isset($session_permissions[$current_module->id]) && is_array($session_permissions[$current_module->id]) && in_array('cadastrar', $session_permissions[$current_module->id])){ ?>
                        <a class="btn btn-primary" href="<?php echo site_url($current_module->slug.'/cadastrar'); ?>" role="button" title="<?php echo T_('Insira um novo registro'); ?>">
                            <i class="fa-light fa-plus mr-2"></i> <?php echo T_('Cadastrar'); ?>
                        </a>
                    <?php } ?>

                    <?php if (isset($session_permissions) && is_array($session_permissions) && isset($session_permissions[$current_module->id]) && is_array($session_permissions[$current_module->id]) && in_array('exportar', $session_permissions[$current_module->id])){ ?>
                        <a class="btn btn-dark" href="<?php echo site_url($current_module->slug.'/exportar'); ?>" role="button" title="<?php echo T_('Exporte os registros'); ?>">
                            <i class="fa-light fa-file-export mr-2"></i> <?php echo T_('Exportar'); ?>
                        </a>
                    <?php } ?>

                    <?php if (isset($session_permissions) && is_array($session_permissions) && isset($session_permissions[$current_module->id]) && is_array($session_permissions[$current_module->id]) && in_array('importar', $session_permissions[$current_module->id])){ ?>
                        <a class="btn btn-dark" href="<?php echo site_url($current_module->slug.'/importar'); ?>" role="button" title="<?php echo T_('Importar'); ?>">
                            <i class="fa-light fa-file-import mr-2"></i> <?php echo T_('Importar'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?> -->


        <form action="<?php echo site_url($current_module->slug); ?>" class="filter" method="POST">
            <div class="form-row">
                <div class="col-sm-2">
                    <select id="filter-show" name="show" class="form-control" data-style="btn-primary" data-width="100%">
                        <option title="<?php echo T_('Visualizar: 10'); ?>" value="10"<?php echo ($show == 10) ? ' selected="selected"' : ''; ?>>10</option>
                        <option title="<?php echo T_('Visualizar: 25'); ?>" value="25"<?php echo ($show == 25) ? ' selected="selected"' : ''; ?>>25</option>
                        <option title="<?php echo T_('Visualizar: 50'); ?>" value="50"<?php echo ($show == 50) ? ' selected="selected"' : ''; ?>>50</option>
                        <option title="<?php echo T_('Visualizar: 100'); ?>" value="100"<?php echo ($show == 100) ? ' selected="selected"' : ''; ?>>100</option>
                    </select>
                </div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control" placeholder="<?php echo T_('Buscar por...'); ?>" value="<?php echo ($search) ? $search : ''; ?>" id="filter-search">

                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" title="<?php echo T_('Buscar'); ?>">
                                <i class="fa fa-search"></i>
                            </button>

                            <a class="btn btn-outline-secondary" href="<?php echo site_url('comum/limpar-busca'); ?>" title="<?php echo T_('Limpar Busca'); ?>">
                                <i class="fa fa-eraser"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <?php if (isset($session_permissions) && is_array($session_permissions) && isset($session_permissions[$current_module->id]) && is_array($session_permissions[$current_module->id]) && in_array('cadastrar', $session_permissions[$current_module->id])){ ?>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url($current_module->slug.'/cadastrar'); ?>" role="button" title="<?php echo T_('Insira um novo registro'); ?>">
                            <i class="fa-light fa-plus mr-2"></i> <?php echo T_('Cadastrar'); ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <input type="hidden" name="<?php echo $csrf_input_name ?>" value="<?php echo $csrf_test_name ?>">
        </form>
    </div>
</div>