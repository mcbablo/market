jQuery(function ($) {
    var d = $.fn.deviceDetector;
    var isLoading = false;    
    $('.click-login-btn').removeClass('the4-loading');
    $('.auth-sidebar-btn').removeClass('the4-loading');
    $('.click-login-btn').prop('disabled', false);
    $('.auth-sidebar-btn').prop('disabled', false);


    var check_phone = function ($form) {
        var $phone = $form.find('#phone-number');
        var phone = '998' + $form.find('#phone-number').inputmask('unmaskedvalue');

        if (phone.toString().trim() === '') {
            alert('Заполните ваш номер телефона');
            $phone.focus();
            return false;
        }

        var regex = new RegExp("^998([93]{1})([01345789]{1})([0-9]{7})$");

        if (!regex.test(phone.toString().trim())) {
            alert("Неверный номер телефона");
            $phone.focus();
            return false;
        }

        if (phone.length === 12) {
            isLoading = true;
            $('.click-login-btn').addClass('the4-loading');
            $('.auth-sidebar-btn').addClass('the4-loading');
            $('.click-login-btn').prop('disabled', true);
            $('.auth-sidebar-btn').prop('disabled', true);
            $.post(
                '/wp-admin/admin-ajax.php',
                {
                    'action': 'check_phone',
                    'params': {
                        'phone_number': phone,
                        'device_info': d.getBrowserName(),
                        'device_name': d.getOsName() + ' ' + d.getOsVersionString(),
                        'device_type': d.isMobile() ? 4 : 4,
                        'imei': '',
                        'app_version': d.getBrowserVersion()
                    }
                },
                function (response) {
                    isLoading = false;
                    $('.click-login-btn').removeClass('the4-loading');
                    $('.auth-sidebar-btn').removeClass('the4-loading');
                    $('.click-login-btn').prop('disabled', false);
                    $('.auth-sidebar-btn').prop('disabled', false);

                    $form.addClass(response['status']);

                    if (response['status'] == 'registered') {
                        $form.attr('data-step', 'check-password');
                        alert("Введите пароль от аккаунта");
                    } else {
                        if (!response['error']) {
                            alert("Введите код подтверждения");
                            $form.attr('data-step', 'check-otp');
                            $form.find('#device_id').val(response['result']['device_id']);
                            $form.find('#phone-number').attr('readonly', 'readonly');
                            $form.find('#confirmation-code').focus();
                            $form.find('[type=submit]').text('Подтвердить');
                        } else {
                            alert(response['error']['message']);
                        }
                    }
                }, 'json');
        }

    };

    var check_otp = function ($form) {
        var phone = '998' + $form.find('#phone-number').inputmask('unmaskedvalue');
        var sms_code = $form.find('#confirmation-code').val();
        var device_id = $form.find('#device_id').val();

        if (sms_code.toString().trim() == '') {
            alert('Введите код подтверждения');
            $form.find('#confirmation-code').focus();
            return false;
        }

        isLoading = true;
        $('.click-login-btn').addClass('the4-loading');
        $('.auth-sidebar-btn').addClass('the4-loading');
        $('.click-login-btn').prop('disabled', true);
        $('.auth-sidebar-btn').prop('disabled', true);
        $.post(
            '/wp-admin/admin-ajax.php',
            {
                'action': 'check_otp',
                'sms_code': sms_code,
                'params': {
                    'phone_number': phone,
                    'device_id': device_id
                }
            },
            function (response) {
                alert("Введите пароль и имя");
                isLoading = false;
                $('.click-login-btn').removeClass('the4-loading');
                $('.auth-sidebar-btn').removeClass('the4-loading');
                $('.click-login-btn').prop('disabled', false);
                $('.auth-sidebar-btn').prop('disabled', false);
                if (!response['error']) {
                    $form.attr('data-step', 'register');
                    $form.find('[type=submit]').text('Отправить');
                } else {
                    alert(response['message']);
                }
            },
            'json');


    };

    var check_password = function ($form) {
        var phone = '998' + $form.find('#phone-number').inputmask('unmaskedvalue');
        var password = $form.find('#password').val();
        if (password.toString().trim() == '') {
            alert('Введите пароль');
            $form.find('#password').focus();
            return false;
        }

        isLoading = true;
        $('.click-login-btn').addClass('the4-loading');
        $('.auth-sidebar-btn').addClass('the4-loading');
        $('.click-login-btn').prop('disabled', true);
        $('.auth-sidebar-btn').prop('disabled', true);
        $.post(
            '/wp-admin/admin-ajax.php',
            {
                'action': 'click_login_auth',
                'params': {
                    'phone_number': phone,
                    'password': password
                }
            },
            function (response) {
                isLoading = false;
                $('.click-login-btn').removeClass('the4-loading');
                $('.auth-sidebar-btn').removeClass('the4-loading');
                $('.click-login-btn').prop('disabled', false);
                $('.auth-sidebar-btn').prop('disabled', false);
                if (!response['error']) {
                    window.location.reload();
                } else {
                    alert(response['message']);
                }
            },
            'json');

    };

    var register = function ($form) {
        var phone = '998' + $form.find('#phone-number').inputmask('unmaskedvalue');
        var password = $form.find('#password').val();
        var confirmation = $form.find('#password_confirmation').val();
        var display_name = $form.find('#display_name').val();

        if (password !== confirmation) {
            alert('Пароль и его подтверждение не совпадает');
            return;
        }

        isLoading = true;
        $('.click-login-btn').addClass('the4-loading');
        $('.auth-sidebar-btn').addClass('the4-loading');
        $('.click-login-btn').prop('disabled', true);
        $('.auth-sidebar-btn').prop('disabled', true);
        $.post(
            '/wp-admin/admin-ajax.php',
            {
                'action': 'click_login_register',
                'params': {
                    'phone_number': phone,
                    'password': password,
                    'display_name': display_name
                }
            },
            function (response) {
                isLoading = false;
                $('.click-login-btn').removeClass('the4-loading');
                $('.auth-sidebar-btn').removeClass('the4-loading');
                $('.click-login-btn').prop('disabled', false);
                $('.auth-sidebar-btn').prop('disabled', false);

                if (!response['error']) {
                    window.location.reload();
                } else {
                    alert(response['message']);
                }
            },
            'json');
    };

    $(function () {
        $('.click-login #phone-number').inputmask('\\9\\9\\8 (99) 999-99-99');

        $('form.click-login').on('submit', function () {   

            var $form = $(this);

            var step = $form.attr('data-step');

            switch (step) {
                case 'check-phone':
                    check_phone($form);
                    break;
                case 'check-otp':
                    check_otp($form);
                    break;
                case 'check-password':
                    check_password($form);
                    break;
                case 'register':
                    register($form);
                    break;
            }

            return false;
        });

    });

});