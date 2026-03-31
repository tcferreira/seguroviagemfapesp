'use strict';

$('document').ready(function () {

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Module = function () {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Module.prototype = Comum;
    Module.prototype.constructor = Module;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Module
     */
    Module.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();

        return this;
    };

    window.Module = new Module();
    return Module;

});
