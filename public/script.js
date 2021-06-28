var menuIcon = document.querySelector('.menu-icon-mobile')
var menuHumburguer = document.querySelector('#menu-mobile')
var lines = document.querySelectorAll('.line')

if (menuIcon) {
    menuIcon.addEventListener('click', () => {
        if (menuHumburguer.classList.contains('display')) {
            menuHumburguer.style.display = 'none'
            menuHumburguer.classList.remove('display')
            lines[1].style.animationName = ''
            lines[0].style.animationName = ''
            lines[2].style.opacity = 1
        } else {
            menuHumburguer.style.display = 'block'
            menuHumburguer.classList.add('display')
            lines[1].style.animationName = 'menu-right'
            lines[0].style.animationName = 'menu-left'
            lines[2].style.opacity = 0
        }
    })
}

var modal = document.querySelectorAll('.modal')
var modalLogin = document.querySelector('.modalLogin')
var modalCreate = document.querySelector('.modalCreate')
var modalFilter = document.querySelector('.modalFilter')

if (modal) {
    for (let i = 0; i < modal.length; i++) {
        modal[i].addEventListener('click', (e) => {
            if (e.target.className === 'modalCreate modal' || e.target.className === 'modalLogin modal' || e.target.className === 'modalFilter modal') {
                modal[i].style.display = 'none'
            }
        })
    }
}

var login = document.querySelectorAll('.login')

if (login) {
    for (let i = 0; i < login.length; i++) {
        login[i].addEventListener('click', () => {
            modalLogin.style.display = 'block'
        })
    }

}

var create = document.querySelectorAll('.create')

if (create) {
    for (let i = 0; i < create.length; i++) {
        create[i].addEventListener('click', () => {
            modalCreate.style.display = 'block'
        })
    }
}

var filterTip = document.querySelector('.filter-title')
if (filterTip) {
    filterTip.addEventListener('click', () => {
        modalFilter.style.display = 'block'
    })
}


var form = document.querySelector('#ajaxSend');

if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault()
        var formData = new FormData(form);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'usuarios/registo',
            type: 'POST',
            dataType: "JSON",
            contentType: false, // requires jQuery 1.6+
            processData: false,
            data: formData,
            beforeSend: function () {
                console.log('Carregando o loading ...');
                document.querySelector('.custom-spinner').style.display = 'block'
            },
            success: function (response) {
                console.log(response);
                document.querySelector('.custom-spinner').style.display = 'none'
                document.querySelector('.alert-success').style.display = 'block'
                setTimeout(() => {
                    form.reset();
                    document.querySelector('.alert-success').style.display = 'none'
                    modal[1].style.display = 'none'
                }, 4000);
            },
            error: function (data) {
                console.log('Error: ', data)
                document.querySelector('.custom-spinner').style.display = 'none'
                document.querySelector('.alert-danger').style.display = 'block'
                setTimeout(() => {
                    document.querySelector('.alert-danger').style.display = 'none'
                }, 4000);
            }
        });

    })
}
