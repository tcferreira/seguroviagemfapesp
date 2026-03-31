'use strict';

$('document').ready(function () {

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Routes = function () {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Routes.prototype = Comum;
    Routes.prototype.constructor = Routes;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Routes
     */
    Routes.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();

        return this;
    };

    window.Routes = new Routes();
    return Routes;

});
