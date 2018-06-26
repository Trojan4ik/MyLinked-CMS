<div class="padding_box">
    <div class="page_title">
        <h1>Регистрация</h1>
    </div>
    <div class="tabs-box">
        <div class="tab-content padding_box regform_wrapper" id="js_regform_box">
            <div id="js_regform_overlay" class="regform_overlay" style="display: none">
                <div class="circle_loader"></div>
            </div>
            <script>
                function validate_form(){
                	if(document.regform.modern_form.password.value!=document.regform.modern_form.password2.value){
                		return false;
                	}else{ return true; }
                }
            </script>
            <form method="POST" action="" onsubmit="return validate_form ( );" name=regform>
                <div class="modern_form">
                    <div class="form_row">
                        <div class="fieldname">Никнейм:</div>
                        <div class="control">
                            <input type="text" name="login" class="ui-input" maxlength="20" required="">
                            <div id="js_reg_error_username"></div>
                            <div class="gray_label">Длина от 4 до 20 символов. Только латинские буквы, цифры и знак подчёркивания.</div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="form_row">
                        <div class="fieldname">Пароль:</div>
                        <div class="control">
                            <input type="password" name="password" class="ui-input" id="js_password_input" maxlength="32" autocomplete="off" required="">
                            <div id="js_reg_error_password"></div>
                            <div class="gray_label">Придумайте надёжный пароль от 8 до 32 символов.</div>
                        </div>
                    </div>
                    <div class="form_row">
                        <div class="fieldname">Пароль ещё раз:</div>
                        <div class="control">
                            <input type="password" name="password2" class="ui-input" autocomplete="off" maxlength="32" required="">
                            <div id="js_reg_error_password2"></div>
                            <div class="gray_label">Нужно убедиться, что Вы запомнили пароль.</div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="form_row">
                        <div class="fieldname">Адрес электронной почты:</div>
                        <div class="control">
                            <input type="email" name="email" class="ui-input" maxlength="32" placeholder="example@mail.ru" required="">
                            <div id="js_reg_error_email"></div>
                            <div class="gray_label">Введите действующий адрес. Используется для восстановления доступа к аккаунту, если Вы забудете пароль.</div>
                            <div class="ui-box blue">На почту будет выслано письмо для подтверждения адреса.</div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="form_row">
                        <div class="fieldname">Cоциальные сети:</div>
                        <div class="control">
                            <input type="sn" name="sn" class="ui-input" maxlength="32" placeholder="vk.com/id1" required="">
                            <div class="gray_label">Укажите ссылку на страницу в социальной сети, которой больше всего пользуетесь.</div>
                            <div class="gray_label">Она нужна для связи с вами.</div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="form_row">
                        <div class="fieldname">
                            Капча:
                            <div class="gray_label">Установите флажок.</div>
                        </div>
                        <div class="control">
                            <script src='https://www.google.com/recaptcha/api.js'></script>
                            <div class="g-recaptcha" data-sitekey="6LdFBl8UAAAAAOZVIQLS0KUJibz0Z29VcLpZEGaq"></div>
                            <div id="js_reg_error_captcha"></div>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="form_row">
                        <div class="control">
                            <button type="submit" name = "submit" class="btn" id="reg_sub">Создать аккаунт</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
[result]
[logged]
<script>
    window.location.replace('/');
</script>
[/logged]