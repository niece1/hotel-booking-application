@extends('layouts.app')

@section('content')
<div class="object">
    <div class="object-wrapper">
        <h1 class="text-center">{{ $object->name }} object <small>{{ $object->city->name }} </small></h1>

        <p style="padding: 0 0 10px 0;">{{ $object->description }} </p>


        <ul class="nav nav-tabs ">
            <li class="active"><a href="#gallery" data-toggle="tab" aria-expanded="true">Галлерея</a></li>
            <li><a href="#people" data-toggle="tab" aria-expanded="true">Лайки<span class="badge" style="margin-left: 3px;">{{ $object->users->count() }} </span></a></li>
            <li><a href="#adress" data-toggle="tab" aria-expanded="false">Aдрес</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in " id="gallery">

                @foreach($object->shots->chunk(3) as $chunked_shots)

                <div class="row">

                    @foreach($chunked_shots as $shot)

                    <div class="col-md-4 ">
                        <img class="img-responsive" src="{{ $shot->path ?? $placeholder }}" alt="objects">
                    </div>

                    @endforeach
                </div>

                @endforeach

            </div>
            <div class="tab-pane fade" id="people">

                <ul class="list-inline">
                    @foreach( $object->users as $user)
                    <li><a href="{{ route('person',['id'=>$user->id]) }}"><img title="{{ $user->FullName  }}" class="media-object img-responsive" width="50" height="50" src="{{ $user->shots->first()->path ?? $placeholder  }}" alt="..."> </a></li>

                    @endforeach
                </ul>


            </div>
            <div class="tab-pane fade" id="adress">
                <p style="margin-top: 10px">{{ $object->address->street }} {{ $object->address->number }} </p>
            </div>
        </div>

        <section>

            <h2 class="text-center">Номера отеля</h2>

            @foreach($object->rooms->chunk(4) as $chunked_rooms)

            <div class="row">

                @foreach($chunked_rooms as $room)

                <div class="col-md-3 col-sm-6">

                    <div class="thumbnail">
                        <img class="img-responsive" src="{{ $room->shots->first()->path ?? $placeholder  }}" alt="...">
                        <div class="caption">
                            <h4>Номер {{ $room->room_number}} </h4>
                            <p>{{ str_limit($room->description,70) }} </p>
                            <p><a href="{{ route('room',['id'=>$room->id]) }}" class="btn btn-primary" role="button">Подробнее</a><a href="{{ route('room',['id'=>$room->id]) }}#reservation" class="btn btn-success pull-right" role="button">Зарезервировать</a></p>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>

            @endforeach

        </section>

        <section>
            <h3 style="color: #ee2852">Комментарии и рейтинг объекта</h3>
            @foreach( $object->comments as $comment )
            <div class="media">
                <div class="media-left media-top">
                    <a title="{{ $comment->user->FullName  }}" href="{{ route('person',['id'=>$comment->user->id]) }}">
                        <img class="media-object" width="50" height="50" src="{{ $comment->user->shots->first()->path ?? $placeholder  }}" alt="...">
                    </a>
                </div>
                <div class="media-body">
                    {{ $comment->content }}
                    {!! $comment->rating !!}
                </div>
            </div>
            <hr>
            @endforeach
        </section>

        @auth
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Добавить комментарий
        </a>
        @else
        <p><a href="{{ route('login') }}">Залогиньтесь, чтобы добавить комментарий</a></p>
        @endauth

        <div class="collapse" id="collapseExample">
            <div class="well" style="margin-top: 20px;">


                <form method="POST" action="{{ route('addComment',['object_id'=>$object->id, 'App\TouristObject']) }}" class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Комментарий</label>
                            <div class="col-lg-10">
                                <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                                <span class="help-block">Добавьте комментарий</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select" class="col-lg-2 control-label">Рейтинг</label>
                            <div class="col-lg-10">
                                <select name="rating" class="form-control" id="select">
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </div>
                        </div>
                    </fieldset>
                    @csrf
                </form>

            </div>
        </div>

        <section>
            <h3 style="color: #ee2852">Новости отеля</h3>
            @foreach($object->articles as $article)
            <div class="articles-list">
                <h3>{{ $article->title }} </h3>
                <p><b> {{ $article->user->FullName }} </b>
                    <i>{{ $article->created_at }} </i>
                </p>
                <p>{{ str_limit($article->content,250) }} </p> <a href="{{ route('article',['id'=>$article->id]) }}">Читать</a>
            </div>

            @endforeach
        </section>

        @auth

        @if( $object->isLiked() )
        <a href="{{ route('unlike',['id'=>$object->id,'type'=>'App\TouristObject']) }}" class="btn btn-danger btn-xs top-buffer">Unlike</a>
        @else
        <a href="{{ route('like',['id'=>$object->id,'type'=>'App\TouristObject']) }}" class="btn btn-success btn-xs top-buffer">Like</a>
        @endif

        @else

        <p><a href="{{ route('login') }}">Залогиньтесь, чтобы лайкнуть статью</a></p>

        @endauth
    </div>
</div>
@endsection