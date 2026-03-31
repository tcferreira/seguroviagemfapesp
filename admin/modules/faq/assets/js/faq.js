'use strict';

$('document').ready(function () {

    var Faq = function () {
        return this.__constructor();
    };

    Faq.prototype = Comum;
    Faq.prototype.constructor = Faq;

    Faq.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Faq = new Faq();
    return Faq;

});
