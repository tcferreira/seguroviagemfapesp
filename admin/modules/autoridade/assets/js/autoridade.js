'use strict';

$('document').ready(function () {

    var Autoridade = function () {
        return this.__constructor();
    };

    Autoridade.prototype = Comum;
    Autoridade.prototype.constructor = Autoridade;

    Autoridade.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Autoridade = new Autoridade();
    return Autoridade;

});
