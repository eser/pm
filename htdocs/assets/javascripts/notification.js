(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  this.Notification = (function() {

    function Notification(template, options) {
      var _this = this;
      this.template = template;
      this.options = options;
      this.dismiss = __bind(this.dismiss, this);

      this.item = {};
      this.item.imagePath = this.options.imagePath;
      this.item.imageClass = "img";
      if (this.options.fillImage === true) {
        this.item.imageClass += " fill";
      } else {
        this.item.imageClass += " border";
      }
      this.item.text = this.options.text;
      this.item.time = this.options.time;
      if (this.options.imagePath == null) {
        this.item.itemClass = " no-image";
      }
      this.view = $(_.template(this.template, {
        item: this.item
      }));
      if (options["class"] != null) {
        this.view.addClass(options["class"]);
      }
      this.hideButton = this.view.find(".hide");
      this.hideButton.bind("click touchend", this.dismiss);
      if (this.options.autoDismiss != null) {
        setTimeout(function() {
          return _this.dismiss();
        }, this.options.autoDismiss * 1000);
      }
    }

    Notification.prototype.dismiss = function() {
      var _this = this;
      return this.view.slideUp().queue(function() {
        _this.options._dismiss(_this, _this.options.dismiss);
        return _this.view.remove();
      });
    };

    return Notification;

  })();

}).call(this);
