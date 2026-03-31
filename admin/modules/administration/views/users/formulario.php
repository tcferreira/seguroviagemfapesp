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
                            <div class="form-group col-12 col-md-6">
                                <label for="inputNome"><?php echo T_('Nome'); ?></label>
                                <input type="text" class="form-control" id="inputNome" placeholder="<?php echo T_('Nome'); ?>" value="<?php echo isset($item) ? $item->nome : ''; ?>" required maxlenght="255" name="nome"/>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="inputEmail"><?php echo T_('E-mail'); ?></label>
                                <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo T_('E-mail'); ?>" value="<?php echo isset($item) ? $item->email : ''; ?>" required maxlenght="255" name="email"/>
                            </div>
                        </div>

                        <?php if ( !isset($item) ){ ?>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputSenha"><?php echo T_('Senha'); ?></label>
                                    <input type="password" class="form-control" id="inputSenha" placeholder="<?php echo T_('Senha'); ?>" value="" maxlength="50" name="senha" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputSenha2"><?php echo T_('Repetir Senha'); ?></label>
                                    <input type="password" class="form-control" id="inputSenha2" placeholder="<?php echo T_('Repetir Senha'); ?>" value="" maxlength="50" name="senha_repete" required/>
                                </div>
                            </div>
                        <?php } else { ?>
                            <hr class="my-3">
                            <h5 class="mb-3">Alterar Senha <small class="text-muted">(deixe em branco para manter a atual)</small></h5>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputNovaSenha">Nova Senha</label>
                                    <input type="password" class="form-control" id="inputNovaSenha" placeholder="Nova senha" name="nova_senha" autocomplete="new-password"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputConfirmaSenha">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="inputConfirmaSenha" placeholder="Repita a nova senha" name="confirma_senha" autocomplete="new-password"/>
                                </div>
                            </div>
                            <hr class="my-3">
                        <?php }  ?>

                        <!-- ========== PERMISSÕES POR MÓDULO ========== -->
                        <?php
                            $userPerms = [];
                            if (isset($item) && $item->permissions) {
                                $userPerms = json_decode($item->permissions, true) ?: [];
                            }
                            $actions = ['visualizar', 'cadastrar', 'editar', 'excluir'];
                        ?>
                        <hr class="my-3">
                        <h5 class="mb-3">Permissões</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Módulo</th>
                                        <th class="text-center" style="width:100px;">Visualizar</th>
                                        <th class="text-center" style="width:100px;">Cadastrar</th>
                                        <th class="text-center" style="width:100px;">Editar</th>
                                        <th class="text-center" style="width:100px;">Excluir</th>
                                        <th class="text-center" style="width:80px;">
                                            <label class="mb-0" style="cursor:pointer;" title="Marcar/Desmarcar todos">
                                                <input type="checkbox" id="checkAll"/> Todos
                                            </label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modules as $mod): ?>
                                    <tr>
                                        <td><i class="<?php echo $mod->icon; ?> mr-1"></i> <?php echo $mod->name; ?></td>
                                        <?php foreach ($actions as $act): ?>
                                        <td class="text-center">
                                            <input type="checkbox" name="permissions[<?php echo $mod->id; ?>][]" value="<?php echo $act; ?>"
                                                <?php echo (isset($userPerms[$mod->id]) && in_array($act, $userPerms[$mod->id])) ? 'checked' : ''; ?>
                                                class="perm-check"/>
                                        </td>
                                        <?php endforeach; ?>
                                        <td class="text-center">
                                            <input type="checkbox" class="row-check-all" data-module="<?php echo $mod->id; ?>"/>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function(){
                            // Row check all
                            document.querySelectorAll('.row-check-all').forEach(function(cb){
                                var moduleId = cb.dataset.module;
                                var boxes = document.querySelectorAll('input[name="permissions['+moduleId+'][]"]');
                                // Init state
                                cb.checked = Array.from(boxes).every(function(b){ return b.checked; });
                                cb.addEventListener('change', function(){
                                    boxes.forEach(function(b){ b.checked = cb.checked; });
                                    updateCheckAll();
                                });
                                boxes.forEach(function(b){
                                    b.addEventListener('change', function(){
                                        cb.checked = Array.from(boxes).every(function(x){ return x.checked; });
                                        updateCheckAll();
                                    });
                                });
                            });
                            // Check all
                            var checkAll = document.getElementById('checkAll');
                            function updateCheckAll(){
                                var all = document.querySelectorAll('.perm-check');
                                checkAll.checked = Array.from(all).every(function(b){ return b.checked; });
                            }
                            updateCheckAll();
                            checkAll.addEventListener('change', function(){
                                document.querySelectorAll('.perm-check').forEach(function(b){ b.checked = checkAll.checked; });
                                document.querySelectorAll('.row-check-all').forEach(function(b){ b.checked = checkAll.checked; });
                            });
                        });
                        </script>

                        <!-- ========== UPLOAD DRAG & DROP - Foto ========== -->
                        <div class='form-row'>
                            <div class='form-group col-md-6'>
                                <label><?php echo T_('Foto'); ?></label>
                                <input type='hidden' name='image' id='hiddenPhoto' value='<?php echo (isset($item) && $item->image) ? $item->image : ''; ?>'/>
                                <div class="dropzone-area" id="dropzoneFoto" data-field="photo" data-hidden="hiddenPhoto" data-preview="previewFoto">
                                    <div class="dropzone-content" id="dropzoneFotoContent">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                        <p class="mt-2 mb-0 text-muted">Arraste a foto aqui ou <span class="text-primary" style="cursor:pointer;text-decoration:underline;">clique para selecionar</span></p>
                                        <small class="text-muted">PNG, JPG, WebP — máx. 5MB</small>
                                    </div>
                                    <div class="dropzone-preview" id="dropzoneFotoPreview" style="display:none;">
                                        <img src="<?php echo (isset($item) && $item->image) ? '/userfiles/administration/users/'.$item->image : ''; ?>" alt="" id="previewFoto"/>
                                        <button type="button" class="btn btn-sm btn-danger dropzone-remove" title="Remover"><i class="fas fa-times"></i></button>
                                        <div class="dropzone-progress" id="progressFoto" style="display:none;">
                                            <div class="dropzone-progress-bar"></div>
                                        </div>
                                    </div>
                                    <input type="file" class="dropzone-input" id="fileFoto" accept="image/*" style="display:none;"/>
                                </div>
                                <?php if(isset($item) && $item->image): ?>
                                <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('dropzoneFotoContent').style.display='none';document.getElementById('dropzoneFotoPreview').style.display='flex';});</script>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php statusField(isset($item) ? $item : null); ?>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="<?php echo site_url($current_module->slug); ?>" class="btn btn-secondary mr-1">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><?php echo isset($item) ? 'Salvar' : 'Cadastrar'; ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.dropzone-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 0;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.3s, background 0.3s;
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: #fafbfc;
}
.dropzone-area.dragover {
    border-color: var(--primary);
    background: rgba(255, 121, 0, 0.06);
}
.dropzone-area:hover {
    border-color: #adb5bd;
}
.dropzone-content {
    padding: 30px 20px;
    width: 100%;
}
.dropzone-preview {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    min-height: 180px;
    position: relative;
    padding: 10px;
}
.dropzone-preview img {
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
    border-radius: 8px;
}
.dropzone-remove {
    position: absolute;
    top: 8px;
    right: 8px;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    padding: 0;
    line-height: 28px;
    text-align: center;
    z-index: 3;
}
.dropzone-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #e9ecef;
    border-radius: 0 0 12px 12px;
    overflow: hidden;
}
.dropzone-progress-bar {
    height: 100%;
    background: var(--primary);
    width: 0%;
    transition: width 0.3s;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var uploadUrl = '<?php echo site_url("administration/users/upload-image"); ?>';
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    document.querySelectorAll('.dropzone-area').forEach(function(zone) {
        var fileInput = zone.querySelector('.dropzone-input');
        var contentDiv = zone.querySelector('.dropzone-content');
        var previewDiv = zone.querySelector('.dropzone-preview');
        var previewImg = previewDiv.querySelector('img');
        var removeBtn = zone.querySelector('.dropzone-remove');
        var progressWrap = previewDiv.querySelector('.dropzone-progress');
        var progressBar = previewDiv.querySelector('.dropzone-progress-bar');
        var hiddenInput = document.getElementById(zone.dataset.hidden);

        zone.addEventListener('click', function(e) {
            if (e.target.closest('.dropzone-remove')) return;
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) uploadFile(this.files[0]);
        });

        ['dragenter', 'dragover'].forEach(function(evt) {
            zone.addEventListener(evt, function(e) { e.preventDefault(); e.stopPropagation(); zone.classList.add('dragover'); });
        });
        ['dragleave', 'drop'].forEach(function(evt) {
            zone.addEventListener(evt, function(e) { e.preventDefault(); e.stopPropagation(); zone.classList.remove('dragover'); });
        });
        zone.addEventListener('drop', function(e) {
            var files = e.dataTransfer.files;
            if (files && files[0]) uploadFile(files[0]);
        });

        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            previewImg.src = '';
            hiddenInput.value = '';
            previewDiv.style.display = 'none';
            contentDiv.style.display = 'block';
            fileInput.value = '';
        });

        function uploadFile(file) {
            if (!file.type.match('image.*')) { alert('Apenas imagens são permitidas.'); return; }
            if (file.size > 5 * 1024 * 1024) { alert('Arquivo muito grande. Máximo 5MB.'); return; }

            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                contentDiv.style.display = 'none';
                previewDiv.style.display = 'flex';
            };
            reader.readAsDataURL(file);

            var formData = new FormData();
            formData.append('file', file);
            formData.append(csrfName, csrfHash);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', uploadUrl, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            progressWrap.style.display = 'block';
            progressBar.style.width = '0%';
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) progressBar.style.width = Math.round((e.loaded / e.total) * 100) + '%';
            });

            xhr.onload = function() {
                progressWrap.style.display = 'none';
                try {
                    var resp = JSON.parse(xhr.responseText);
                    if (resp.success) {
                        hiddenInput.value = resp.filename;
                        previewImg.src = resp.url;
                        if (resp.csrf_hash) csrfHash = resp.csrf_hash;
                    } else {
                        alert('Erro no upload: ' + (resp.message || 'Tente novamente.'));
                        removeBtn.click();
                    }
                } catch(ex) {
                    alert('Erro no upload. Tente novamente.');
                    removeBtn.click();
                }
            };
            xhr.onerror = function() {
                progressWrap.style.display = 'none';
                alert('Erro de conexão. Tente novamente.');
                removeBtn.click();
            };
            xhr.send(formData);
        }
    });
});
</script>