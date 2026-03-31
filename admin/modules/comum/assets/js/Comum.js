(function (window) {

    var Comum = function () {
        this.basePath = '';
        this.commonPath = '../assets/';
        this.rootPath = '../';
        this.DEV = false;
        this.componentsPath = '../assets/components/';
        this.layoutApp = false;
        this.module = module_slug;

        this.primaryColor = '#26b974';
        this.dangerColor = '#f62d51';
        this.successColor = '#36bea6';
        this.infoColor = '#2962FF';
        this.warningColor = '#ffbc34';
        this.inverseColor = '#424242';

        this.themerPrimaryColor = this.primaryColor;

        if (Url.host == 'localhost' || /192\.168\.1/.test(Url.host)) {
            localStorage.debug = true;
        } else {
            delete localStorage.debug;
        }

        
        // set autocomplete off
        $('input').attr('autocomplete', 'off');


        console.log('Comum is started...');

        console.log(
            `%cOlá,`,
            `color: #2ecc71; font-weight: bold; font-size: 1.5rem; text-shadow: 0 0 5px rgba(0,0,0,0.2);`
        );

        console.log(
            `%cNós acreditamos que a tecnologia está mudando o mundo! \nMais do que isso, acreditamos que a tecnologia existe para servir as pessoas.\n\nNosso objetivo é tornar mais fácil a vida das pessoas, a sua vida.\n\nA gente acredita que a tecnologia pode melhorar o mundo - e faz isso acontecer - um projeto de cada vez.`,
            `color: #f7f7f7; font-weight: bold; font-size: 1rem; text-shadow: 0 0 5px rgba(0,0,0,0.2);`
        );

        console.log(
            `%cNós somos a FCode!`,
            `color: #2ecc71; font-weight: bold; font-size: 1rem; text-shadow: 0 0 5px rgba(0,0,0,0.2);`
        );
        console.log(
            `%c@fcode.digital`,
            `color: #2ecc71; font-weight: bold; font-size: .8rem; text-shadow: 0 0 5px rgba(0,0,0,0.2);`
        );

        console.clear();


        return this.__constructor();
    };


    Comum.prototype.__constructor = function () {
        var self = this;
        // this.sidebarMenu();
        // this.translateValidate();
        this.filter();
        this.formFilter();
        this.pagination();
        this.notify();
        this.profiler();
        this.select2();
        this.Switch();
        this.setMask();
        
        this.validateSubmitForm();
        this.deleteRegisters();
        // this.magnific();
        this.hiddenOnlyOneTab();
        this.tooltipButtons();
        // this.changeThemeMode();

        $('#preloader').fadeOut('slow');
        $('#postLoad').addClass('loaded').removeAttr('style');
        $('#main-wrapper').addClass('show');

        $("body").on('click', ".btn-expand", function () {
            $(this).parent().parent().find('.expand').toggleClass('show');
            $(this).toggleClass('rotate');
        })

        return this;
    };

    Comum.prototype.buscaCnpj = function () {
        var self = this;
        self.buscaEndereco();

        $("body").on("change", "#inputCNPJ", function () {
            var el = $(this);
            var numero_cnpj = el.val();

            if (numero_cnpj.length < 14) {
                $("#inputNome").val('');
                $("#inputSobrenome").val('');
                $("#inputCEP").val('');
                $("#inputNumero").val('');
                $("#inputComplemento").val('');
                $("#inputTelefone").val('');
                $("#inputEmail").val('');

                return;
            }

            add_loading();
            $.ajax({
                method: "GET",
                url: "https://www.receitaws.com.br/v1/cnpj/" + numero_cnpj.replace(/[^\d]+/g, ''),
                data: {
                    format: "json",
                },
                headers: {
                    "Authorization": "Bearer" + receitaws_key
                },
                dataType: 'jsonp',
            })
                .done(function (dados) {
                    $("#inputNome").val(dados.fantasia ? dados.fantasia : dados.nome);
                    console.log($("#inputNome"), dados);
                    $("#inputSobrenome").val(dados.nome ? dados.nome : '');
                    $("#inputCEP").val(dados.cep ? formatZipCode(dados.cep) : '').trigger('change');

                    $("#inputNumero").val(dados.numero ? dados.numero : '');
                    $("#inputComplemento").val(dados.complemento ? dados.complemento : '');

                    $("#inputTelefone").val(dados.telefone ? dados.telefone : '');
                    $("#inputEmail").val(dados.email ? dados.email : '');

                    remove_loading();
                })
                .fail(function () {
                    $("#inputNome").val('');
                    $("#inputSobrenome").val('');
                    $("#inputCEP").val('').trigger('change');

                    remove_loading();
                });
        });
    }

    Comum.prototype.changeThemeMode = function () {
        var self = this;
        $('.dz-theme-mode').on('click', function () {
            //false vai pra dark, true vai pra light
            var theme = '';
            if ($(this).hasClass('active')) {
                theme = 'light';
            } else {
                theme = 'dark';
            }

            localStorage.setItem('valorama_theme', theme);
        });
    };


    Comum.prototype.tooltipButtons = function () {
        $('button, a, .has-tooltip').not('.no-tooltip').each(function (idx, el) {
            var element = $(el)
            var title = $(element).attr('title')
            var placement = $(element).data('placement') || 'auto'

            if (!_.isUndefined(title) && !_.isEmpty(title))
                $(element).tooltip({
                    title: title,
                    placement: placement
                })
        });
    }

    Comum.prototype.hiddenOnlyOneTab = function () {
        //Se tem somente uma tab esconde ela
        $('.nav').each(function (i, el) {
            if ($(el).find('li > a').length <= 1)
                $(el).addClass('hidden').hide();

        });
    }

    Comum.prototype.magnific = function (getClass) {
        var mfpOpen = true;

        getClass = getClass ? getClass : $('.magnific').parent();

        getClass.each(function (index, el) {
            $(this).magnificPopup({
                delegate: '.magnific',
                type: 'image',
                tClose: '',
                mainClass: 'mfp-fade',
                removalDelay: 300,
                disableOn: function () {
                    return mfpOpen;
                }
            });
        });
    };

    Comum.prototype.upload = function (options) {

        var self = this;
        //Configura o file upload
        var defaults = {
            formData: {
                id: undefined,
                gallerypath: 'userfiles/' + self.module,
                gallerytype: 'image',
                gallerytable: self.module,
                width: 2000,
                height: 2000,
                resize: true,
            },
            dataType: 'json',
            autoUpload: false,
            maxNumberOfFiles: 2,
            previewMaxWidth: 75,
            previewMaxHeight: 75,
            previewCrop: true,
            add: function(e, data) {
                var $input = $(this);
                var file = data.files[0];
                function proceed() {
                    data.process(function() {
                        return $input.fileupload('process', data);
                    });
                }
                if (file && /\.(heic|heif)$/i.test(file.name)) {
                    if (typeof heic2any !== 'undefined') {
                        heic2any({ blob: file, toType: 'image/jpeg', quality: 0.92 })
                            .then(function(convBlob) {
                                var newName = file.name.replace(/\.(heic|heif)$/i, '.jpg');
                                data.files[0] = new File([convBlob], newName, { type: 'image/jpeg' });
                                proceed();
                            })
                            .catch(function(err) {
                                console.error('Erro na conversão HEIC:', err);
                                openNotification({layout:'top', text:'Erro ao converter imagem do iPhone (HEIC). Tente converter para JPG antes de enviar.', type:'error'});
                            });
                    } else {
                        openNotification({layout:'top', text:'Formato HEIC não suportado. Converta para JPG antes de enviar.', type:'error'});
                    }
                } else {
                    proceed();
                }
            },
            processalways: function (e, dataFiles) {
                /*Executa o processalways sempre após ser realizada a seleção de uma imagem.
                 *essa função é responsável por validar a extensão do arquivo, por inserir um preview
                 *e por inserir os arquivos em um array que será utilizado mais tarde. */
                var uploadFile = dataFiles.files[0],
                    wrapper = $(this).closest('.upload-wrapper');

                //Valida se não é um arquivo PHP, HTML ou JS
                if ((/\.(php|html|js)$/i).test(uploadFile.name)) {
                    var obj = {
                        layout: 'top',
                        text: i18n.o_arquivo + " \'" + uploadFile.name + "\' " + i18n.arquivo_nao_enviado + "\n PHP, HTML.",
                        type: 'error'
                    };
                    openNotification(obj);
                    return false;
                }

                //Verifica se o arquivo possui uma extensão, caso não possua emite uma notificação.
                if (typeof dataFiles.ext !== 'undefined') {
                    if (dataFiles.ext[0] == '!') {
                        var patt = new RegExp(dataFiles.ext.replace('!', ''));
                        if (patt.test(uploadFile.name)) {
                            var obj = {
                                layout: 'top',
                                text: i18n.o_arquivo + " \'" + uploadFile.name + "\' " + i18n.arquivo_nao_enviado_extensao,
                                type: 'error'
                            };
                            openNotification(obj);
                            return false;
                        }
                    } else {
                        var patt = new RegExp(dataFiles.ext);
                        if (!patt.test(uploadFile.name.toLowerCase())) {
                            var ext = dataFiles.ext.replace(/\|/g, ', ').toUpperCase(),
                                obj = {
                                    layout: 'top',
                                    text: i18n.o_arquivo + " \'" + uploadFile.name + "\' " + i18n.arquivo_nao_enviado + ' ' + ext,
                                    type: 'error'
                                };
                            openNotification(obj);
                            return false;
                        }
                    }
                }

                dataFiles.divId = $(this).attr('name');
                $.each(files, function (k, v) {
                    if (dataFiles.divId == v.divId) {
                        files.splice(k, 1);
                        return false;
                    }
                });

                //Insere o botão de deletar e o checkbox de deletar
                wrapper.find('.remove-image, .remove-archive').removeClass('hide');
                wrapper.find('input[type="checkbox"]').prop("checked", false);

                //Insere o preview da imagem ou do arquivo
                if (dataFiles.imgtype == 'archive') {
                    wrapper.find('.download-archive').remove();
                    wrapper.find('.archivePlaceholder').removeClass('pointer').html(dataFiles.files[0].name).attr('title', dataFiles.files[0].name);
                } else {
                    wrapper.find('.' + dataFiles.imgtype).html(dataFiles.files[0].preview);
                    wrapper.find('a.magnific').removeClass('magnific').prop('href', '#');
                }

                //Insere os arquivos no array files
                files.push(dataFiles);
            },
            done: function (e, dataFiles) {
                /*Executa o done sempre no momento em que o formulário for enviado (submit) */

                //Adiciona um status que será validado no sendForm, com a string success
                $.each(files, function (index, value) {
                    if (value.divId == dataFiles.divId) {
                        value.textStatus = dataFiles.textStatus;
                        return false;
                    }
                });

                /*Adiciona um campo hidden com o nome da imagem que retorna no JSON. Chamada para gallery/upload/image
                 * JSON: {
                 *    "status":true,
                 *    "classe":"success",
                 *    "message":"Imagem enviada com sucesso!",
                 *    "image":"captura-de-tela-2019-07-23-as-163742-3.png"
                 *   }
                 * */
                if (dataFiles.jqXHR.responseJSON.status)
                    $('#validateSubmitForm').append('<input type="hidden" name="' + dataFiles.paramName + '" value="' + dataFiles.jqXHR.responseJSON.image + '" />');

                //Enviar o formulário
                sendForm($('#validateSubmitForm'));
            }
        },
            //Junta o array de defaults com o que vem no parâmetro dessa função
            options = $.extend(true, defaults, options);

        $(document).ready(function () {
            if ($('.fileuploadImage').length > 0) {
                //Passa pelos campos fileUpload e insere no objeto de form as informações necessárias,
                //inicializa o fileupload com os options
                $('.fileuploadImage').each(function (e) {
                    options.formData.width = $(this).closest('.upload-wrapper').data('width');
                    options.formData.height = $(this).closest('.upload-wrapper').data('height');
                    options.formData.resize = $(this).closest('.upload-wrapper').data('resize');
                    options.formData.gallerytype = 'image';
                    options.formData.gallerypath = $(this).closest('.upload-wrapper').data('gallerypath');
                    options.formData.id = $(this).attr('id');

                    $(this).fileupload(options);
                });
            }

            //Faz o mesmo processo para arquivos
            if ($('.fileuploadArchive').length > 0) {
                options.formData.gallerytype = 'archive';
                options.formData.gallerypath = $(this).closest('.upload-wrapper').data('gallerypath');
                options.formData.id = $(this).attr('id');
                $('.fileuploadArchive').fileupload(options);
            }

            //Caso não seja específico de imagem ou aruqivo, somente inicia o fileupload.
            if ($('.fileupload').length > 0) {
                options.formData.id = $(this).attr('id');
                options.formData.gallerypath = $(this).closest('.upload-wrapper').data('gallerypath');
                $('.fileupload').fileupload(options);
            }
        });

        //Faz com que a caixa de upload não abra quando temos o magnific na imagem
        $('body').off('click', '.upload-image');
        $('body').on('click', '.upload-image', function (e) {
            if (!$(this).hasClass('magnific')) {
                $(this).siblings('.fileuploadImage').trigger('click');
            }
        });

        this.removeImage();

        $('.archivePlaceholder').off('click');
        $('.archivePlaceholder').click(function () {
            $(this).closest('.upload-wrapper').find('label.alinhamento').trigger('click');
        });

        if ($('.upload-archive .remove-archive').length > 0) {
            $('.upload-archive .remove-archive').off('click');
            $('.upload-archive .remove-archive').on('click', function (e) {
                e.stopPropagation();
                e.preventDefault();

                var wrapper = $(this).closest('.upload-archive'),
                    id = wrapper.find('input[type="file"]').attr('name');

                $.each(files, function (k, v) {
                    if (id == v.divId) {
                        files.splice(k, 1);
                        return false;
                    }
                });

                $(this).addClass('hide');
                wrapper.find('input[type="checkbox"]').prop("checked", true);
                wrapper.find('.download-archive').remove();

                wrapper.find('.archivePlaceholder').addClass('pointer').html(i18n.selecione_arquivo).attr('title', i18n.selecione_arquivo);
            });
        };
    };

    Comum.prototype.cropImage = function () {
        var imgCrop = false;
        $('.crop-image').on('click', function (e) {
            var timestamp = new Date().getTime(),
                el = this,
                img = $(this).data('imagesite'),
                id = $(this).closest('.template-upload').data('id');

            $('#modal-crop').prop('data-id', id);
            $('#modal-crop .image-crop-holder').addClass('loading');
            $('<img/>', {
                src: site_url + img + '?' + timestamp
            }).load(function () {
                var image = $(this);
                image.addClass('img-responsive');
                $('#modal-crop .image-crop-holder').append(image);
                setTimeout(function () {
                    $('#modal-crop .image-crop-holder').removeClass('loading');
                    setTimeout(function () {
                        var w = image.width(),
                            h = image.height();
                        $('#modal-crop').find('input[name="image"]').val(img);
                        $('#modal-crop').find('input[name="image_width"]').val(w);
                        $('#modal-crop').find('input[name="image_height"]').val(h);
                        $('#modal-crop').find('.submit').removeAttr('disabled');
                        image.Jcrop({
                            onChange: updatePreview,
                            onSelect: updatePreview,
                        }, function () {
                            imgCrop = this;
                            imgCrop.setOptions({ bgFade: true });
                            imgCrop.setSelect([w / 4, h / 4, (w / 4) + (w / 2), (h / 4) + (h / 2)]);
                            imgCrop.ui.selection.addClass('jcrop-selection');
                        });
                    }, 500);
                }, 50);
            });
        });

        $('#modal-crop').on('hidden.bs.modal', function (e) {
            if (imgCrop != false)
                imgCrop.destroy();
            $('#modal-crop .image-crop-holder img').remove();
            $('#modal-crop').find('input[type="hidden"]').val('');
            $('#modal-crop').find('.submit').attr('disabled', 'disabled');
        });

        $('#modal-crop').on('click', '.crop-cancel', function (e) {
            e.preventDefault();
            $('#modal-crop .close').trigger('click');
        });

        function updatePreview(c) {
            $('#modal-crop').find('input[name="crop_x"]').val(c.x);
            $('#modal-crop').find('input[name="crop_y"]').val(c.y);
            $('#modal-crop').find('input[name="crop_width"]').val(c.w);
            $('#modal-crop').find('input[name="crop_height"]').val(c.h);
        }

        $("body").on('click', '#modal-crop form button.submit', function () {
            var form = $('#modal-crop form');
            $(form).find('.submit').attr('disabled', 'disabled').html('<i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>').addClass('loading');
            $.ajax({
                type: "POST",
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: "json",
                complete: function () {
                    $(form).find('.submit').removeAttr('disabled').html(i18n.recortar).removeClass('loading');
                },
                success: function (data) {
                    var obj = {
                        layout: 'top',
                        text: data.message,
                        type: data.classe
                    };
                    openNotification(obj);

                    if (data.status) {
                        // Atualiza thumb
                        var timestamp = new Date().getTime();
                        $('.imageOlds .template-upload[data-id="' + $('#modal-crop').prop('data-id') + '"] .preview img').attr('src', data.image + "&" + timestamp);
                        $('.imageOlds .template-upload[data-id="' + $('#modal-crop').prop('data-id') + '"] .config-file-close').trigger('click');
                        $('#modal-crop .close').trigger('click');
                    }

                }
            });
        });
    };

    Comum.prototype.removeImage = function () {
        //Adiciona ação de clique no botão de remover a imagem
        $('body').on('click', '.remove-image', function (e) {
            e.stopPropagation();
            e.preventDefault();

            var wrapper = $(this).closest('.upload-wrapper'),
                id = wrapper.find('input[type="file"]').attr('name');

            $.each(files, function (k, v) {
                if (id == v.divId) {
                    files.splice(k, 1);
                    return false;
                }
            });

            wrapper.find('a.magnific').removeClass('magnific').prop('href', '#');
            wrapper.find('.remove-image').addClass('hide');
            wrapper.find('input[type="checkbox"]').prop("checked", true);

            wrapper.find('.upload-image').html('<span>' + wrapper.find('.upload-image').data('dim') + '</span>');
        });

    }

    /**
     * Função responsável pelo botão de deletar nas listagens. Exibe uma confirmação e chama o delete do MY_Controller
     */
    Comum.prototype.deleteRegisters = function () {
        $('body').off('click', '.delete-button');
        $('body').on('click', '.delete-button', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var url = $(this).attr('href'),
                $table = $(this).closest('table'),
                self = $(this);
            bootbox.confirm({
                title: "Confirme a exclusão",
                message: i18n.efetuar_exclusao + '<br/><br/><i>' + i18n.efetuar_exclusao_alerta + '</i>',
                centerVertical: true,
                buttons: {
                    confirm: {
                        label: i18n.efetuar_exclusao_sim,
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: i18n.efetuar_exclusao_nao,
                        className: 'btn-secondary'
                    }
                },

                callback: function (result) {
                    if (result) {
                        if (self.hasClass('no-ajax')) {
                            window.location = url;
                        } else {
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    'delete': 'true'
                                },
                                dataType: "json",
                                success: function (data) {
                                    var obj = {
                                        layout: 'top',
                                        text: data.message,
                                        type: data.classe
                                    };
                                    openNotification(obj);
                                    if (data.status && data.classe == 'success') {
                                        var id = url.split('/').pop();
                                        $table.find('tr[data-id="' + id + '"]').css('position', 'relative').fadeOut(1000, function () {
                                            $(this).remove();
                                            if ($table.find('tr.selectable .checkbox :checked').length > 0)
                                                $table.nextAll('.row:eq(0)').find('.checkboxs_actions').removeClass('hide').show();
                                            else
                                                $table.nextAll('.row:eq(0)').find('.checkboxs_actions').hide();
                                        });
                                    }
                                },
                                error: function (data) {
                                    var obj = {
                                        layout: 'top',
                                        text: i18n.verifique_relacionamento,
                                        type: 'error'
                                    };
                                    openNotification(obj);
                                }
                            });
                        }
                    }
                }
            });
        });
    };

    Comum.prototype.sidebarMenu = function () {
        $(document).ready(function () {

            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                // open or close navbar
                $('#sidebar').toggleClass('active');
                // close dropdowns
                $('.collapse.in').toggleClass('in');
                // and also adjust aria-expanded attributes we use for the open/closed arrows
                // in our CSS
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

        });
    }

    Comum.prototype.respondeUser = function (response) {
        remove_loading();

        if (response.errors) {
            $.each(response.errors, function (key, value) {
                openNotification({
                    layout: 'top',
                    text: value,
                    type: 'error'
                });
            });

            return;
        }

        // se tiver response.title
        swal({
            title: response.title ? response.title : response.message,
            text: response.title ? response.message : false,
            icon: response.icon ? response.icon : (response.status ? "success" : "error"),
        }).then(() => {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        });
    };

    Comum.prototype.translateValidate = function () {
        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo &eacute; obrigat&oacute;rio.",
            remote: "Por favor, corrija este campo.",
            email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
            url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
            date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
            dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
            number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
            digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
            creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
            equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
            accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
            maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
            minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
            rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
            range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
            max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
            min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
        });
    }

    Comum.prototype.setMask = function () {
        if ($('[data-fmask="date"]').length > 0)
            $('[data-fmask="date"]').mask('00/00/0000');

        if ($('[data-fmask="credit_card"]').length > 0)
            $('[data-fmask="credit_card"]').mask('0000 0000 0000 0000');

        if ($('[data-fmask="expiration"]').length > 0)
            $('[data-fmask="expiration"]').mask('00/00');

        if ($('[data-fmask="time"]').length > 0)
            $('[data-fmask="time"]').mask('00:00:00');

        if ($('[data-fmask="date_time"]').length > 0)
            $('[data-fmask="date_time"]').mask('00/00/0000 00:00:00');

        if ($('[data-fmask="cep"]').length > 0)
            $('[data-fmask="cep"]').mask('00000-000');

        if ($('[data-fmask="money"]').length > 0)
            $('[data-fmask="money"]').maskMoney({
                prefix: 'R$ ',
                allowNegative: false, // permite negativo
                thousands: '.',
                decimal: ',',
                affixesStay: true, // mantem o prefixo e sufixo ao perder o foco
                allowZero: true
            });

        //percent mask
        if ($('[data-fmask="percent"]').length > 0)
            $('[data-fmask="percent"]').mask('000.00%', { reverse: true });

        if ($('[data-fmask="phone"]').length > 0) {
            var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
                spOptions = {
                    onKeyPress: function (val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

            $('[data-fmask="phone"]').mask(SPMaskBehavior, spOptions);
        }

        if ($('[data-fmask="cpf"]').length > 0)
            $('[data-fmask="cpf"]').mask('000.000.000-00', {
                reverse: true,
                clearIfNotMatch: false,
            });

        if ($('[data-fmask="cnpj"]').length > 0)
            $('[data-fmask="cnpj"]').mask('00.000.000/0000-00', {
                reverse: true,
                clearIfNotMatch: false
            });

        if ($('[data-fmask="hour"]').length > 0)
            $('[data-fmask="hour"]').mask('00:00');

        if ($('[data-fmask="placa-carro"]').length > 0)
            $('[data-fmask="placa-carro"]').mask('AAA 0U00', {
                translation: {
                    'A': {
                        pattern: /[A-Za-z]/
                    },
                    'U': {
                        pattern: /[A-Ja-j0-9]/
                    },
                },
                placeholder: "___ ____",
                onKeyPress: function (value, e, field, options) {
                    // Convert to uppercase
                    e.currentTarget.value = value.toUpperCase();

                    // Get only valid characters
                    let val = value.replace(/[^\w]/g, '');

                    // Detect plate format
                    let isNumeric = !isNaN(parseFloat(val[4])) && isFinite(val[4]);
                    let mask = 'AAA 0U00';
                    if (val.length > 4 && isNumeric) {
                        mask = 'AAA 0000';
                    }
                    $(field).mask(mask, options);
                }
            });
    }

        Comum.prototype.profiler = function () {
            $('#codeigniter_profiler').css('padding', '').addClass('menu-on');
        };

        Comum.prototype.formFilter = function () {
            if ($('#form_filter').length > 0) {
                $('#form_filter').on('submit', function () {
                    var $btn = $(this).find('[type="submit"].btn-primary');
                    if ($btn.length) {
                        $btn.attr('disabled', 'disabled').html('<i class="fas fa-spinner"></i>').addClass('loading');
                    }
                })
            }
        };

        Comum.prototype.validateSubmitForm = function () {
            if ($('#validateSubmitForm').length > 0) {
                $.validator.setDefaults({
                    submitHandler: function (form) {
                        if ($(form).data('sending') === true || $(form).hasClass('sending'))
                            return false;

                        $(form).addClass('sending').data('sending', true);

                        var $btn = $(form).find('[type="submit"]');
                        $btn.data('original', $btn.html());
                        $btn.attr('disabled', 'disabled').html('<i class="fas fa-spinner"></i>').addClass('loading');

                        if ($('.required-image').length > 0) {
                            // Verifica imagens obrigatórias
                            if ($('form').find($('.required-image')).find($('.img-holder')).length > 0) {
                                var obj = { layout: 'top', text: i18n.campos_obrigatorios, type: 'error' };
                                openNotification(obj);
                                $(form).data('sending', false);
                                $btn.html($btn.data('original')).removeClass('btn-success btn-stroke').addClass('btn-primary').removeAttr('disabled');
                            } else {
                                $.each(files, function (index, value) {
                                    value.submit();
                                });
                                sendForm(form);
                            }
                        } else {
                            if (files.length > 0) {
                                // Envia Imagens
                                $.each(files, function (index, value) {
                                    value.submit();
                                });
                            }
                            sendForm(form);
                        }
                    },
                    showErrors: function (map, list) {
                        sendFormError(this, list);
                    }
                });
                $("#validateSubmitForm").validate({
                    rules: '',
                    ignore: [],
                    invalidHandler: function (event, validator) {
                        var errors = validator.numberOfInvalids();

                        if (errors) {
                            for (var i = 0; i < validator.errorList.length; i++) {
                                var message = validator.errorList[i].message;
                                var element = validator.errorList[i].element;

                                var obj = {
                                    layout: 'top',
                                    text: message + " - " + $(element).attr('placeholder'),
                                    type: 'error'
                                };
                                openNotification(obj);
                            }
                        }
                    }
                });
            }
        };

        Comum.prototype.selectize = function (create) {
            if (create == null)
                create = false;

            if ($('select.selectize, input.selectize').length > 0) {
                $('select.selectize, input.selectize').selectize({
                    allowEmptyOption: true,
                    create: create,
                    // sortField: {
                    //     field: 'text',
                    //     direction: 'asc'
                    // },
                    dropdownParent: 'body',
                    onDropdownOpen: function ($dropdown) {
                        // this.$input.get(0).selectize.clear(true);
                    }
                });
            }
        }

        Comum.prototype.select2 = function (create_tag) {
            if (create_tag == null)
                create_tag = false;

            if ($('select.select2').length > 0) {
                $('select.select2').select2({
                    width: '100%',
                    theme: "bootstrap4",
                    tags: create_tag,
                });

                // $(body).on('select2:open', 'select.select2', () => {
                //     document.querySelector('.select2-search__field').focus();
                // });
            }
        };

        Comum.prototype.selectpicker = function () {
            if ($('.selectpicker').length > 0)
                $('.selectpicker').selectpicker();
        };

        Comum.prototype.controllCollapse = function () {
            $('body').on('click', `[data-toggle="collapse"]:not(.noControlCollapse)`, function (e) {
                let $this = $(this);
                let content = $this.closest('.controll-collapse');

                let collapse = content.find('.collapse');
                if (collapse.length) {
                    collapse.collapse('hide');
                }
            });
        };

        Comum.prototype.Switch = function (pElement, size = 'default', pCallbackChange) {
            element = (typeof pElement !== "undefined") ? pElement : $('[data-toggle="switch"]');

            let _size = '';

            let _size_el = element.data("size");

            if (typeof _size_el !== "undefined") {
                _size = _size_el;
            } else {
                _size = size;
            }


            var options = {
                size: _size,
                checked: undefined,
                onText: 'Sim',
                offText: 'Não',
                onSwitchColor: this.primaryColor,
                offSwitchColor: this.dangerColor,
                onJackColor: '#fff',
                offJackColor: '#fff',
                showText: false,
                onInit: function () { },
                beforeChange: function () { },
                onChange: pCallbackChange ? pCallbackChange : function () { },
                beforeRemove: function () { },
                onRemove: function () { },
                beforeDestroy: function () { },
                onDestroy: function () { }
            };

            if (element.length > 0) {
                element.each(function (a, el) {
                    options.checked = $(el).prop('checked');
                    var newswitch = new Switch(el, options);
                });
            }
        };

        Comum.prototype.tinymce = function () {
            if ($("textarea.tinymce").length > 0) {
                $("textarea.tinymce").each(function (index, value) {
                    let element = $(value);

                    // se ja tiver sido inicializado, ele destroi e inicializa novamente
                    // if (tinymce.get(element.attr('id'))) {
                    //     tinymce.get(element.attr('id')).destroy();
                    // }

                    let height = element.attr('rows') ? (parseInt(element.attr('rows')) * 100) : 400;

                    tinymce.init({
                        content_css_cors: true,
                        selector: 'textarea.tinymce',
                        width: '100%',
                        language: 'pt_BR',
                        branding: false,
                        menubar: 'edit insert format table tools',
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code",
                        // se tiver rows no textarea, ele pega o valor e seta como min_height
                        min_height: height,
                        plugins: [
                            "autolink lists link image code",
                            "insertdatetime media table contextmenu paste imagetools wordcount",
                            // corretor ortografico
                            "spellchecker"
                        ],
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: true,
                        paste_auto_cleanup_on_paste: true,
                        paste_remove_styles: true,
                        paste_remove_styles_if_webkit: true,
                        paste_strip_class_attributes: "all",

                        forced_root_block: false,
                        force_br_newlines: true, // tried with and without
                        force_p_newlines: true,
                        // images_upload_url: site_url + 'gallery/upload_tinymce',
                        // automatic_uploads: false,
                        images_upload_handler: function (blobInfo, success, failure) {
                            var xhr, formData;

                            xhr = new XMLHttpRequest();
                            xhr.withCredentials = false;
                            xhr.open('POST', site_url + 'gallery/upload_tinymce');

                            xhr.onload = function () {
                                var json;

                                if (xhr.status != 200) {
                                    failure('HTTP Error: ' + xhr.status);
                                    return;
                                }

                                json = JSON.parse(xhr.responseText);

                                if (!json || typeof json.location != 'string') {
                                    failure('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }

                                success(json.location);
                            };

                            formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());
                            formData.append(site_name, csrf_test_name);

                            xhr.send(formData);
                        },
                        content_css: [
                            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                            '//www.tiny.cloud/css/codepen.min.css',
                            '//cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/5.4.1-89/skins/ui/material-classic/skin.min.css'
                        ],
                        formats: {
                            borderstyle: {
                                selector: 'td,th',
                                styles: {
                                    borderTopStyle: 'solid',
                                    borderRightStyle: 'solid',
                                    borderBottomStyle: 'solid',
                                    borderLeftStyle: 'solid',
                                },
                                remove_similar: true
                            },
                            bordercolor: {
                                selector: 'td,th',
                                styles: {
                                    borderTopColor: '#32CD32',
                                    borderRightColor: '#32CD32',
                                    borderBottomColor: '#32CD32',
                                    borderLeftColor: '#32CD32'
                                },
                                remove_similar: true
                            },
                            backgroundcolor: {
                                selector: 'td,th',
                                styles: { backgroundColor: '#006400' },
                                remove_similar: true
                            },
                            formatpainter_removeformat: [
                                {
                                    selector: 'b,strong,em,i,font,u,strike,sub,sup,dfn,code,samp,kbd,var,cite,mark,q,del,ins',
                                    remove: 'all',
                                    split: true,
                                    expand: false,
                                    block_expand: true,
                                    deep: true
                                },
                                {
                                    selector: 'span',
                                    attributes: ['style', 'class'],
                                    remove: 'empty',
                                    split: true,
                                    expand: false,
                                    deep: true
                                },
                                {
                                    selector: '*:not(tr,td,th,table)',
                                    attributes: ['style', 'class'],
                                    split: false,
                                    expand: false,
                                    deep: true
                                }
                            ]
                        },
                        setup: function (ed) {
                            ed.on('keyup', function (e) {
                                let content = ed.getContent();
                                element.val(content);
                            });
                        }
                    });
                });
            }
        };

        Comum.prototype.toggleStatus = function (newUrl) {
            var self = this,
                newUrl = (typeof newUrl !== 'undefined' ? newUrl : site_url + self.module + '/active');

            var options = {
                size: 'small',
                checked: undefined,
                onText: 'Sim',
                offText: 'Não',
                onSwitchColor: this.primaryColor,
                offSwitchColor: this.dangerColor,
                onJackColor: '#fff',
                offJackColor: '#fff',
                showText: false,
                onInit: function () { },
                beforeChange: function () { },
                onChange: function (isChecked) {
                    var element = $(this)[0],
                        id = $(element._el).data('id');

                    $.ajax({
                        type: "POST",
                        url: newUrl,
                        data: {
                            id: id,
                            actived: isChecked,
                            type: 'status'
                        },
                        dataType: "json",
                        success: function (data) {
                            var obj = {
                                layout: 'top',
                                text: data.message,
                                type: data.classe
                            };
                            openNotification(obj);
                        }
                    });
                },
                beforeRemove: function () { },
                onRemove: function () { },
                beforeDestroy: function () { },
                onDestroy: function () { }
            };

            if ($('[data-toggle="switch-status"]').length > 0) {
                $('[data-toggle="switch-status"]').each(function (teste, el) {
                    var newswitch = new Switch(el, options);
                });
            }
        };

        Comum.prototype.notify = function () {
            // Auto Notify
            if ($('.auto-notify').length > 0) {
                openNotification({
                    layout: 'top',
                    text: $('.auto-notify').data('message'),
                    type: $('.auto-notify').data('classe')
                });
                $('.auto-notify').remove();
            }
        };

        Comum.prototype.filter = function () {
            // Filtro
            $('#filter-show, .filter-show').on('change', function () {
                $(this).closest('form').submit();
            });
        };

        Comum.prototype.pagination = function () {
            // Paginação
            $('.pagination').on('click', '.disabled > a', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });

            // $('.page-next').on('click')
        };

        Comum.prototype.bootstrap = function () {
            if ($('[data-toggle="tooltip"]').length > 0)
                $('[data-toggle="tooltip"]').tooltip();
        };

        Comum.prototype.getZipcode = function (callback) {
            return true;
        };

        /**
         * Create a web friendly URL slug from a string.
         */
        Comum.prototype.urlSlug = function (s, opt) {
            s = String(s);
            opt = Object(opt);

            var defaults = {
                'delimiter': '-',
                'limit': undefined,
                'lowercase': true,
                'replacements': {},
                'transliterate': (typeof (XRegExp) === 'undefined') ? true : false
            };

            // Merge options
            for (var k in defaults) {
                if (!opt.hasOwnProperty(k)) {
                    opt[k] = defaults[k];
                }
            }

            var char_map = {
                // Latin
                'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
                'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
                'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
                'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
                'ß': 'ss',
                'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
                'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
                'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
                'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
                'ÿ': 'y',

                // Latin symbols
                '©': '(c)',

                // Greek
                'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
                'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
                'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
                'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
                'Ϋ': 'Y',
                'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
                'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
                'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
                'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
                'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

                // Turkish
                'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
                'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',

                // Russian
                'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
                'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
                'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
                'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
                'Я': 'Ya',
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
                'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
                'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
                'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
                'я': 'ya',

                // Ukrainian
                'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
                'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

                // Czech
                'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
                'Ž': 'Z',
                'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
                'ž': 'z',

                // Polish
                'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
                'Ż': 'Z',
                'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
                'ż': 'z',

                // Latvian
                'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
                'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
                'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
                'š': 's', 'ū': 'u', 'ž': 'z'
            };

            // Make custom replacements
            for (var k in opt.replacements) {
                s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
            }

            // Transliterate characters to ASCII
            if (opt.transliterate) {
                for (var k in char_map) {
                    s = s.replace(RegExp(k, 'g'), char_map[k]);
                }
            }

            // Replace non-alphanumeric characters with our delimiter
            var alnum = (typeof (XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
            s = s.replace(alnum, opt.delimiter);

            // Remove duplicate delimiters
            s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);

            // Truncate slug to max. characters
            s = s.substring(0, opt.limit);

            // Remove delimiter from ends
            s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');

            return opt.lowercase ? s.toLowerCase() : s;
        };

        Comum.prototype.buscaEndereco = function () {
            $("body").on("select2:select", '#inputEstado', function (e) {
                var data = e.params.data;

                loadCitiesSelect(data.id)
            });

            let loadCitiesSelect = function (id_estado, texto_cidade) {
                add_loading();
                $("#inputCidade").empty();

                if (id_estado == '' && id_estado != undefined) {
                    $.ajax({
                        type: "GET",
                        url: site_url + module_slug + '/get_cities/' + id_estado,
                        dataType: "json",
                        success: function (response) {
                            response.forEach(function (item) {
                                if (texto_cidade !== undefined && slugify(texto_cidade) === slugify(item.name)) {
                                    var o = new Option(item.name, item.id);
                                    $(o).html(item.name);
                                    $(o).attr('selected', 'selected');
                                    $("#inputCidade").append(o);
                                } else {
                                    var o = new Option(item.name, item.id);
                                    $(o).html(item.name);
                                    $("#inputCidade").append(o);
                                }
                            })

                            $("#inputCidade").trigger('change');

                            remove_loading();
                        },
                        fail: function () {
                            remove_loading();
                            $("#inputCidade").trigger('change');
                            return false;
                        }
                    });
                }
            }

            $("body").on("change", "#inputCEP", function () {
                var el = $(this);
                var numero_cep = el.val();

                if (numero_cep.length == 0) {
                    $("#inputComplemento").val('');
                    $("#inputEndereco").val('');
                    $("#inputCidade").val('');
                    $("#inputEstado").val('');
                    $("#inputBairro").val('');
                    return false;
                }

                add_loading();
                $.ajax({
                    method: "GET",
                    url: "https://viacep.com.br/ws/" + numero_cep + "/json/",
                })
                    .done(function (dados) {
                        if (dados.complemento)
                            // $("#inputComplemento").val(dados.complemento);
                        $("#inputEndereco").val(dados.logradouro);
                        $("#inputCidade").val(dados.localidade);
                        $("#inputBairro").val(dados.bairro);

                        //busca no data-uf dos options do $("#inputEstado")
                        let id_estado;
                        $("#inputEstado option").each(function () {
                            if ($(this).data("uf") === dados.uf) {
                                $(this).prop("selected", true);
                                id_estado = $(this).val();
                                $("#inputEstado").trigger("change");

                                loadCitiesSelect(id_estado, dados.localidade);
                            }
                        });

                        remove_loading();
                    })
                    .fail(function () {
                        remove_loading();

                        $("#inputComplemento").val('');
                        $("#inputEndereco").val('');
                        $("#inputCidade").val('');
                        $("#inputEstado").val('');
                        $("#inputBairro").val('');
                    });
            });
        }

        Comum.prototype.multipleSelectTable = function (id, name) {
            console.log("Multiple select table initialized...");
            // cacheia os  elementos para utilizar
            var $box = $('#' + id);
            if ($box.length == 0)
                return;

            var $select = $box.find('select[name="select_' + name + '"]'),
                $table = $box.find('#' + id + '-table'),
                layout = $table.find('.no-selected').next()[0].outerHTML;

            $table.find('.no-selected').next().remove();

            // verifica mudança no select principal
            $select.on('change', function () {
                console.log('change');
                // pega informações sobre a opção selecionada
                var selected = $(this).find('option:selected'),
                    value = selected.val(),
                    title = selected.text().trim(),
                    alreadyAdd = false;

                // verifica se a opção selecionada não é o placeholder
                if (value <= 0) {
                    return false;
                }

                // remove a opção selecionada
                selected.remove();

                // esconde linha com texto de nenhum item selecionado
                if ($box.find('.no-selected').is(":visible")) {
                    $box.find('.no-selected').hide();
                }

                // verifica se por acaso o item selecionado já exista na lista de selecionados
                alreadyAdd = $table.find('input[name="' + name + '[' + value + '][id]"]').length > 0;

                // se o item não existir cria elemento na lista
                if (!alreadyAdd) {
                    var html = layout;
                    html = html.replace(new RegExp('{id}', 'g'), value);
                    html = html.replace(new RegExp('{title}', 'g'), title);
                    $box.find('#' + id + '-table').append(html);
                }

                // reseta select para o placeholder
                $(this).val(null).trigger("change");
            });

            // função para corrigir width
            var fixHelper = function (e, ui) {
                ui.children().each(function () {
                    $(this).width($(this).width());
                });
                return ui;
            };

            // ao clicar em deletar algum item
            $('body').on('click', '#' + id + ' .delete-item', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // pega informações sobre o item a ser excluído
                var value = $(this).data('id'),
                    title = $(this).data('title');

                // retorna a opção dele no select principal
                $select.append(new Option(title, value, false, false));

                // remove elemento da listagem
                $box.find('tr[data-id="' + value + '"]').remove();

                // verifica se a listagem está vazia
                if ($box.find('#' + id + '-table').find('tr').length == 1) {
                    // se estiver exibe mensagem de nenhum item selecionado
                    $box.find('.no-selected').show();
                }
            });
        };

        Comum.prototype.gerarSenha = function () {
            $(".gerar-senha").on("click", function () {
                var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                var senha = "";
                for (var i = 0; i < 8; i++) {
                    var randomIndex = Math.floor(Math.random() * charset.length);
                    senha += charset.charAt(randomIndex);
                }

                $(this).closest('.content-row-senhas').find('input[type="password"]').val(senha);
            });
        };

        Comum.prototype.dynamicFields = function (contentName) {
            var self = this;
            var className = '.' + contentName;

            if ($(className).length > 0) {

                function format(data) {
                    if (!data.id) { return data.text; }
                    return $(" " + data.text + '');
                };

                var contentTemplate;
                $.ajax({
                    type: "POST",
                    url: site_url + module_slug + '/get_' + contentName + '_template',
                    dataType: "html",
                    success: function (data) {
                        contentTemplate = data;
                    }
                });

                $('.more-' + contentName).click(function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $gallery = $(this).closest(className),
                        $add = $gallery.find('.add-' + contentName),
                        keySequence = $add.find('li:last-child').data('seq') + 1;
                    keySequence = (keySequence) ? keySequence : 0;

                    var template = contentTemplate;
                    template = template.replace(new RegExp('{key}', 'g'), keySequence);
                    $add.append(template);

                    self.setMask();
                    self.select2();
                    self.Switch();
                    self.gerarSenha();
                });
                $('.add-' + contentName).on('click', '.remove-' + contentName, function () {
                    $(this).closest('.group-remove-' + contentName).remove();
                });
            }
        };

        window.Comum = new Comum();
        return Comum;

    }(window));