<div class='row'>
    <div class='col-12 card-no-border'>
        <div class='card'>
            <div class='card-body'>

                <form action='<?php echo site_url($current_module->slug.'/'. (isset($item) ? 'edit/'.$id : 'add'))?>' method='POST' id='validateSubmitForm' role='form' enctype='multipart/form-data'>
                    <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                        <li class='nav-item'>
                            <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#general'>
                                <?php echo T_('Dados Gerais'); ?>
                            </a>
                        </li>
                    </ul>
                    <div class='tab-content' id='pills-tabContent'>
                        <div class='tab-pane fade show active' id='general'>
                            <?php if(isset($item)){ ?>
                                <input type='hidden' value='<?php echo $item->id; ?>' name='id'/>
                            <?php } ?>

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for='inputNumero'><?php echo T_('Número'); ?></label>
                                    <input type='text' class='form-control' id='inputNumero' placeholder='Ex: 12.500+' value='<?php echo isset($item) ? $item->numero : ''; ?>' required name='numero'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputLabel'><?php echo T_('Label'); ?></label>
                                    <input type='text' class='form-control' id='inputLabel' placeholder='Ex: Bolsistas atendidos' value='<?php echo isset($item) ? $item->label : ''; ?>' required name='label'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputIcone'><?php echo T_('Ícone (FontAwesome)'); ?></label>
                                    <input type='text' class='form-control' id='inputIcone' placeholder='Ex: fa-shield-alt' value='<?php echo isset($item) ? $item->icone : 'fa-shield-alt'; ?>' name='icone'/>
                                </div>
                            </div>

                            <?php statusField(isset($item) ? $item : null); ?>
                        </div>
                    </div>

                    <div class='d-flex justify-content-center'>
                        <a href='<?php echo site_url($current_module->slug); ?>' class='btn btn-secondary mr-1'><?php echo T_('Cancelar'); ?></a>
                        <button type='submit' class='btn btn-primary'><?php echo isset($item) ? T_('Salvar') : T_('Cadastrar'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
