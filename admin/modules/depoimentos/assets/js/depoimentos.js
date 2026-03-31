'use strict';

$('document').ready(function () {

    var Depoimentos = function () {
        return this.__constructor();
    };

    Depoimentos.prototype = Comum;
    Depoimentos.prototype.constructor = Depoimentos;

    Depoimentos.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Depoimentos = new Depoimentos();
    return Depoimentos;

});
