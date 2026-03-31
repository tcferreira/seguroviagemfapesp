'use strict';

$('document').ready(function(){

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Company = function() {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Company.prototype = Comum;
    Company.prototype.constructor = Company;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Company
     */
    Company.prototype.__constructor = function() {
        this.bootstrap();
        this.toggleStatus();
        this.upload();
        this.buscaEndereco();
        this.buscaCnpj();

        if ( $('#inputExpiration').length > 0 )
            $('#inputExpiration').dateDropper({
                'lang': 'pt',
                'largeDefault': true,
                'large': true,
                'format': 'd/m/Y'
            });

        return this;
    };

    Company.prototype.buscaCnpj = function () {
        $("#inputCNPJ").on("change", function () {
            var el = $(this);
            var numero_cnpj = el.val();

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
                    $("#inputNomeFantasia").val(dados.fantasia ? dados.fantasia : dados.nome);
                    $("#inputRazaoSocial").val(dados.nome ? dados.nome : '');
                    $("#inputCEP").val(dados.cep ? formatZipCode(dados.cep) : '').trigger('change');

                    remove_loading();
                })
                .fail(function () {
                    $("#inputNomeFantasia").val('');
                    $("#inputRazaoSocial").val('');
                    $("#inputCEP").val('').trigger('change');

                    remove_loading();
                });
        });
    }

    window.Company = new Company();
    return Company;

});
