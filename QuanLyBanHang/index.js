document.addEventListener("DOMContentLoaded", function() {
    var icons = document.getElementsByClassName('icon');
    var list = document.getElementsByClassName('list-help');
    for (var i = 0; i < icons.length; i++) {
        icons[i].onclick = function() {
            if (this.classList[2] == 'vang') {
                this.classList.remove('vang');
                var noidung = this.getAttribute('data-hienlen')
                var listhienra = document.getElementById(noidung);
                listhienra.classList.remove('hien');
            } else {
                for (var k = 0; k < icons.length; k++) {
                    icons[k].classList.remove('vang');
                }
                this.classList.toggle('vang');
                var noidung = this.getAttribute('data-hienlen')
                var listhienra = document.getElementById(noidung);
                for (k = 0; k < list.length; k++) {
                    list[k].classList.remove('hien');
                }
                listhienra.classList.toggle('hien');
            }
        }
    }

    var theloai = document.getElementsByClassName('list-nav');

    for (var i = 0; i < theloai.length; i++) {
        theloai[i].onmouseover = function() {
            var theloaicon = this.getAttribute('data-hien');
            var theloaihien = document.getElementById(theloaicon);
            theloaihien.classList.add('hienxuong');
        }
    }

    for (var i = 0; i < theloai.length; i++) {
        theloai[i].onmouseout = function() {
            var theloaicon = this.getAttribute('data-hien');
            var theloaihien = document.getElementById(theloaicon);
            theloaihien.classList.remove('hienxuong');
        }
    }

    var don = document.getElementsByClassName('don');

    for (var i = 0; i < don.length; i++) {
        don[i].onmouseover = function() {
            var doncon = this.getAttribute('data-hiendon');
            var theloaihien = document.getElementById(doncon);
            theloaihien.classList.add('hienxuong');
        }
    }

    for (var i = 0; i < don.length; i++) {
        don[i].onmouseout = function() {
            var doncon = this.getAttribute('data-hiendon');
            var theloaihien = document.getElementById(doncon);
            theloaihien.classList.remove('hienxuong');
        }
    }

}, false)