(function() {

  this.Faq = (function() {

    function Faq(container) {
      var el, i, link, question, _i, _j, _k, _len, _len1, _len2, _ref, _ref1, _ref2,
        _this = this;
      this.container = container;
      this.questionList = this.container.find("> li");
      this.questions = (function() {
        var _i, _len, _ref, _results;
        _ref = this.container.find("li");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          el = _ref[_i];
          _results.push({
            q: $(el).find("> h4"),
            a: $(el).find("> p")
          });
        }
        return _results;
      }).call(this);
      this.searchInput = $("<input type='text' id='faq-search' class='fill-up' placeholder='enter keyword here...'/>");
      this.container.before(this.searchInput);
      i = 0;
      this.toc = (function() {
        var _i, _len, _ref, _results;
        _ref = this.questions;
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          el = _ref[_i];
          _results.push($("<li><span class='faq-number'>" + (++i) + "</span> <a href='#faq-question-" + i + "'>" + (el.q.text()) + "</a></li>"));
        }
        return _results;
      }).call(this);
      i = 0;
      _ref = this.questions;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        el = _ref[_i];
        el.q.attr("id", "faq-question-" + (++i));
      }
      this.tocLinksContainer = $("<ol class='faq-questions'></ol>");
      _ref1 = this.toc;
      for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
        link = _ref1[_j];
        this.tocLinksContainer.append(link);
      }
      this.searchInput.after(this.tocLinksContainer);
      this.tocLinksContainer.find("a").click(function(e) {
        var scrollTo;
        e.preventDefault();
        link = $(this);
        scrollTo = $(link.attr("href"));
        container = $("#main");
        return container.scrollTop(scrollTo.offset().top - container.offset().top + container.scrollTop());
      });
      this.tocLinksContainer.after("<hr/>");
      i = 0;
      _ref2 = this.questions;
      for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
        question = _ref2[_k];
        question.q.prepend("<span class='faq-number'>" + (++i) + "</span>");
      }
      this.tocLinks = this.tocLinksContainer.find("li");
      this.searchInput.keyup(function() {
        var val;
        val = _this.searchInput.val();
        if (val.length > 0) {
          return _this.questionList.each(function(index, li) {
            var pattern;
            el = $(li);
            pattern = new RegExp(val, 'i');
            if (!pattern.test(el.text())) {
              el.hide();
              return $(_this.tocLinks[index]).hide();
            } else {
              el.show();
              return $(_this.tocLinks[index]).show();
            }
          });
        } else {
          _this.questionList.each(function() {
            return $(this).show();
          });
          return _this.tocLinks.each(function() {
            return $(this).show();
          });
        }
      });
    }

    return Faq;

  })();

}).call(this);
