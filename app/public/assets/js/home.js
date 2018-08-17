$(document).ready(f => {

    let veriyPassword = () => $('#conf-password').val() === $('#password').val()

    let homeEffects = () => {
        $('.container-flex').fadeIn(2000)
        $('.container-flex').css({"display": "flex"})
        setTimeout(f => {
            $('.container-flex').animate({"height": "80vh"})
            $('.box-btn-menu').fadeIn(2000)
            $('.box-btn-menu').css({"display": "flex"})
        }, 2000)
    }

    // change color inputs
    let changeColorInputs = () => {
        $('input.form-control').keyup((el) => {
            if ("" !== $(el.target)) {
                $(el.target).css({"color": "#fcfcfc"})
            } else {
                $(el.target).css({"color": "#dbdbdb"})
            }
        })
    }

    let chackEmptyFieldsFormRegister = () => {
        // check empty fields
        $('input.ipt-form-register').keyup((el)  => {
            // check all inputs and enable button submit in register form
            if (
                veriyPassword() &&
                $('#name').val() !== "" &&
                $('#email').val() !== "" &&
                $('#password').val() !== "" &&
                $('#conf-password').val() !== ""
            ) {
                $('#btn-submit-register').prop('disabled', false)
                $('#btn-submit-register').removeClass('disabled')
            } else {
                $('#btn-submit-register').prop('disabled', true)
                $('#btn-submit-register').addClass('disabled')
            }
        })
    }

    let checkEmptyFieldsFormLogin = () => {
        $('input.ipt-form-login').keyup((el) => {
            if ($('#email-login').val() !== "" && $('#password-login').val() !== "") {
                $('#btn-submit-login').prop('disabled', false)
                $('#btn-submit-login').removeClass('disabled')
            } else {
                $('#btn-submit-login').prop('disabled', true)
                $('#btn-submit-login').addClass('disabled')
            }
        })
    }

    let verifyPasswordEvent = () => {
        // verify password equals cofirm
        $('#conf-password').focusout(f => {
            if ( ! veriyPassword()) {
                $('.show-alert-confirm-pass').css({"display": "block"})
            } else {
                $('.show-alert-confirm-pass').css({"display": "none"})
            }
        })
    }

    $('#btn-submit-register').click((event) => {
        event.preventDefault()
        $.ajax({
            url: '/register',
            cache: false,
            data: $('#form-register').serialize(),
            type: 'post',
            error: (err) => {
                console.log(err)
            },
            success: (data) => {
                if (data.success) {
                    $('#register').removeClass('show')
                    $('#register').css({"display": "none"})
                }
            },
        }).done(f => {
            console.log('ok, registered!')
        }).fail(f => {
            console.log('fail register!')
        })
    })

    $('#btn-submit-login').click((event) => {
        event.preventDefault()
        $.ajax({
            url: '/login',
            cache: false,
            data: $('#form-login').serialize(),
            type: 'post',
            error: (err) => {
                console.log(err)
            },
            success: (data) => {
                console.log(data)
            }
        }).done(f => {
            console.log('ok, logged!')
        }).fail(f => {
            console.log('fail!')
        })
    })

    homeEffects()
    changeColorInputs()
    chackEmptyFieldsFormRegister()
    checkEmptyFieldsFormLogin()
    verifyPasswordEvent()
})
