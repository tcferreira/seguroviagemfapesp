var files = [];
var Main = function () {
    "use strict";

    Main.prototype.init = function () {
        var self = this;
    };

    Main.prototype.tools = {
        minH: 0,
        minW: 960,
        ww: $(window).width(),
        wh: $(window).height(),
        vw: function (arg) {
            if (arg) return arg;
            return (this.ww < this.minW) ? this.minW : this.ww; //viewport W
        },
        vh: function (arg) {
            if (arg) return arg;
            return (this.wh < this.minH) ? this.minH : this.wh; //viewport H
        },
        getOffset: function () { 
            return window.pageYOffset ? window.pageYOffset : (document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop);
        },  
        theMouseWheel: function (e) {
            e = e || window.event;
            if (e.preventDefault)
                e.preventDefault();
            e.returnValue = false;
        },
        disable_scroll: function () {
            if (window.addEventListener) {
                window.addEventListener('DOMMouseScroll', this.theMouseWheel, false);
            }
            window.onmousewheel = document.onmousewheel = this.theMouseWheel;
        },
        enable_scroll: function () {
            if (window.removeEventListener) {
                window.removeEventListener('DOMMouseScroll', this.theMouseWheel, false);
            }
            window.onmousewheel = document.onmousewheel = null;
        },
        loadAnyImg: function (path, callback) {
            var fakeImg = new Image();
            fakeImg.onload = new function () {
                if (typeof callback == 'function') {
                    return callback();
                }
            };
            fakeImg.src = path;
        },
    };

    // Inicializa funções comuns do site
    this.init();
};
