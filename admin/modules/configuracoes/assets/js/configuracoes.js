'use strict';

$('document').ready(function () {

    var Configuracoes = function () {
        return this.__constructor();
    };

    Configuracoes.prototype = Comum;
    Configuracoes.prototype.constructor = Configuracoes;

    Configuracoes.prototype.__constructor = function () {
        this.bootstrap();
        return this;
    };

    window.Configuracoes = new Configuracoes();
    return Configuracoes;

});
