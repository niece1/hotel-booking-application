@extends('layouts.app') 

@section('content') 
<section class="objects-list">


    <h1 class="text-center">Available rooms</h1>

    @foreach( $city->rooms->chunk(4) as $chunked_rooms ) 

    <div class="objects-list-wrapper">

            @foreach( $chunked_rooms as $room ) 

                

            <div class="item-holder">
                        <img class="img-responsive" src="{{ $room->shots->first()->path ?? $placeholder  }}" alt="...">
                        <div class="caption">
                            <h3>Nr {{ $room->room_number  }} <small class="orange bolded">{{ $room->price  }}$</small> </h3>
                            <p>{{ str_limit($room->description,80)  }}</p>
                            <p><a href="{{ route('room',['id'=>$room->id]) }}" class="btn btn-primary" role="button">Подробнее</a><a href="{{ route('room',['id'=>$room->id]) }}#reservation" class="btn btn-success pull-right" role="button">Зарезервировать</a></p>
                        </div>
                    </div>
                

            @endforeach 


        </div>

    @endforeach 
</section>
@endsection