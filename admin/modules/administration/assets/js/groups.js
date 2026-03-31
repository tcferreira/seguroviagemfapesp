'use strict';

$('document').ready(function(){

    /**
     * Inicia propriedades do objeto
     * @author Gabriel Stringari
     */
    var Groups = function() {
        return this.__constructor();
    };

    /**
     * Extende Comum
     * @type {Comum}
     */
    Groups.prototype = Comum;
    Groups.prototype.constructor = Groups;

    /**
     * Construtor da classe
     * @author Gabriel Stringari
     * @return Groups
     */
    Groups.prototype.__constructor = function() {
        this.bootstrap();
        this.toggleStatus();

        $('.all-checkbox').each(function(i, element) {
            var id = $(element).attr('id');
            var elements = $("[data-module='" + id + "']")

            var haveUnchecked = 0;
            elements.each(function (idx, elementChecks) {
                haveUnchecked = $(elementChecks).prop('checked') ? haveUnchecked : haveUnchecked + 1;
            });

            if (haveUnchecked == 0)
                $(element).prop('checked', true)
        });

        $('.all-checkbox').on('click', function () {
            var check = $(this).prop('checked'),
                id = $(this).attr('id');

            var elements = $("[data-module='" + id + "']")
            elements.each(function (idx, elementChecks) {
                $(elementChecks).prop('checked', check);
            });
        });

        return this;
    };

    window.Groups = new Groups();
    return Groups;

});
