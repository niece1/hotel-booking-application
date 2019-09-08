/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(function () {
    $(".datepicker").datepicker();
});


$(function () {
    $(".autocomplete").autocomplete({
        source: base_url + "/searchCities", /* Lecture 17 */
        minLength: 2,
        select: function (event, ui) {
            
//            console.log(ui.item.value);
        }


    });
});



//room.php
var eventDates = {};
var dates = ['02/15/2018', '02/16/2018', '02/25/2018'];
for (var i = 0; i <= dates.length; i++)
{
    eventDates[ new Date(dates[i])] = new Date(dates[i]);
}


$(function () {
    $("#avaiability_calendar").datepicker({
        onSelect: function (data) {

//            console.log($('#checkin').val());

            if ($('#checkin').val() == '')
            {
                $('#checkin').val(data);
            } else if ($('#checkout').val() == '')
            {
                $('#checkout').val(data);
            } else if ($('#checkout').val() != '')
            {
                $('#checkin').val(data);
                $('#checkout').val('');
            }

        },
        beforeShowDay: function (date)
        {
            //console.log(date);
            if (eventDates[date])
                return [false, 'unavaiable_date'];
            else
                return [true, ''];
        }


    });
});
