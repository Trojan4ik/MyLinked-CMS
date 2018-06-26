<div class="padding_box">
  <div class="page_title">
    <h1>Вход на сайт</h1>
    <a href="/?p=register" style="float:right;"><button class="btn-green" style="padding: 5px 10px 5px 10px;font-size: 14px;">Регистрация</button></a>
  </div>
  <div class="tabs-box">
    <div class="tab-content padding_box regform_wrapper" id="js_regform_box">
        [result]
      <form method="POST">
        <div class="modern_form">
          <div class="form_row">
            <div class="fieldname">Адрес электронной почты:</div>
            <div class="control">
              <input type="email" name="email" class="ui-input" maxlength="32" placeholder="example@mail.ru" required="">
            </div>
          </div>
          <div class="hr"></div>
          <div class="form_row">
            <div class="fieldname">Пароль:</div>
            <div class="control">
              <input type="password" name="password" class="ui-input" id="js_password_input" maxlength="32" autocomplete="off" required="">
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
              <button type="submit" class="btn">Войти</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>