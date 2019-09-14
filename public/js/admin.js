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
  }
};
/* Lecture 30 */

var App = {
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
    }
  }
};
$(document).on('click', '.dropdown', function (e) {
  e.stopPropagation();
});
