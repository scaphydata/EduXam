console.log('==== FUNCTIONS.JS ====');


/******************************** fonctoin bare de menu Javascript ******************************************************/
sfHover = function() {
        var menu = document.getElementById("menu");
        if (menu) {
                var sfEls = menu.getElementsByTagName("LI");
                for (var i=0; i<sfEls.length; i++) {

                        sfEls[i].onmouseover=function() {
                                this.className+=" sfhover";
                        }
                        sfEls[i].onmouseout=function() {
                                this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
                        }
                }
        }
}
if (window.attachEvent) {
        window.attachEvent("onload", sfHover);
} else {
        window.addEventListener("load", sfHover);
}

console.log('==== FUNCTIONS.JS ====');
