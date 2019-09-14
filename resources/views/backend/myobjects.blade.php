@extends('layouts.backend') <!-- Lecture 5 -->

@section('content') <!-- Lecture 5 -->
<h2>List of objects</h2>
@foreach( $objects as $object ) <!-- Lecture 46 -->

    <div class="panel panel-success top-buffer">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $object->name /* Lecture 46 */ }} object <small><a href="{{ route('saveObject',['id'=>$object->id]) /* Lecture 46 */ }}" class="btn btn-danger btn-xs">edit</a> <a href="{{ route('saveRoom').'?object_id='.$object->id /* Lecture 47 */ }}" class="btn btn-danger btn-xs">add a room</a> <a title="delete" href="{{ route('deleteObject',['id'=>$object->id]) /* Lecture 46 */}}"><span class="glyphicon glyphicon-remove"></span></a></small> </h3>
        </div>

        <div class="panel-body">
            @foreach( $object->rooms as $room ) <!-- Lecture 46 -->
                <span class="my_objects">
                    Room {{ $room->room_number /* Lecture 47 */ }} <a title="edit" href="{{ route('saveRoom',['id'=>$room->id]) /* Lecture 47 */ }}"><span class="glyphicon glyphicon-edit"></span></a> <a title="delete" href="{{ route('deleteRoom',['id'=>$room->id]) /* Lecture 47 */ }}"><span class="glyphicon glyphicon-remove"></span></a> </span>
            @endforeach <!-- Lecture 46 -->
        </div>

    </div>

@endforeach <!-- Lecture 46 -->
@endsection