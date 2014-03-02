(function() {
  var PlastiqueDocumentation,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  PlastiqueDocumentation = (function() {

    function PlastiqueDocumentation(container) {
      this.container = container;
      this.menuSelected = __bind(this.menuSelected, this);

      this.menu = this.container.find("#documentation-menu");
      this.listLinks = this.menu.find("li");
      this.links = this.menu.find("a");
      this.links.bind("click", this.menuSelected);
      this.title = this.container.find("#docs-title");
      this.sections = this.container.find("section");
      this.sections.hide();
      this.links.first().trigger("click");
    }

    PlastiqueDocumentation.prototype.menuSelected = function(e) {
      var id, link, title;
      link = $(e.target);
      id = link.attr("data-link");
      title = link.text();
      this.sections.hide();
      this.container.find("#" + id).show();
      this.title.html(title);
      this.listLinks.removeClass("active");
      return link.parent().addClass("active");
    };

    return PlastiqueDocumentation;

  })();

  $(function() {
    return new PlastiqueDocumentation($("#plastique-documentation"));
  });

}).call(this);
