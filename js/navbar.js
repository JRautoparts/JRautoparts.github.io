window.onscroll = function() {Stick_scroll()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function Stick_scroll() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
    } else {
        navbar.classList.remove("sticky");
    }
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").style.padding = "30px 0px";

    } else {
        document.getElementById("navbar").style.padding = "80px 0px";

    }
}