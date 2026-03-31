
<div class='col-12 card-no-border'>
    <div class='card'>
        <div class='card-body'>
            <h4 class='card-title'>Cadastro/Edição</h4>
            <h6 class='card-subtitle mb-2'>Cadastre ou altere as informações de um registro já existente.</h6>

            <form action='<?php echo site_url($current_module->slug.'/'. (isset($item) ? 'edit/'.$id : 'add'))?>' method='POST' id='validateSubmitForm' role='form' enctype='multipart/form-data'>
                <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                    <li class='nav-item'>
                        <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#general'>
                            <?php echo T_('Dados Gerais'); ?>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#location'>
                            <?php echo T_('Localização'); ?>
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#social_network'>
                            <?php echo T_('Redes Sociais'); ?>
                        </a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#seo'>
                            <?php echo T_('SEO'); ?>
                        </a>
                    </li>
                </ul>

                <div class='tab-content' id='pills-tabContent'>
                    <div class='tab-pane fade show active' id='general'>
                        <?php if(isset($item)){ ?>
                            <input type='hidden' value='<?php echo $item->id; ?>' name='id'/>
                        <?php } ?>

                        <div class="form-row">
                            <div class="col-xs-12 col-sm-12 form-group">
                                <label for="inputRazaoSocial"><?php echo T_('Razão Social'); ?> </label>
                                <input type="text" class="form-control" name="company_name" id="inputRazaoSocial" placeholder="<?php echo T_('Razão Social'); ?>" value="<?php echo (isset($item->company_name)) ?  $item->company_name : '';?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-sm-12 form-group">
                                <label for="inputNomeFantasia"><?php echo T_('Nome Fantasia'); ?> </label>
                                <input type="text" class="form-control" name="fantasy_name" id="inputNomeFantasia" placeholder="<?php echo T_('Nome Fantasia'); ?>" value="<?php echo (isset($item->fantasy_name)) ?  $item->fantasy_name : '';?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xs-12 col-sm-12 form-group">
                                <label for="inputEmail"><?php echo T_('E-mail'); ?> </label>
                                <input type="text" class="form-control" name="email" id="inputEmail" placeholder="<?php echo T_('E-mail'); ?>" value="<?php echo (isset($item->email)) ?  $item->email : '';?>" required>
                            </div>
                        </div>

                        <?php statusField(isset($item) ? $item : null); ?>

                    </div>

                    <div class="tab-pane fade" id="location">
                        <?php
                            $this->load->view('comum/endereco', $item);
                        ?>
                    </div>

                    <div class="tab-pane fade" id="social_network">
                        <?php echo $this->load->view('comum/nav-lang', array('tabname' => 'tablang')); ?>

                        <!-- Body da tab linguagem -->
                        <div class="tab-content" id="nav-tablang">
                        <?php foreach ($languages as $key => $language) { ?>
                            <div class="tab-pane fade <?php echo ($key == 0) ? ' show active ' : ''; ?>" id="tablang<?php echo $key; ?>" role="tabpanel" aria-labelledby="tablang<?php echo $key; ?>-tab">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFacebook<?php echo $key; ?>"><?php echo T_('Facebook'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][facebook]" id="inputFacebook<?php echo $key; ?>" placeholder="<?php echo T_('Facebook'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->facebook : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputTwitter<?php echo $key; ?>"><?php echo T_('Twitter'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][twitter]" id="inputTwitter<?php echo $key; ?>" placeholder="<?php echo T_('Twitter'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->twitter : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputInstagram<?php echo $key; ?>"><?php echo T_('Instagram'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][instagram]" id="inputInstagram<?php echo $key; ?>" placeholder="<?php echo T_('Instagram'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->instagram : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputYoutube<?php echo $key; ?>"><?php echo T_('Youtube'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][youtube]" id="inputYoutube<?php echo $key; ?>" placeholder="<?php echo T_('Youtube'); ?>" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->youtube : ''; ?>">
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="seo">
                        <?php echo $this->load->view('comum/nav-lang', array('tabname' => 'tablang')); ?>

                        <!-- Body da tab linguagem -->
                        <div class="tab-content" id="nav-tablang">
                        <?php foreach ($languages as $key => $language) { ?>
                            <div class="tab-pane fade <?php echo ($key == 0) ? ' show active ' : ''; ?>" id="tablang<?php echo $key; ?>" role="tabpanel" aria-labelledby="tablang<?php echo $key; ?>-tab">
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label for="inputTitle<?php echo $key; ?>"><?php echo T_('Meta Title'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][meta_title]" id="inputTitle<?php echo $key; ?>" placeholder="Meta Title" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->meta_title : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label for="inputDescription<?php echo $key; ?>"><?php echo T_('Meta Description'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][meta_description]" id="inputDescription<?php echo $key; ?>" placeholder="Meta Description" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->meta_description : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label for="inputKeywords<?php echo $key; ?>"><?php echo T_('Meta Keywords'); ?></label>
                                        <input type="text" class="form-control" name="value[<?php echo $language->id; ?>][meta_keywords]" id="inputKeywords<?php echo $key; ?>" placeholder="Meta Keywords" value="<?php echo (isset($item->languages[$language->id])) ? $item->languages[$language->id]->meta_keywords : ''; ?>">
                                    </div>
                                </div>

                                <hr>

                                <div class="form-row">
                                    <div class="col-sm-12 form-group">
                                        <label for="inputGTM<?php echo $key; ?>"><?php echo T_('Google Tag Manager'); ?></label>
                                        <input type="text" class="form-control" name="google_tag_manager" id="inputGTM<?php echo $key; ?>" placeholder="Google Tag Manager" value="<?php echo (isset($item->google_tag_manager)) ? $item->google_tag_manager : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>

                    </div>
                </div>

                <div class='d-flex justify-content-center'>
                    <a href='<?php echo site_url($current_module->slug); ?>' class='btn btn-secondary mr-1'>Cancelar</a>
                    <button type='submit' class='btn btn-primary'><?php echo isset($item) ? 'Salvar' : 'Cadastrar'; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
