<div class='row'>
    <div class='col-12 card-no-border'>
        <div class='card'>
            <div class='card-body'>

                <form action='<?php echo site_url($current_module->slug.'/'. (isset($item) ? 'edit/'.$id : 'add'))?>' method='POST' id='validateSubmitForm' role='form' enctype='multipart/form-data'>
                    <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                        <li class='nav-item'>
                            <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#general'>
                                <?php echo T_('Configuração'); ?>
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
                                    <label for='inputChave'><?php echo T_('Chave'); ?></label>
                                    <input type='text' class='form-control' id='inputChave' placeholder='Ex: whatsapp_numero' value='<?php echo isset($item) ? $item->chave : ''; ?>' required name='chave' <?php echo isset($item) ? 'readonly' : ''; ?>/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputTitulo'><?php echo T_('Título'); ?></label>
                                    <input type='text' class='form-control' id='inputTitulo' placeholder='<?php echo T_('Título descritivo'); ?>' value='<?php echo isset($item) ? $item->titulo : ''; ?>' required name='titulo'/>
                                </div>
                                <div class='form-group col-md-2'>
                                    <label for='inputTipo'><?php echo T_('Tipo'); ?></label>
                                    <select class='form-control' id='inputTipo' name='tipo'>
                                        <?php
                                        $tipos = ['text' => 'Texto', 'textarea' => 'Área de texto', 'image' => 'Imagem', 'html' => 'HTML'];
                                        foreach($tipos as $val => $label): ?>
                                            <option value='<?php echo $val; ?>' <?php echo (isset($item) && $item->tipo == $val) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class='form-group col-md-2'>
                                    <label for='inputGrupo'><?php echo T_('Grupo'); ?></label>
                                    <input type='text' class='form-control' id='inputGrupo' placeholder='geral' value='<?php echo isset($item) ? $item->grupo : 'geral'; ?>' name='grupo'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-12'>
                                    <label for='inputValor'><?php echo T_('Valor'); ?></label>
                                    <?php if(isset($item) && ($item->tipo == 'textarea' || $item->tipo == 'html')): ?>
                                        <textarea class='form-control' id='inputValor' rows='6' name='valor'><?php echo $item->valor; ?></textarea>
                                    <?php elseif(isset($item) && $item->tipo == 'image'): ?>
                                        <div class="custom-file mb-2">
                                            <input type='file' class='custom-file-input' id='inputValor' name='valor' accept='image/*' onchange="previewImage(this, 'previewConfig')"/>
                                            <label class="custom-file-label" for="inputValor"><?php echo T_('Escolher arquivo...'); ?></label>
                                        </div>
                                        <?php if($item->valor): ?>
                                            <img src="/userfiles/<?php echo $current_module->slug . '/' . $item->valor; ?>" alt="Preview" id="previewConfig" class="img-thumbnail mt-1" style="max-height:80px;"/>
                                        <?php else: ?>
                                            <img src="" alt="" id="previewConfig" class="img-thumbnail mt-1" style="max-height:80px;display:none;"/>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <input type='text' class='form-control' id='inputValor' placeholder='Valor da configuração' value='<?php echo isset($item) ? $item->valor : ''; ?>' name='valor'/>
                                    <?php endif; ?>
                                </div>
                            </div>
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
<script>
function previewImage(input, previewId) {
    var preview = document.getElementById(previewId);
    var label = input.nextElementSibling;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
        label.textContent = input.files[0].name;
    }
}
</script>
