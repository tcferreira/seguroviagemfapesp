'use strict';

$('document').ready(function () {

    var Banners = function () {
        return this.__constructor();
    };

    Banners.prototype = Comum;
    Banners.prototype.constructor = Banners;

    Banners.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Banners = new Banners();
    return Banners;

});
