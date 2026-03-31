'use strict';

$('document').ready(function(){

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Home = function() {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Home.prototype = Comum;
    Home.prototype.constructor = Home;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Home
     */
    Home.prototype.__constructor = function() {
        var screenWidth = $(window).width();
        this.bootstrap();
        this.toggleStatus();
        this.selectize();

        return this;
    };

    window.Home = new Home();
    return Home;

});
