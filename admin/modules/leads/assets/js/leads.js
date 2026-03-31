'use strict';

$('document').ready(function () {

    var Leads = function () {
        return this.__constructor();
    };

    Leads.prototype = Comum;
    Leads.prototype.constructor = Leads;

    Leads.prototype.__constructor = function () {
        this.bootstrap();
        this.toggleStatus();
        return this;
    };

    window.Leads = new Leads();
    return Leads;

});
