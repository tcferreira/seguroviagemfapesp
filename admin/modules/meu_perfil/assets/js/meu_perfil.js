'use strict';

$('document').ready(function () {

    var Meu_perfil = function () {
        return this.__constructor();
    };

    Meu_perfil.prototype = Comum;
    Meu_perfil.prototype.constructor = Meu_perfil;

    Meu_perfil.prototype.__constructor = function () {
        this.bootstrap();
        return this;
    };

    window.Meu_perfil = new Meu_perfil();
    return Meu_perfil;

});
