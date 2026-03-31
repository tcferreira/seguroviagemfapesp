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

                    <li class="nav-item">
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#permissions">
                            <?php echo T_('Permissões'); ?>
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
                                <label for="inputTitle"><?php echo T_('Título'); ?></label>
                                <input type="text" class="form-control" id="inputNome" placeholder="<?php echo T_('Título'); ?>" required value="<?php echo isset($item) ? $item->name : ''; ?>" maxlenght="255" name="name"/>
                            </div>
                        </div>

                        <?php statusField(isset($item) ? $item : null); ?>
                    </div>

                    <div class="tab-pane fade show" id="permissions">
                        <?php if (isset($modules)) { ?>
                            <h4 class="mb-3 mt-2"><?php echo T_('Permissões'); ?></h4>
                            <div class="col-sm-12 permission-wrapper">
                                <?php $this->load->view('administration/groups/permissions', array(
                                    'modules' => isset($modules) ? $modules : []
                                )); ?>
                            </div>
                        <?php } ?>
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

