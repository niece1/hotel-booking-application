@extends('layouts.app') 

@section('content') 
<div class="container places">
    <h1 class="text-center">Room in <a href="{{ route('object',['room'=>$room->object_id]) }}">{{ $room->object->name  }}</a> object</h1>

    @foreach( $room->shots->chunk(3) as $chunked_shots ) 
        <div class="row top-buffer">
            
            @foreach($chunked_shots as $shot)
            
            <div class="col-md-4">
                <img class="img-responsive" src="{{ $shot->path ?? $placeholder  }}" alt="">
            </div>
            
            @endforeach 

        </div>

   @endforeach 


    <section>

        <ul class="list-group">
            <li class="list-group-item">
                <span class="bolded">Description:</span> {{ $room->description }}
            </li>
            <li class="list-group-item">
                <span class="bolded">Room size:</span> {{ $room->room_size }}
            </li>
            <li class="list-group-item">
                <span class="bolded">Price per night:</span> {{ $room->price }} USD
            </li>
            <li class="list-group-item">
                <span class="bolded">Address:</span> {{ $room->object->city->name /* Lecture 20 */ }} {{ $room->object->address->street }} nr {{ $room->object->address->number }}
            </li>
        </ul>
    </section>

    <section id="reservation">

        <h3>Reservation</h3>

        <div class="row">
            <div class="col-md-6">
                <form method="POST" {{ $novalidate }} action="{{ route('makeReservation',['room_id'=>$room->id,'city_id'=>$room->object->city->id]) }}">
                    <div class="form-group">
                        <label for="checkin">Check in</label>
                        <input required name="checkin" type="text" class="form-control datepicker" id="checkin" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="checkout">Check out</label>
                        <input required name="checkout" type="text" class="form-control datepicker" id="checkout" placeholder="">
                    </div>
                    @if(Auth::guest())
                    <p><a href="{{ route('login') }}">Log in to make a reservation</a></p>
                    @else
                    <button type="submit" class="btn btn-primary">Book</button>
                    @endif 
                    <p class="text-danger">{{ Session::get('reservationMsg') }}</p>
                    @csrf
                </form>
            </div><br>
            <div class="col-md-6">
                <div id="avaiability_calendar"></div>
            </div>
        </div>


    </section>

</div>
@endsection <!-- Lecture 5  -->

@push('scripts') <!-- Lecture 20 -->

<!-- Lecture 20 -->
<script>
    function datesBetween(startDt, endDt) {
    var between = [];
    var currentDate = new Date(startDt);
    var end = new Date(endDt);
    while (currentDate <= end)
    {
        between.push( $.datepicker.formatDate('mm/dd/yy',new Date(currentDate)) );
        currentDate.setDate(currentDate.getDate() + 1);
    }

        return between;
}
    
$.ajax({

    cache: false,
    url: base_url + '/ajaxGetRoomReservations/' + {{ $room->id }},
    type: "GET",
    success: function(response){


        var eventDates = {};
        var dates = [/* Lecture 21 */];
        
        /* Lecture 21 */
        for(var i = 0; i <= response.reservations.length - 1; i++)
        {
            dates.push(datesBetween(new Date(response.reservations[i].day_in), new Date(response.reservations[i].day_out))); // array of arrays
        }
        
        
        /*  a = [1];
            b = [2];
            x = a.concat(b);
            x = [1,2];
            [ [1],[2],[3] ] => [1,2,3]  */
        dates = [].concat.apply([], dates); /* Lecture 21 */   // flattened array

        /* Lecture 21 */
        for (var i = 0; i <= dates.length - 1; i++)
        {
            eventDates[dates[i]] = dates[i];
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
                    var tmp =  eventDates[$.datepicker.formatDate('mm/dd/yy', date)]; /* Lecture 21 */
                    //console.log(date);
                    if (tmp)
                        return [false, 'unavaiable_date'];
                    else
                        return [true, ''];
                }


            });
        });


    }


});
    
</script>

@endpush