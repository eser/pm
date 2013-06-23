(function() {
  var LoginManager,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  LoginManager = (function() {

    function LoginManager(container) {
      var action;
      this.container = container;
      this.hideAll = __bind(this.hideAll, this);

      this.showForgotForm = __bind(this.showForgotForm, this);

      this.showRegisterForm = __bind(this.showRegisterForm, this);

      this.showLoginForm = __bind(this.showLoginForm, this);

      this.loginForm = this.container.find("#login");
      this.registerForm = this.container.find("#register");
      this.forgotForm = this.container.find("#forgot");
      this.loginLink = this.container.find("#login-link");
      this.forgotLink = this.container.find("#forgot-link");
      this.registerLink = this.container.find("#register-link");
      this.loginLink.bind("click", this.showLoginForm);
      this.forgotLink.bind("click", this.showForgotForm);
      this.registerLink.bind("click", this.showRegisterForm);
      this.loginSubmit = this.container.find("#login-submit");
      this.loginSubmit.click(function(e) {
        var wrapper;
        if ($(this).closest("form").find("#email").val().length === 0) {
          e.preventDefault();
          wrapper = $(this).closest(".login-wrapper");
          wrapper.addClass("wobble");
          Notifications.push({
            text: "<i class='icon-warning-sign'></i> invalid username or password",
            autoDismiss: 3,
            "class": "error"
          });
          return wrapper.bind("webkitAnimationEnd animationEnd mozAnimationEnd", function() {
            wrapper.off("webkitAnimationEnd");
            return wrapper.removeClass("wobble");
          });
        }
      });
      action = this.getParameterByName("action");
      if (action === 'register') {
        this.showRegisterForm();
      } else if (action === 'forgot-password') {
        this.showForgotForm();
      } else {
        this.showLoginForm();
      }
    }

    LoginManager.prototype.showLoginForm = function() {
      this.hideAll();
      this.loginForm.show();
      this.registerLink.show();
      return this.forgotLink.show();
    };

    LoginManager.prototype.showRegisterForm = function() {
      this.hideAll();
      this.registerForm.show();
      this.loginLink.show();
      return this.forgotLink.show();
    };

    LoginManager.prototype.showForgotForm = function() {
      this.hideAll();
      this.forgotForm.show();
      this.loginLink.show();
      return this.registerLink.show();
    };

    LoginManager.prototype.hideAll = function() {
      this.loginForm.hide();
      this.registerForm.hide();
      this.forgotForm.hide();
      this.loginLink.hide();
      this.forgotLink.hide();
      return this.registerLink.hide();
    };

    LoginManager.prototype.getParameterByName = function(name) {
      var regex, regexS, results;
      name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
      regexS = "[\\?&]" + name + "=([^&#]*)";
      regex = new RegExp(regexS);
      results = regex.exec(window.location.search);
      if (results === null) {
        return "";
      } else {
        return decodeURIComponent(results[1].replace(/\+/g, " "));
      }
    };

    return LoginManager;

  })();

  $(function() {
    return new LoginManager($("#login-manager"));
  });

}).call(this);
