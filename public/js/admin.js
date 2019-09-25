function datesBetween(startDt, endDt) {
  var between = [];
  var currentDate = new Date(startDt);
  var end = new Date(endDt);

  while (currentDate <= end) {
    between.push($.datepicker.formatDate('mm/dd/yy', new Date(currentDate)));
    currentDate.setDate(currentDate.getDate() + 1);
  }

  return between;
}
/* Lecture 30 */


var Ajax = {
  get: function get(url, _success) {
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

    var _beforeSend = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

    $.ajax({
      cache: false,
      url: base_url + '/' + url,
      type: "GET",
      data: data,
      success: function success(response) {
        App[_success](response);
      },
      beforeSend: function beforeSend() {
        if (_beforeSend) App[_beforeSend]();
      }
    });
  },

  /* Lecture 50 */
  set: function set() {
    var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var url = arguments.length > 1 ? arguments[1] : undefined;

    var _success2 = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;

    $.ajax({
      cache: false,
      url: base_url + '/' + url,
      type: "GET",
      dataType: "json",
      data: data,
      success: function success(response) {
        if (_success2) App[_success2](response);
      }
    });
  }
};
/* Lecture 30 */

var App = {
  timestamp: null,

  /* Lecture 51 */
  idsOfNotShownNotifications: [],

  /* Lecture 52 */
  GetReservationData: function GetReservationData(id, calendar_id
  /* Lecture 32 */
  , date) {
    App.calendar_id = calendar_id;
    /* Lecture 32 */

    Ajax.get('ajaxGetReservationData?fromWebApp=1', 'AfterGetReservationData', {
      room_id: id,
      date: date
    }, 'BeforeGetReservationData');
    /* Lecture 31 ?fromWebApp=1 */
  },
  BeforeGetReservationData: function BeforeGetReservationData() {
    $('.loader_' + App.calendar_id).hide();
    /* Lecture 32 */

    $('.hidden_' + App.calendar_id).show();
    /* Lecture 32 */
  },
  AfterGetReservationData: function AfterGetReservationData(response) {
    $('.hidden_' + App.calendar_id + " .reservation_data_room_number").html(response.room_number);
    /* Lecture 32 */

    $('.hidden_' + App.calendar_id + " .reservation_data_day_in").html(response.day_in);
    /* Lecture 33 */

    $('.hidden_' + App.calendar_id + " .reservation_data_day_out").html(response.day_out);
    /* Lecture 33 */

    $('.hidden_' + App.calendar_id + " .reservation_data_person").html(response.FullName);
    /* Lecture 33 */

    $('.hidden_' + App.calendar_id + " .reservation_data_person").attr('href', response.userLink);
    /* Lecture 33 */

    $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").attr('href', response.deleteResLink);
    /* Lecture 33 */

    /* Lecture 33 */

    if (response.status) {
      $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('href');
      $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('disabled', 'disabled');
    } else {
      $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('href', response.confirmResLink);
      $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('disabled');
      /* Lecture 62 */
    }
  },

  /* Lecture 50 */
  SetReadNotification: function SetReadNotification(id) {
    Ajax.set({
      id: id
    }, 'ajaxSetReadNotification?fromWebApp=1');
  },

  /* Lecture 50 */
  GetNotShownNotifications: function GetNotShownNotifications() {
    /* Lecture 51 */
    Ajax.get("ajaxGetNotShownNotifications?fromWebApp=1&timestamp=" + App.timestamp, 'AfterGetNotShownNotifications');
  },

  /* Lecture 51 */
  AfterGetNotShownNotifications: function AfterGetNotShownNotifications(response) {
    var json = JSON.parse(response);
    /* Lecture 52 */

    App.timestamp = json['timestamp'];
    /* Lecture 52 */

    setTimeout(App.GetNotShownNotifications(), 100);
    /* Lecture 52 */

    /* Lecture 52 */

    if (jQuery.isEmptyObject(json['notifications'])) return;
    $('#app-notifications-count').show();
    /* Lecture 52 */

    $('#app-notifications-count').removeClass('hidden');
    /* Lecture 52 */

    /* Lecture 52 */

    for (var i = 0; i <= json['notifications'].length - 1; i++) {
      App.idsOfNotShownNotifications.push(json['notifications'][i].id);
      $('#app-notifications-count').html(parseInt($('#app-notifications-count').html()) + 1);
      $("#app-notifications-list").append('<li class="unread_notification"><a href="' + json['notifications'][i].id + '">' + json['notifications'][i].content + '</a></li>');
    }

    App.SetShownNotifications(App.idsOfNotShownNotifications);
    /* Lecture 52 */
  },

  /* Lecture 52 */
  SetShownNotifications: function SetShownNotifications(ids) {
    Ajax.set({
      idsOfNotShownNotifications: ids
    }, 'ajaxSetShownNotifications?fromWebApp=1');
  }
};
/* Lecture 34 */

$(document).on('click', '.dropdown', function (e) {
  e.stopPropagation();
});
/* Lecture 50 */

$(document).on("click", ".unread_notification", function (event) {
  event.preventDefault();
  $(this).removeClass('unread_notification');
  var ncount = parseInt($('#app-notifications-count').html());

  if (ncount > 0) {
    $('#app-notifications-count').html(ncount - 1);
    if (ncount == 1) $('#app-notifications-count').hide();
  }

  var idOfNotification = $(this).children().attr('href');
  $(this).children().removeAttr('href');
  App.SetReadNotification(idOfNotification);
});
/* Lecture 50 */

$(function () {
  App.GetNotShownNotifications();
});
