(function() {

  $(function() {
    var _this = this;
    if ($("body").hasClass("login")) {
      Notifications.push({
        imagePath: "../../images/cloud.png",
        text: "<p>Welcome to the Plastique theme!</p><div>Click login to get a WOW wrong username/password effect, or write any username to enter</div> <div>Be sure to check all sections for features!</div>",
        autoDismiss: 10
      });
    } else {
      new Notifications({
        container: $("body"),
        bootstrapPositionClass: "span8 offset2"
      });
    }
    $("#notification-full-image").click(function() {
      return Notifications.push({
        imagePath: "../../images/boy_avatar.png",
        fillImage: true,
        text: "<p><b>Hello there</b></p> This is a sample notification that has an image that fills up the left side",
        time: "just now"
      });
    });
    $("#notification-small-image").click(function() {
      return Notifications.push({
        imagePath: "../../images/cloud.png",
        text: "This is a sample notification that has a small image that sits centered on the left",
        time: "a few seconds ago"
      });
    });
    $("#notification-callback").click(function() {
      return Notifications.push({
        imagePath: "../../images/cloud.png",
        text: "<p><b>Hello there</b></p> This notification is registered with a callback when dismissed!",
        dismiss: function() {
          return Notifications.push({
            imagePath: "../../images/yodawg.png",
            fillImage: true,
            text: "<p>Yo dawg, I heard you like notifications, so when you dismissed that notification we registered another notification in your notification so you can read your new notification after you dismiss the first notification</p>",
            time: "a few seconds ago"
          });
        }
      });
    });
    return $("#notification-auto-dismiss").click(function() {
      return Notifications.push({
        imagePath: "../../images/cloud.png",
        text: "<p><b>Good day sire</b> This notification will expire in 5 seconds</p>",
        autoDismiss: 5
      });
    });
  });

}).call(this);
