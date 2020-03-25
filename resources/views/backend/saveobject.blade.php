@extends('layouts.backend')

@section('content')

@if( $object ?? false ) <?php /* = if( isset($object) && $object != false) */ ?>
<h2 style="margin-top: 80px;">Редактировать объект {{ $object->name }}</h2>
@else
<h2 style="margin-top: 80px;">Добавить новый объект</h2>
@endif

<form {{ $novalidate }} method="POST" enctype="multipart/form-data" class="form-horizontal" action="{{ route('saveObject',['id'=>$object->id ?? null]) /* Lecture 44 */ }}">
    <fieldset>
        <div class="form-group">
            <label for="city" class="col-lg-2 control-label">Город</label>
            <div class="col-lg-10">

                <select name="city" class="form-control" id="city">

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
            <label for="name" class="col-lg-2 control-label">Название</label>
            <div class="col-lg-10">
                <input name="name" required type="text" value="{{ $object->name ?? old('name')  }}" class="form-control" id="name" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="street" class="col-lg-2 control-label">Улица</label>
            <div class="col-lg-10">
                <input name="street" required type="text" value="{{ $object->address->street ?? old('street')  }}" class="form-control" id="street" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="number" class="col-lg-2 control-label">Номер дома</label>
            <div class="col-lg-10">
                <input name="number" required type="number" value="{{ $object->address->number ?? old('number')  }}" class="form-control" id="number" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="descr" class="col-lg-2 control-label">Описание</label>
            <div class="col-lg-10">
                <textarea name="description" required class="form-control" rows="3" id="descr">{{ $object->description ?? old('description')  }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="objectPictures">Фото отеля</label>
                <input type="file" name="objectPictures[]" id="objectPictures" multiple>
                <p class="help-block" style="color: #ee2852; margin-top: 15px;">Добавить фото отеля</p>
            </div>
        </div>

        @if( $object ?? false )

        <div class="col-lg-10 col-lg-offset-2">

            @foreach( $object->shots->chunk(4) as $chunked_shots )

            <div class="row">

                @foreach( $chunked_shots as $shot )

                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail">
                        <img class="img-responsive" src="{{ $shot->path ?? $placeholder  }}" alt="...">
                        <div class="caption">
                            <p><a href="{{ route('deleteShot',['id'=>$shot->id])  }}" class="btn btn-primary btn-xs" role="button">Удалить</a></p>
                        </div>

                    </div>
                </div>

                @endforeach

            </div>

            @endforeach

        </div>

        <div class="col-lg-10 col-lg-offset-2">
            Articles:
            <ul class="list-group">
                @foreach( $object->articles as $article )

                <li class="list-group-item">
                    {{ $article->title  }} <a href="{{ route('deleteArticle',['id'=>$article->id]) }}">удалить</a>
                </li>
                @endforeach

            </ul>
        </div>
        @endif


        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Сохранить объект</button>
            </div>
        </div>

    </fieldset>
    @csrf
</form>

<div class="col-lg-10 col-lg-offset-2">

    <form {{$novalidate }} method="POST" class="form-horizontal" action="{{ route('saveArticle',['id'=>$object->id ?? null]) }}">
        <fieldset>

            <div class="form-group">
                <label for="textTitle" class="col-lg-2 control-label">Название</label>
                <div class="col-lg-10">
                    <input name="title" value="{{ old('title') }}" required type="text" class="form-control" id="textTitle" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">Описание</label>
                <div class="col-lg-10">
                    <textarea name="content" required class="form-control" rows="3" id="textArea">{{ old('content') }}</textarea>
                    <span class="help-block" style="color: #ee2852;">Добавить статью о вашем объекте</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </fieldset>
        @csrf
    </form>

</div>
@endsection