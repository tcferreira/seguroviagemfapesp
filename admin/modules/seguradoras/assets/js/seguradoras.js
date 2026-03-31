'use strict';

$('document').ready(function () {

    var Seguradoras = function () {
        return this.__constructor();
    };

    Seguradoras.prototype = Comum;
    Seguradoras.prototype.constructor = Seguradoras;

    Seguradoras.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Seguradoras = new Seguradoras();
    return Seguradoras;

});
