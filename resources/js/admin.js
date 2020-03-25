function datesBetween(startDt, endDt) {
    var between = [];
    var currentDate = new Date(startDt);
    var end = new Date(endDt);
    while (currentDate <= end) {
        between.push( $.datepicker.formatDate('mm/dd/yy',new Date(currentDate)) );
        currentDate.setDate(currentDate.getDate() + 1);
    }

    return between;
}

var Ajax = {

    get: function (url, success, data = null, beforeSend = null) {

        $.ajax({

            cache: false,
            url: base_url + '/' + url,
            type: "GET",
            data: data,
            success: function(response){
                
            App[success](response);
                
            },
            beforeSend: function(){
               
            if(beforeSend)    
            App[beforeSend]();
                
            }

        });
    },
    
    set: function (data = {}, url, success = null) {

        $.ajax({

            cache: false,
            url: base_url + '/' + url,
            type: "GET",
            dataType: "json",
            data: data,
            success: function(response){
            
            if(success)     
            App[success](response);
                
            }

        });
    }


};

var App = {
    
    timestamp: null, 
    
    idsOfNotShownNotifications: [], 

    GetReservationData: function (id, calendar_id, date) {

        App.calendar_id = calendar_id; 
        Ajax.get('ajaxGetReservationData?fromWebApp=1', 'AfterGetReservationData',{room_id: id, date: date},'BeforeGetReservationData');         

    },
    BeforeGetReservationData: function() {        
       
    $('.loader_' + App.calendar_id).hide(); 
    $('.hidden_' + App.calendar_id).show();         
  
    },

    AfterGetReservationData: function(response) {
        
        
        $('.hidden_' + App.calendar_id + " .reservation_data_room_number").html(response.room_number); 
        
        $('.hidden_' + App.calendar_id + " .reservation_data_day_in").html(response.day_in); 
        $('.hidden_' + App.calendar_id + " .reservation_data_day_out").html(response.day_out); 
        $('.hidden_' + App.calendar_id + " .reservation_data_person").html(response.FullName); 
        $('.hidden_' + App.calendar_id + " .reservation_data_person").attr('href', response.userLink); 
        $('.hidden_' + App.calendar_id + " .reservation_data_delete_reservation").attr('href', response.deleteResLink); 

        if (response.status)
        {
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('href');
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('disabled', 'disabled');

        } else
        {
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").attr('href', response.confirmResLink);
            $('.hidden_' + App.calendar_id + " .reservation_data_confirm_reservation").removeAttr('disabled'); 
        }
        
    },
    
    SetReadNotification: function (id) {

        Ajax.set({id: id}, 'ajaxSetReadNotification?fromWebApp=1');
    },
    
    GetNotShownNotifications: function() {

        Ajax.get("ajaxGetNotShownNotifications?fromWebApp=1&timestamp=" + App.timestamp, 'AfterGetNotShownNotifications');
        
    },

    AfterGetNotShownNotifications: function(response) {
        
        var json = JSON.parse(response); 

        App.timestamp = json['timestamp']; 
        setTimeout(App.GetNotShownNotifications(), 100); 

        if (jQuery.isEmptyObject(json['notifications']))
            return;


        $('#app-notifications-count').show(); 
        $('#app-notifications-count').removeClass('hidden'); 
   
        for (var i = 0; i <= json['notifications'].length - 1; i++)
        {
            App.idsOfNotShownNotifications.push(json['notifications'][i].id);

            $('#app-notifications-count').html(parseInt($('#app-notifications-count').html()) + 1);
            $("#app-notifications-list").append('<li class="unread_notification"><a href="' + json['notifications'][i].id + '">' + json['notifications'][i].content + '</a></li>');
        }


        App.SetShownNotifications(App.idsOfNotShownNotifications); 
        
        
    },
    
    SetShownNotifications: function (ids) {

        Ajax.set({idsOfNotShownNotifications: ids}, 'ajaxSetShownNotifications?fromWebApp=1');

    }


};

$(document).on('click', '.dropdown', function (e) {
    e.stopPropagation();
});

$(document).on("click", ".unread_notification", function (event) {
    
    event.preventDefault();

    $(this).removeClass('unread_notification');

    var ncount = parseInt($('#app-notifications-count').html());

    if (ncount > 0)
    {
        $('#app-notifications-count').html(ncount - 1);

        if (ncount == 1)
        $('#app-notifications-count').hide();
    }

    var idOfNotification = $(this).children().attr('href');
    $(this).children().removeAttr('href');
    App.SetReadNotification(idOfNotification);

});

$(function () {
    
App.GetNotShownNotifications();

});