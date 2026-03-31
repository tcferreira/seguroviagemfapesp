<div class="col-12 card-no-border">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Cadastro/Edição</h4>
            <h6 class="card-subtitle mb-2">Cadastre ou altere as informações de um registro já existente.</h6>

            <form action="<?php echo site_url($current_module->slug.'/'. (isset($item) ? 'edit/'.$id : 'add'))?>" method="POST" id="validateSubmitForm" role="form" enctype="multipart/form-data">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#general">
                            <?php echo T_('Dados Gerais'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="general">
                        <?php if(isset($item)){ ?>
                            <input type="hidden" value="<?php echo $item->id; ?>" name="id"/>
                        <?php } ?>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputNome"><?php echo T_('Nome'); ?></label>
                                <input type="text" class="form-control" id="inputNome" placeholder="<?php echo T_('Nome'); ?>" value="<?php echo isset($item) ? $item->name : ''; ?>" required maxlenght="255" name="name"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputSlug"><?php echo T_('Slug'); ?></label>
                                <input type="text" class="form-control" id="inputSlug" placeholder="<?php echo T_('adminsitracao/grupos'); ?>" value="<?php echo isset($item) ? $item->slug : ''; ?>" required maxlenght="255" name="slug"/>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputIcon"><?php echo T_('Ícone'); ?></label>
                                <input type="text" class="form-control" id="inputIcon" placeholder="<?php echo T_('fas fa-cog'); ?>" value="<?php echo isset($item) ? $item->icon : ''; ?>" maxlenght="255" name="icon"/>
                                <small id="iconHelp" class="form-text text-muted">
                                    Veja os ícones em: <a href="https://fontawesome.com/icons?d=gallery">Font Awesome</a>
                                </small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputParent"><?php echo T_('Módulo Pai'); ?></label>
                                <select name="id_parent" id="inputParent" placeholder="<?php echo T_('Módulo Pai'); ?>" class="form-control">
                                    <option value="">Selecione...</option>
                                    <?php foreach($listParent as $key => $value){ ?>
                                        <option value="<?php echo $value->id;?>" <?php echo isset($item) && $item->id_parent == $value->id ? 'selected' : '';?>>
                                            <?php echo $value->name;?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputOrdem"><?php echo T_('Ordem'); ?></label>
                                <input type="number" class="form-control" id="inputOrdem" placeholder="<?php echo T_('Ordem'); ?>" value="<?php echo isset($item) ? $item->order_by : '1'; ?>" required maxlenght="255" name="order_by"/>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputParent"><?php echo T_('Ações'); ?> <small>(separados por vírgula)</small></label>
                                <input type="text" class="form-control" id="inputAction" placeholder="<?php echo T_('Ações'); ?>" value="<?php echo isset($item) ? $item->action : 'Visualizar,Cadastrar,Editar,Deletar'; ?>" required maxlenght="255" name="action"/>
                            </div>
                        </div>


                        <?php statusField(isset($item) ? $item : null); ?>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <a href="<?php echo site_url($current_module->slug); ?>" class="btn btn-secondary mr-1">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><?php echo isset($item) ? 'Salvar' : 'Cadastrar'; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
