'use strict';

$('document').ready(function () {

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Users = function () {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Users.prototype = Comum;
    Users.prototype.constructor = Users;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Users
     */
    Users.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        this.upload();

        return this;
    };

    window.Users = new Users();
    return Users;

});
