@extends('layouts.backend')

@section('content')
<h2 style="margin-top: 80px;">Данные пользователя</h2>
<form {{ $novalidate  }} action="{{ route('profile')  }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <fieldset>
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Имя</label>
            <div class="col-lg-10">
                <input name="name" type="text" required class="form-control" id="name" value="{{ $user->name  }}">
            </div>
        </div>
        <div class="form-group">
            <label for="surname" class="col-lg-2 control-label">Фамилия</label>
            <div class="col-lg-10">
                <input name="surname" type="text" required class="form-control" id="surname" value="{{ $user->surname  }}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                <input name="email" type="email" required class="form-control" id="inputEmail" value="{{ $user->email  }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="userPicture">Добавьте ваше фото</label>
                <input name="userPicture" type="file" id="userPicture">
            </div>
        </div>

        @if( $user->shots->first() )
        <div class="col-lg-10 col-lg-offset-2">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail">
                        <img class="img-responsive" src="{{ $user->shots->first()->path ?? $placeholder  }}" alt="...">
                        <div class="caption">
                            <p><a href="{{ route('deleteShot',['id'=>$user->shots->first()->id])  }}" class="btn btn-primary btn-xs" role="button">Удалить</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </fieldset>
    @csrf
</form>
@endsection