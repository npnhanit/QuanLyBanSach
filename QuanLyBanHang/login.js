document.addEventListener("DOMContentLoaded", function() {


    // dang nhap dang ki

    var login = document.getElementsByClassName("dangnhap");

    for (var i = 0; i < login.length; i++) {
        login[i].onclick = function() {
            for (var j = 0; j < login.length; j++) {
                if (login[j] != login[i]) {
                    var logincon1 = login[j].getAttribute('data-login');
                    var loginan1 = document.getElementById(logincon1);
                    loginan1.classList.remove('an');
                    login[j].classList.remove('maulogin');
                }
            }
            var logincon = this.getAttribute('data-login');
            var loginan = document.getElementById(logincon);
            loginan.classList.add('an');
            this.classList.add('maulogin');

        }
    }

    var listlogin = document.getElementsByClassName('login');

    var khungdangnhap = document.getElementsByClassName('loginform');
    var manden = document.getElementsByClassName('manden');

    listlogin[0].onclick = function() {
        khungdangnhap[0].classList.remove('ankhungdangnhap');
        manden[0].classList.remove('ankhungdangnhap');

        var registration = document.getElementById('registration');
        var login1 = document.getElementById('login1');
        login[0].classList.remove('maulogin');
        login[1].classList.remove('maulogin');
        login[0].classList.add('maulogin');

        registration.classList.add('an');
        login1.classList.add('an');
        registration.classList.remove('an');


    }
    listlogin[1].onclick = function() {
        khungdangnhap[0].classList.remove('ankhungdangnhap');
        manden[0].classList.remove('ankhungdangnhap');
        var registration = document.getElementById('registration');
        var login1 = document.getElementById('login1');
        registration.classList.add('an');
        login1.classList.add('an');
        login1.classList.remove('an');
        login[0].classList.remove('maulogin');
        login[1].classList.remove('maulogin');
        login[1].classList.add('maulogin');
    }

    manden[0].onclick = function() {
        khungdangnhap[0].classList.add('ankhungdangnhap');
        manden[0].classList.add('ankhungdangnhap');
    }

}, false)