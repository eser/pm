(function() {
  var CalendarEvent, CalendarEvents, ConfirmAction,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  CalendarEvent = (function() {

    function CalendarEvent(container, add) {
      var input;
      this.container = container;
      this.makeFullCalendarEventObject = __bind(this.makeFullCalendarEventObject, this);

      this.handleDoubleClick = __bind(this.handleDoubleClick, this);

      this.finalizeEvent = __bind(this.finalizeEvent, this);

      this.handleInputBlur = __bind(this.handleInputBlur, this);

      this.handleInputKeyup = __bind(this.handleInputKeyup, this);

      this.container.bind("dblclick", this.handleDoubleClick);
      if (add != null) {
        input = this.container.find("input");
        input.focus();
        input.bind("keyup", this.handleInputKeyup);
        input.bind("blur", this.handleInputBlur);
      } else {
        this.makeFullCalendarEventObject();
      }
    }

    CalendarEvent.prototype.handleInputKeyup = function(e) {
      var input;
      input = $(e.target);
      if (e.keyCode === 13) {
        if (input.val().length === 0) {
          return this.container.remove();
        } else {
          return this.finalizeEvent(input.val());
        }
      }
    };

    CalendarEvent.prototype.handleInputBlur = function(e) {
      var input;
      input = $(e.target);
      if (input.val().length === 0) {
        return this.container.remove();
      } else {
        return this.finalizeEvent(input.val());
      }
    };

    CalendarEvent.prototype.finalizeEvent = function(val) {
      this.container.find("a").html(val);
      return this.makeFullCalendarEventObject();
    };

    CalendarEvent.prototype.handleDoubleClick = function(e) {
      var input, link, oldval,
        _this = this;
      input = $("<input type='text'>");
      link = $(e.target);
      oldval = link.text();
      input.val(oldval);
      link.html(input);
      input.focus();
      input.bind("keyup", function(e) {
        if (e.keyCode === 13) {
          if (input.val().length > 0) {
            link.html(input.val());
            return _this.makeFullCalendarEventObject();
          } else {
            return link.html(oldval);
          }
        }
      });
      return input.bind("blur", function(e) {
        if (input.val().length > 0) {
          link.html(input.val());
          return _this.makeFullCalendarEventObject();
        } else {
          return link.html(oldval);
        }
      });
    };

    CalendarEvent.prototype.makeFullCalendarEventObject = function() {
      var eventObject, link;
      link = $(this.container);
      eventObject = {
        title: $.trim(link.text())
      };
      link.data('eventObject', eventObject);
      return link.draggable({
        zIndex: 999,
        revert: true,
        revertDuration: 0
      });
    };

    return CalendarEvent;

  })();

  CalendarEvents = (function() {

    function CalendarEvents(container) {
      this.container = container;
      this.handleAddLink = __bind(this.handleAddLink, this);

      this.addLink = this.container.find("#add-event");
      this.container.find("a.external-event").each(function() {
        return new CalendarEvent($(this));
      });
      this.template = "<li><a class='external-event'><input type='text'></a></li>";
      this.addLink.bind("click", this.handleAddLink);
    }

    CalendarEvents.prototype.handleAddLink = function() {
      var view;
      view = $(this.template);
      view.insertBefore(this.addLink.parent());
      return new CalendarEvent(view, true);
    };

    return CalendarEvents;

  })();

  ConfirmAction = (function() {

    function ConfirmAction(container) {
      var _this = this;
      this.container = container;
      this.link = this.container.find("a[rel='action']");
      this.confirm = this.container.find("[rel='confirm-action']");
      this.link.click(function() {
        return _this.confirm.fadeIn();
      });
      this.cancelLink = this.container.find("a[rel='confirm-cancel']");
      this.confirmLink = this.container.find("a[rel='confirm-do']");
      this.confirmLink.hide();
      this.confirmLink.click(function() {
        return _this.container.slideUp();
      });
      this.confirmCheck = this.container.find("[rel='confirm-check']");
      this.cancelLink.click(function() {
        _this.confirm.fadeOut();
        _this.confirmCheck.removeAttr("checked");
        return _this.confirmLink.hide();
      });
      this.confirmCheck.change(function() {
        if (_this.confirmCheck.attr("checked") === "checked") {
          return _this.confirmLink.fadeIn();
        } else {
          return _this.confirmLink.fadeOut();
        }
      });
    }

    return ConfirmAction;

  })();

  $(function() {
      $.datepicker.setDefaults({
          "dateFormat": "dd/mm/yy"
      });

      $('.tablesorter').tablesorter({
          widgets : [],
          disableSortingOnLastColumn : true
      });

      $(".chzn-select").chosen({
          "disable_search_threshold": 10
      });

      $("html, body").off("touchstart");
    $("#modal-link").click(function() {
      return $('#modal').modal();
    });
    $('.input-error').tooltip();
    $('textarea.tagme').tagify();
    new Faq($(".faq-list"));
    $('.datetimepicker').datepicker();
    new ConfirmAction($("#fix-stats"));
    new ConfirmAction($("#fix-stats2"));
    new CalendarEvents($('#external-events'));
    $('.data-table').dataTable({
      "bJQueryUI": true,
      "sPaginationType": "full_numbers",
      "sDom": '<""l>t<"F"fp>'
    });
    return $("#calendar").fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      editable: true,
      droppable: true,
      drop: function(date, allDay) {
        var copiedEventObject, originalEventObject;
        originalEventObject = $(this).data('eventObject');
        copiedEventObject = $.extend({}, originalEventObject);
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        $("#calendar").fullCalendar('renderEvent', copiedEventObject, true);
        if ($("#drop-remove").is(":checked")) {
          return $(this).remove();
        }
      }
    });
  });

}).call(this);
