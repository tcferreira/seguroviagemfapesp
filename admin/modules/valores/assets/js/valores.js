'use strict';

$('document').ready(function () {

    var Valores = function () {
        return this.__constructor();
    };

    Valores.prototype = Comum;
    Valores.prototype.constructor = Valores;

    Valores.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Valores = new Valores();
    return Valores;

});
