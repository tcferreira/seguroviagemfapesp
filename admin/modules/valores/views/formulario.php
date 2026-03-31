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
                                <div class='form-group col-md-12'>
                                    <label for='inputModalidade'><?php echo T_('Modalidade'); ?></label>
                                    <input type='text' class='form-control' id='inputModalidade' placeholder='Ex: Mestrado / Doutorado' value='<?php echo isset($item) ? $item->modalidade : ''; ?>' required name='modalidade'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for='inputValorAtual'><?php echo T_('Valor Atual'); ?></label>
                                    <input type='text' class='form-control' id='inputValorAtual' placeholder='R$ 1.680,00' value='<?php echo isset($item) ? $item->valor_atual : ''; ?>' required name='valor_atual'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputValorAtualLabel'><?php echo T_('Label Valor Atual'); ?></label>
                                    <input type='text' class='form-control' id='inputValorAtualLabel' placeholder='A partir de 01/09/2025' value='<?php echo isset($item) ? $item->valor_atual_label : ''; ?>' name='valor_atual_label'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputUnidade'><?php echo T_('Unidade'); ?></label>
                                    <input type='text' class='form-control' id='inputUnidade' placeholder='/ mês ou fração' value='<?php echo isset($item) ? $item->unidade : ''; ?>' name='unidade'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputValorAnterior'><?php echo T_('Valor Anterior'); ?></label>
                                    <input type='text' class='form-control' id='inputValorAnterior' placeholder='R$ 1.560,00' value='<?php echo isset($item) ? $item->valor_anterior : ''; ?>' name='valor_anterior'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputValorAnteriorLabel'><?php echo T_('Label Valor Anterior'); ?></label>
                                    <input type='text' class='form-control' id='inputValorAnteriorLabel' placeholder='01/06/2022 a 31/08/2025' value='<?php echo isset($item) ? $item->valor_anterior_label : ''; ?>' name='valor_anterior_label'/>
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
