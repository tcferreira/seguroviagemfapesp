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
                                    <label for='inputTitle'><?php echo T_('Título'); ?></label>
                                    <input type='text' class='form-control' id='inputTitle' placeholder='<?php echo T_('Título do banner'); ?>' value='<?php echo isset($item) ? $item->title : ''; ?>' required name='title'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-12'>
                                    <label for='inputSubtitle'><?php echo T_('Subtítulo'); ?></label>
                                    <textarea class='form-control' id='inputSubtitle' placeholder='<?php echo T_('Subtítulo do banner'); ?>' rows='3' name='subtitle'><?php echo isset($item) ? $item->subtitle : ''; ?></textarea>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputCtaText'><?php echo T_('Texto CTA Principal'); ?></label>
                                    <input type='text' class='form-control' id='inputCtaText' placeholder='Falar com especialista' value='<?php echo isset($item) ? $item->cta_text : ''; ?>' name='cta_text'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputCtaLink'><?php echo T_('Link CTA Principal'); ?></label>
                                    <input type='text' class='form-control' id='inputCtaLink' placeholder='https://...' value='<?php echo isset($item) ? $item->cta_link : ''; ?>' name='cta_link'/>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='inputCtaSecText'><?php echo T_('Texto CTA Secundário'); ?></label>
                                    <input type='text' class='form-control' id='inputCtaSecText' placeholder='Entender o que a FAPESP exige' value='<?php echo isset($item) ? $item->cta_secondary_text : ''; ?>' name='cta_secondary_text'/>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='inputCtaSecLink'><?php echo T_('Link CTA Secundário'); ?></label>
                                    <input type='text' class='form-control' id='inputCtaSecLink' placeholder='#requisitos' value='<?php echo isset($item) ? $item->cta_secondary_link : ''; ?>' name='cta_secondary_link'/>
                                </div>
                            </div>

                            <!-- ========== UPLOAD DRAG & DROP ========== -->
                            <div class='form-row'>
                                <!-- Desktop -->
                                <div class='form-group col-md-6'>
                                    <label><?php echo T_('Imagem Desktop'); ?></label>
                                    <input type='hidden' name='image' id='hiddenImage' value='<?php echo isset($item) ? $item->image : ''; ?>'/>
                                    <div class="dropzone-area" id="dropzoneDesktop" data-field="image" data-hidden="hiddenImage" data-preview="previewDesktop">
                                        <div class="dropzone-content" id="dropzoneDesktopContent">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                            <p class="mt-2 mb-0 text-muted">Arraste a imagem aqui ou <span class="text-primary" style="cursor:pointer;text-decoration:underline;">clique para selecionar</span></p>
                                            <small class="text-muted">PNG, JPG, WebP — máx. 10MB</small>
                                        </div>
                                        <div class="dropzone-preview" id="dropzoneDesktopPreview" style="display:none;">
                                            <img src="<?php echo (isset($item) && $item->image) ? '/userfiles/banners/'.$item->image : ''; ?>" alt="" id="previewDesktop"/>
                                            <button type="button" class="btn btn-sm btn-danger dropzone-remove" title="Remover"><i class="fas fa-times"></i></button>
                                            <div class="dropzone-progress" id="progressDesktop" style="display:none;">
                                                <div class="dropzone-progress-bar"></div>
                                            </div>
                                        </div>
                                        <input type="file" class="dropzone-input" id="fileDesktop" accept="image/*" style="display:none;"/>
                                    </div>
                                    <?php if(isset($item) && $item->image): ?>
                                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('dropzoneDesktopContent').style.display='none';document.getElementById('dropzoneDesktopPreview').style.display='flex';});</script>
                                    <?php endif; ?>
                                </div>
                                <!-- Mobile -->
                                <div class='form-group col-md-6'>
                                    <label><?php echo T_('Imagem Mobile'); ?></label>
                                    <input type='hidden' name='image_mobile' id='hiddenImageMobile' value='<?php echo isset($item) ? $item->image_mobile : ''; ?>'/>
                                    <div class="dropzone-area" id="dropzoneMobile" data-field="image_mobile" data-hidden="hiddenImageMobile" data-preview="previewMobile">
                                        <div class="dropzone-content" id="dropzoneMobileContent">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                                            <p class="mt-2 mb-0 text-muted">Arraste a imagem aqui ou <span class="text-primary" style="cursor:pointer;text-decoration:underline;">clique para selecionar</span></p>
                                            <small class="text-muted">PNG, JPG, WebP — máx. 10MB</small>
                                        </div>
                                        <div class="dropzone-preview" id="dropzoneMobilePreview" style="display:none;">
                                            <img src="<?php echo (isset($item) && $item->image_mobile) ? '/userfiles/banners/'.$item->image_mobile : ''; ?>" alt="" id="previewMobile"/>
                                            <button type="button" class="btn btn-sm btn-danger dropzone-remove" title="Remover"><i class="fas fa-times"></i></button>
                                            <div class="dropzone-progress" id="progressMobile" style="display:none;">
                                                <div class="dropzone-progress-bar"></div>
                                            </div>
                                        </div>
                                        <input type="file" class="dropzone-input" id="fileMobile" accept="image/*" style="display:none;"/>
                                    </div>
                                    <?php if(isset($item) && $item->image_mobile): ?>
                                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('dropzoneMobileContent').style.display='none';document.getElementById('dropzoneMobilePreview').style.display='flex';});</script>
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
    var uploadUrl = '<?php echo site_url("banners/upload_image"); ?>';
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

        // Click to select
        zone.addEventListener('click', function(e) {
            if (e.target.closest('.dropzone-remove')) return;
            fileInput.click();
        });

        // File selected via input
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) uploadFile(this.files[0]);
        });

        // Drag events
        ['dragenter', 'dragover'].forEach(function(evt) {
            zone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.add('dragover');
            });
        });
        ['dragleave', 'drop'].forEach(function(evt) {
            zone.addEventListener(evt, function(e) {
                e.preventDefault();
                e.stopPropagation();
                zone.classList.remove('dragover');
            });
        });
        zone.addEventListener('drop', function(e) {
            var files = e.dataTransfer.files;
            if (files && files[0]) uploadFile(files[0]);
        });

        // Remove
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            previewImg.src = '';
            hiddenInput.value = '';
            previewDiv.style.display = 'none';
            contentDiv.style.display = 'block';
            fileInput.value = '';
        });

        // AJAX Upload
        function uploadFile(file) {
            if (!file.type.match('image.*')) {
                alert('Apenas imagens são permitidas.');
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                alert('Arquivo muito grande. Máximo 10MB.');
                return;
            }

            // Show preview immediately
            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                contentDiv.style.display = 'none';
                previewDiv.style.display = 'flex';
            };
            reader.readAsDataURL(file);

            // Upload via AJAX
            var formData = new FormData();
            formData.append('file', file);
            formData.append(csrfName, csrfHash);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', uploadUrl, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            // Progress
            progressWrap.style.display = 'block';
            progressBar.style.width = '0%';
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    progressBar.style.width = Math.round((e.loaded / e.total) * 100) + '%';
                }
            });

            xhr.onload = function() {
                progressWrap.style.display = 'none';
                try {
                    var resp = JSON.parse(xhr.responseText);
                    if (resp.success) {
                        hiddenInput.value = resp.filename;
                        previewImg.src = resp.url;
                        // Update CSRF token for next request
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