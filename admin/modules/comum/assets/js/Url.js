(function (window) {
    'use strict';

    var Url = function() {
        this.system = 'admin';
        this.host = window.document.location.host;
        this.hostname = window.document.location.hostname;
    };

    Url.prototype.redirect = function(url) {
        window.location.href = url;
    };


    Url.prototype.segments = function(key) {
        var pathname = window.document.location.pathname.replace(/(^\/|\/$)/g, ''),
            segments = String(pathname).split('/'),
            app = segments.indexOf(this.system) + 1;
            segments = segments.slice(app, segments.length);
        return typeof key !== undefined ? segments[key] : segments;
    }

    window.Url = new Url();
    return Url;

}(window));
