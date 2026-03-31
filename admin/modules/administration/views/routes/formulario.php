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
                        <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#languages">
                            <?php echo T_('SEO'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="general">
                        <?php if(isset($item)){ ?>
                            <input type="hidden" value="<?php echo $item->id; ?>" name="id"/>
                        <?php } ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputTitle"><?php echo T_('Título'); ?></label>
                                <input type="text" class="form-control" id="inputTitle" placeholder="<?php echo T_('Título'); ?>" required value="<?php echo isset($item) ? $item->label : ''; ?>" maxlenght="255" name="label"/>
                                <small class="form-text text-muted"><?php echo T_('(Utilize para descrever a rota. Apenas para organizacao.)'); ?></small>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputURL"><?php echo T_('URL'); ?></label>
                                <input type="text" class="form-control" id="inputURL" placeholder="<?php echo T_('URL'); ?>" value="<?php echo isset($item) ? $item->url_complement : ''; ?>" maxlenght="255" name="url_complement"/>
                                <small class="form-text text-muted"><?php echo T_('(Complemento da url para parametros nao-estaticos. Ex.: (:num)/(:any))'); ?></small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputKey"><?php echo T_('Key'); ?></label>
                                <input type="text" class="form-control" id="inputKey" placeholder="<?php echo T_('Key'); ?>" required value="<?php echo isset($item) ? $item->key : ''; ?>" maxlenght="255" name="key"/>
                                <small class="form-text text-muted"><?php echo T_('(Chave de array para imprimir os links nas views.)'); ?></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputMethod"><?php echo T_('Método'); ?> </label>
                                <input type="text" class="form-control" id="inputMethod" placeholder="<?php echo T_('Método'); ?>" required value="<?php echo isset($item) ? $item->method : ''; ?>" maxlenght="255" name="method"/>
                                <small class="form-text text-muted"><?php echo T_('(Método completo relativo a url. Ex.: produtos/detalhes/$1/$2)'); ?></small>
                            </div>
                        </div>

                        <?php statusField(isset($item) ? $item : null); ?>
                    </div>

                    <div class="tab-pane fade" id="languages">

                        <?php echo $this->load->view('comum/nav-lang', array('tabname' => 'tablang')); ?>
                        <div class="tab-content" id="nav-tablang">
                            <?php foreach ($languages as $key => $language) { ?>
                                <div class="tab-pane fade <?php echo ($key == 0) ? ' show active ' : ''; ?>" id="tablang<?php echo $key; ?>" role="tabpanel" aria-labelledby="tablang<?php echo $key; ?>-tab">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputURL<?php echo $key; ?>"><?php echo T_('URL'); ?></label>
                                            <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][url]" id="inputURL<?php echo $key; ?>" placeholder="<?php echo T_('URL'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->url : ''; ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputTitle<?php echo $key; ?>"><?php echo T_('Título'); ?></label>
                                            <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][seo_title]" id="inputTitle<?php echo $key; ?>" placeholder="<?php echo T_('Título'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->seo_title : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputDescription<?php echo $key; ?>"><?php echo T_('Descrição'); ?></label>
                                            <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][seo_description]" id="inputDescription<?php echo $key; ?>" placeholder="<?php echo T_('Description'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->seo_description : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputDescription<?php echo $key; ?>"><?php echo T_('Keywords'); ?></label>
                                            <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][seo_keywords]" id="inputKeywords<?php echo $key; ?>" placeholder="<?php echo T_('Keywords'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->seo_keywords : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
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