<div class='row'>
    <div class='col-12 card-no-border'>
        <div class='card'>
            <div class='card-body'>

                <form action='<?php echo site_url($current_module->slug.'/'. (isset($item) ? 'edit/'.$id : 'add'))?>' method='POST' id='validateSubmitForm' role='form' enctype='multipart/form-data'>
                    <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                        <li class='nav-item'>
                            <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#general'>
                                <?php echo T_('Dados do Lead'); ?>
                            </a>
                        </li>
                    </ul>
                    <div class='tab-content' id='pills-tabContent'>
                        <div class='tab-pane fade show active' id='general'>
                            <?php if(isset($item)){ ?>
                                <input type='hidden' value='<?php echo $item->id; ?>' name='id'/>
                            <?php } ?>

                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputNome'><?php echo T_('Nome'); ?></label>
                                    <input type='text' class='form-control' id='inputNome' value='<?php echo isset($item) ? $item->nome : ''; ?>' name='nome'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputEmail'><?php echo T_('E-mail'); ?></label>
                                    <input type='email' class='form-control' id='inputEmail' value='<?php echo isset($item) ? $item->email : ''; ?>' name='email'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for='inputTelefone'><?php echo T_('Telefone'); ?></label>
                                    <input type='text' class='form-control' id='inputTelefone' value='<?php echo isset($item) ? $item->telefone : ''; ?>' name='telefone'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputModalidade'><?php echo T_('Modalidade da Bolsa'); ?></label>
                                    <input type='text' class='form-control' id='inputModalidade' value='<?php echo isset($item) ? $item->modalidade_bolsa : ''; ?>' name='modalidade_bolsa'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputPais'><?php echo T_('País de Destino'); ?></label>
                                    <input type='text' class='form-control' id='inputPais' value='<?php echo isset($item) ? $item->pais_destino : ''; ?>' name='pais_destino'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputDuracao'><?php echo T_('Duração'); ?></label>
                                    <input type='text' class='form-control' id='inputDuracao' value='<?php echo isset($item) ? $item->duracao : ''; ?>' name='duracao'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputStatus'><?php echo T_('Status do Lead'); ?></label>
                                    <select class='form-control' id='inputStatus' name='status'>
                                        <?php
                                        $statusOptions = [
                                            'novo' => 'Novo',
                                            'em_atendimento' => 'Em Atendimento',
                                            'convertido' => 'Convertido',
                                            'descartado' => 'Descartado',
                                        ];
                                        foreach($statusOptions as $val => $label): ?>
                                            <option value='<?php echo $val; ?>' <?php echo (isset($item) && $item->status == $val) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-12'>
                                    <label for='inputMensagem'><?php echo T_('Mensagem'); ?></label>
                                    <textarea class='form-control' id='inputMensagem' rows='4' name='mensagem'><?php echo isset($item) ? $item->mensagem : ''; ?></textarea>
                                </div>
                            </div>

                            <?php if(isset($item)): ?>
                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label><?php echo T_('Origem'); ?></label>
                                    <input type='text' class='form-control' value='<?php echo $item->origem; ?>' readonly/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label><?php echo T_('Criado em'); ?></label>
                                    <input type='text' class='form-control' value='<?php echo date('d/m/Y H:i', strtotime($item->created_at)); ?>' readonly/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label><?php echo T_('Atualizado em'); ?></label>
                                    <input type='text' class='form-control' value='<?php echo date('d/m/Y H:i', strtotime($item->updated_at)); ?>' readonly/>
                                </div>
                            </div>
                            <?php endif; ?>
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
