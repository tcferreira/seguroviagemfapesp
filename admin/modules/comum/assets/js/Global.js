/** Função responsável por abrir uma notificação no sistema */
function openNotification(params)
{
    toastr.options = {
        "closeButton": false,
        "newestOnTop": false,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "timeOut": (params.timeout != undefined) ? params.timeout : 5000,
    }

    console.log('Notification', params);
    if ( params.type == "success" ) {
        toastr.success(params.text, params.title);
    } else if (params.type == "warning") {
        toastr.warning(params.text, params.title);
    } else if (params.type == "error") {
        toastr.error(params.text, params.title);
    } else {
        toastr.info(params.text, params.title);
    }
}

/** Função responsável por enviar todos os formulários através de requisições ajax */
function sendForm(formulario) {
    var send = true;
    if (files !== undefined && files.length > 0){
        $.each(files, function (index, value) {
            if (value.textStatus === undefined || value.textStatus !== 'success') {
                send = false;
            }
        });
    }

    if (send){
        var $btn = $(formulario).find('[type="submit"]'),
            btnPreSave = $btn.data('original');
        $btn.focus();
        $(':focus').trigger('blur');
        if( typeof(CKEDITOR) !== "undefined" ) {
            for (var i in CKEDITOR.instances) {
                CKEDITOR.instances[i].updateElement();
            }
        }

        if (typeof (tinyMCE) !== "undefined") {
            tinyMCE.triggerSave();
        }

        /* Usa FormData para suportar envio de arquivos via AJAX */
        var formData = new FormData($(formulario)[0]);

        $.ajax({
            type: "POST",
            url: $(formulario).attr('action'),
            data: formData,
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(data) {
                var msg = (data.redirect) ? data.message + ' '+i18n.clique+' <a href="'+site_url + data.redirectModule+'">'+i18n.aqui+'</a> '+i18n.ir_listagem : data.message,
                    obj = { layout: 'top', title:'', text: msg, type: data.classe };
                openNotification(obj);

                if (data.status) {
                    if (data.redirect){
                        $btn.html(i18n.redirecionando).removeClass('loading btn-primary').addClass('btn-success btn-stroke');
                        setTimeout(function(){
                            window.location = site_url + data.redirectModule;
                        }, 2000);
                    } else{
                        setTimeout(function(){
                            $(formulario).removeClass('sending').data('sending',false);
                            $btn.html(btnPreSave).removeClass('btn-success btn-stroke').addClass('btn-primary').removeAttr('disabled');
                        }, 2000);
                    }
                } else{
                    $.each(files, function (index) {
                        files[index].abort();
                        files[index].textStatus = '';
                    });
                    $(formulario).removeClass('sending').data('sending',false);
                    $btn.html(btnPreSave).removeClass('loading').removeAttr('disabled');
                }
            },
            error: function(data) {
                $(formulario).removeClass('sending').data('sending', false);
                $btn.html(btnPreSave).removeClass('loading').removeAttr('disabled');
            }
        });
    }
}

function sendFormError(elemento, list) {
    elemento.currentElements.parents('label:first, div:first').find('.has-error').remove();
    elemento.currentElements.parents('.form-group:first').removeClass('has-error');
    elemento.currentElements.removeClass('is-invalid');
    // elemento.currentElements.addClass('is-valid');

    $.each(list, function(index, error)
    {
        var ee = $(error.element);
        var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

        ee.addClass('is-invalid')
        ee.parents('.form-group:first').addClass('has-error');
        eep.find('.has-error').remove();
        eep.append('<p class="invalid-feedback has-error help-block">' + error.message + '</p>');
    });
}

$(window).on('load', function () {
    updateCKEditor();
});


function updateCKEditor(editor){
    if (typeof CKEDITOR !== 'undefined'){
        if (editor === undefined){
            for (var i in CKEDITOR.instances) {
                updateCKEditorIndividual(CKEDITOR.instances[i]);
            }
        }else{
            updateCKEditorIndividual(editor);
        }
    }
}

function updateCKEditorIndividual(editor){
    editor.on('resize', function(){
        $('.layout-app .hasNiceScroll').getNiceScroll().resize();
    });
    editor.on('change', function() {
        this.updateElement();
    });
    editor.on('blur', function() {
        this.updateElement();
    });
}

function add_loading(){
    $("#fast-loading").addClass("show");
}

function remove_loading() {
    $("#fast-loading").removeClass("show");
}

function formatZipCode(theField) {
    var num = theField.replace(/[^\d]+/g, '');
    if (num.length == 8) {
        theField = num.substr(0, 5) + "-" + num.substr(5);
    }

    return theField
}

function camelize(str) {
    return str
        .replace(/\s(.)/g, function ($1) {
            return $1.toUpperCase();
        })
        .replace(/\s/g, '')
        .replace(/^(.)/, function ($1) {
            return $1.toLowerCase();
        });
}

/** Função responsável por adicionar o conteúdo csrf nas requisições ajax */
$.ajaxPrefilter(function (options, originalOptions) {
    console.log('AjaxPrefilter', options, originalOptions);
    if (typeof options.data == "undefined" || options.data == null) {
        options.data = '';
    }

    if (options.type.toUpperCase() === 'POST') {
        if (typeof options.data == 'string') {
            options.data += '&' + site_name + "=" + csrf_test_name;
        } else {
            options.data[site_name] = csrf_test_name;
        }
        if (options.data instanceof FormData) {
            options.data.append(site_name, csrf_test_name);
        }
    }
});

function imgError(image) {
    image.onerror = "";
    image.src = base_img + "/no-img.png";
    return true;
}

function animateElement(element, class_animation, time, interval = 1000) {
    let elapsed_time = 0;

    let animation_interval = setInterval(() => {
        if (elapsed_time >= time) {
            clearInterval(animation_interval);
            $(element).removeClass(class_animation);
        } else {
            $(element).toggleClass(class_animation);
            elapsed_time += interval;
        }
    }, interval);
}

function slugify(text) {
    return text.toLowerCase()
        .replace(/[^\w\s-]/g, '') // Remove caracteres especiais
        .replace(/\s+/g, '-') // Substitui espaços em branco por hífens
        .replace(/-\+/g, '') // Remove hífens seguidos
        .trim(); // Remove espaços em branco no início e no fim
}

function formatarCpfCnpj(cpfCnpj) {
    // Remove todos os caracteres não numéricos
    cpfCnpj = cpfCnpj.replace(/\D/g, '');

    if (cpfCnpj.length === 11) { // Se o tamanho for 11, é um CPF
        return cpfCnpj.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (cpfCnpj.length === 14) { // Se o tamanho for 14, é um CNPJ
        return cpfCnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    } else {
        // Se o tamanho não for válido para CPF nem CNPJ, retorna o valor original
        return cpfCnpj;
    }
}
