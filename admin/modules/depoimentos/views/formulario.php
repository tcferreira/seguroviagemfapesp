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
                                <div class='form-group col-md-6'>
                                    <label for='inputNome'><?php echo T_('Nome'); ?></label>
                                    <input type='text' class='form-control' id='inputNome' placeholder='Nome do bolsista' value='<?php echo isset($item) ? $item->nome : ''; ?>' required name='nome'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputModalidade'><?php echo T_('Modalidade'); ?></label>
                                    <input type='text' class='form-control' id='inputModalidade' placeholder='Ex: Doutorado' value='<?php echo isset($item) ? $item->modalidade : ''; ?>' name='modalidade'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label for='inputUniversidade'><?php echo T_('Universidade'); ?></label>
                                    <input type='text' class='form-control' id='inputUniversidade' placeholder='Ex: MIT' value='<?php echo isset($item) ? $item->universidade : ''; ?>' name='universidade'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputPais'><?php echo T_('País'); ?></label>
                                    <input type='text' class='form-control' id='inputPais' placeholder='Ex: EUA' value='<?php echo isset($item) ? $item->pais : ''; ?>' name='pais'/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputNota'><?php echo T_('Nota (1-5)'); ?></label>
                                    <select class='form-control' id='inputNota' name='nota'>
                                        <?php for($i = 5; $i >= 1; $i--): ?>
                                            <option value='<?php echo $i; ?>' <?php echo (isset($item) && $item->nota == $i) ? 'selected' : ($i == 5 && !isset($item) ? 'selected' : ''); ?>><?php echo $i; ?> <?php echo str_repeat('★', $i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-12'>
                                    <label for='inputTexto'><?php echo T_('Depoimento'); ?></label>
                                    <textarea class='form-control' id='inputTexto' placeholder='Texto do depoimento...' rows='4' required name='texto'><?php echo isset($item) ? $item->texto : ''; ?></textarea>
                                </div>
                            </div>

                            <!-- ========== UPLOAD DRAG & DROP - Foto ========== -->
                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label><?php echo T_('Foto'); ?></label>
                                    <input type='hidden' name='image' id='hiddenImage' value='<?php echo isset($item) ? $item->image : ''; ?>'/>
                                    <div class="dropzone-area" id="dropzoneFoto" data-field="image" data-hidden="hiddenImage" data-preview="previewFoto">
                                        <div class="dropzone-content" id="dropzoneFotoContent">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                            <p class="mt-2 mb-0 text-muted">Arraste a foto aqui ou <span class="text-primary" style="cursor:pointer;text-decoration:underline;">clique para selecionar</span></p>
                                            <small class="text-muted">PNG, JPG, WebP — máx. 10MB</small>
                                        </div>
                                        <div class="dropzone-preview" id="dropzoneFotoPreview" style="display:none;">
                                            <img src="<?php echo (isset($item) && $item->image) ? '/userfiles/depoimentos/'.$item->image : ''; ?>" alt="" id="previewFoto"/>
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
    var uploadUrl = '<?php echo site_url("depoimentos/upload_image"); ?>';
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
            if (file.size > 10 * 1024 * 1024) { alert('Arquivo muito grande. Máximo 10MB.'); return; }

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
