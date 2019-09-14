@extends('layouts.backend') <!-- Lecture 5 -->

@section('content') <!-- Lecture 5 -->

<!-- Lecture 48 -->
@if( $room ?? false )
<h2>Editing the room of the {{ $room->object->name }} object</h2>
@else
<h2>Adding a new room to the object</h2>
@endif

<form {{ $novalidate /* Lecture 48 */ }} action="{{ route('saveRoom',['id'=>$room->id ?? false])/* Lecture 48 */ }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <fieldset>
        <div class="form-group">
            <label for="roomNumber" class="col-lg-2 control-label">Room number *</label>
            <div class="col-lg-10">
                <input name="room_number" value="{{ $room->room_number ?? old('room_number') /* Lecture 48 */ }}" required type="number" class="form-control" id="roomNumber" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="peopleNumber" class="col-lg-2 control-label">Room size *</label>
            <div class="col-lg-10">
                <input name="room_size" value="{{ $room->room_size ?? old('room_size') /* Lecture 48 */ }}" required type="number" class="form-control" id="peopleNumber" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="col-lg-2 control-label">Price *</label>
            <div class="col-lg-10">
                <input name="price" value="{{ $room->price ?? old('price') /* Lecture 48 */ }}" required type="number" class="form-control" id="price" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="descr" class="col-lg-2 control-label">Room description *</label>
            <div class="col-lg-10">
                <textarea name="description" required class="form-control" rows="3" id="descr">{{ $room->description ?? old('description') /* Lecture 48 */ }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="roomPictures">Room gallery</label>
                <input type="file" name="roomPictures[]" id="roomPictures" multiple>
                <p class="help-block">Add a photo gallery of the room</p>
            </div>
        </div>

        @if( $room ?? false ) <!-- Lecture 48 -->
        <div class="col-lg-10 col-lg-offset-2">

            @foreach( $room->shots->chunk(4) as $chunked_shots ) <!-- Lecture 48 -->

                <div class="row">


                    @foreach( $chunked_shots as $shot ) <!-- Lecture 48 -->

                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ $shot->path ?? $placeholder /* Lecture 48 */ }}" alt="...">
                                <div class="caption">
                                    <p><a href="{{ route('deleteShot',['id'=>$shot->id]) /* Lecture 48 */ }}" class="btn btn-primary btn-xs" role="button">Delete</a></p>
                                </div>

                            </div>
                        </div>

                    @endforeach <!-- Lecture 48 -->

                </div>


             @endforeach <!-- Lecture 48 -->


        </div>
        @endif <!-- Lecture 48 -->


        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Save room</button>
            </div>
        </div>

    </fieldset>
    <input type="hidden" name="object_id" value="{{ $object_id ?? null }}"> <!-- Lecture 48 -->
    {{ csrf_field() /* Lecture 48 */ }}
</form>
@endsection