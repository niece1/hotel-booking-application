@extends('layouts.backend') <!-- Lecture 5 -->

@section('content') <!-- Lecture 5 -->

<!-- Lecture 44 -->
@if( $object ?? false ) <?php /* = if( isset($object) && $object != false) */ ?>
<h2>Editing object {{ $object->name }}</h2>
@else
<h2>Adding a new object</h2>
@endif

<form {{ $novalidate /* Lecture 44 */}} method="POST" enctype="multipart/form-data" class="form-horizontal" action="{{ route('saveObject',['id'=>$object->id ?? null]) /* Lecture 44 */ }}">
    <fieldset>
        <div class="form-group">
            <label for="city" class="col-lg-2 control-label">City *</label>
            <div class="col-lg-10">
                
                <select name="city" class="form-control" id="city">
                    
                    <!-- Lecture 44 -->
                    @foreach($cities as $city)
                        @if( ($object ?? false) && $object->city->id == $city->id )
                        <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                        @else
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endif
                    @endforeach
                    
                </select>
                
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Name *</label>
            <div class="col-lg-10">
                <input name="name" required type="text" value="{{ $object->name ?? old('name') /* Lecture 44 */ }}" class="form-control" id="name" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="street" class="col-lg-2 control-label">Street *</label>
            <div class="col-lg-10">
                <input name="street" required type="text" value="{{ $object->address->street ?? old('street') /* Lecture 44 */ }}" class="form-control" id="street" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="number" class="col-lg-2 control-label">Number *</label>
            <div class="col-lg-10">
                <input name="number" required type="number" value="{{ $object->address->number ?? old('number') /* Lecture 44 */ }}" class="form-control" id="number" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="descr" class="col-lg-2 control-label">Object description *</label>
            <div class="col-lg-10">
                <textarea name="description" required class="form-control" rows="3" id="descr">{{ $object->description ?? old('description') /* Lecture 44 */ }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="objectPictures">Object gallery</label>
                <input type="file" name="objectPictures[]" id="objectPictures" multiple>
                <p class="help-block">Add a photo gallery of the object</p>
            </div>
        </div>

        @if( $object ?? false ) <!-- Lecture 44 -->
        <div class="col-lg-10 col-lg-offset-2">

            @foreach( $object->shots->chunk(4) as $chunked_shots ) <!-- Lecture 44 -->

                <div class="row">


                    @foreach( $chunked_shots as $shot ) <!-- Lecture 44 -->

                        <div class="col-md-3 col-sm-6">
                            <div class="thumbnail">
                                <img class="img-responsive" src="{{ $shot->path ?? $placeholder /* Lecture 44 */ }}" alt="...">
                                <div class="caption">
                                    <p><a href="{{ route('deleteShot',['id'=>$shot->id]) /* Lecture 44 */ }}" class="btn btn-primary btn-xs" role="button">Delete</a></p>
                                </div>

                            </div>
                        </div>

                    @endforeach <!-- Lecture 44 -->

                </div>


            @endforeach <!-- Lecture 44 -->

        </div>

        <div class="col-lg-10 col-lg-offset-2">
            Articles:
            <ul class="list-group">
                @foreach( $object->articles as $article ) <!-- Lecture 44 -->
                    <li class="list-group-item">
                        {{ $article->title /* Lecture 44 */ }} <a href="{{ route('deleteArticle',['id'=>$article->id]) /* Lecture 44 */ }}">delete</a>
                    </li>
                @endforeach <!-- Lecture 44 -->

            </ul>
        </div>
        @endif <!-- Lecture 44 -->

        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Save object</button>
            </div>
        </div>

    </fieldset>
    {{ csrf_field() /* Lecture 44 */ }}
</form>

<div class="col-lg-10 col-lg-offset-2">

    <form {{$novalidate /* Lecture 44 */}} method="POST" class="form-horizontal" action="{{ route('saveArticle',['id'=>$object->id ?? null]) /* Lecture 44 */}}">
        <fieldset>

            <div class="form-group">
                <label for="textTitle" class="col-lg-2 control-label">Title *</label>
                <div class="col-lg-10">
                    <input name="title" value="{{ old('title') /* Lecture 44 */ }}" required type="text" class="form-control" id="textTitle" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">Content *</label>
                <div class="col-lg-10">
                    <textarea name="content" required class="form-control" rows="3" id="textArea">{{ old('content') /* Lecture 44 */}}</textarea>
                    <span class="help-block">Add an article about this object.</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </fieldset>
        {{ csrf_field() /* Lecture 44 */ }}
    </form>

</div>
@endsection