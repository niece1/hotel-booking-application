@extends('layouts.app')

@section('content')
<div class="article">
    <div class="article-wrapper">
        <h1>Новости <small> <a href="{{ route('object',['id'=>$article->object->id]) }}">{{ $article->object->name  }}</a></small></h1>
        <p>{{ $article->content  }}</p>


        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Лайки <span class="badge">{{ $article->users->count()  }}</span>
        </a>
        <div class="collapse" id="collapseExample">
            <div class="well" style="margin-top: 20px;">

                <ul class="list-inline">
                    @foreach( $article->users as $user )
                    <li><a href="{{ route('person',['id'=>$user->id]) }}"><img title="{{ $user->FullName  }}" class="img-responsive" width="50" height="50" src="{{ $user->shots->first()->path ?? $placeholder  }}" alt="..."> </a></li>

                    @endforeach
                </ul>


            </div>
        </div>

        <h3 style="color: #ee2852;">Комментарии</h3>

        @foreach( $article->comments as $comment )
        <div class="media">
            <div class="media-left media-top">
                <a href="{{ route('person',['id'=>$comment->user->id]) }}">
                    <img class="media-object" width="50" height="50" src="{{ $comment->user->shots->first()->path ?? $placeholder  }}" alt="...">
                </a>
            </div>
            <div class="media-body">
                {{ $comment->content }}
            </div>
        </div>
        <hr>
        @endforeach

        @auth

        @if( $article->isLiked() )
        <a href="{{ route('unlike',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Unlike</a>
        @else
        <a href="{{ route('like',['id'=>$article->id,'type'=>'App\Article']) }}" class="btn btn-primary btn-xs top-buffer">Like</a>
        @endif
        <br><br>
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
            Добавить комментарий
        </a>
        @else

        <p><a href="{{ route('login') }}">Залогиньтесь, чтобы поставить лайк или комментарий</a></p>

        @endauth



        <div class="collapse" id="collapseExample2">
            <div class="well mt-5" style="margin-top: 20px;">


                <form method="POST" action="{{ route('addComment',['article_id'=>$article->id, 'App\Article']) }}" class="form-horizontal">
                    <fieldset>

                        <div class="form-group">
                            <label for="textArea" class="col-lg-2 control-label">Комментарий</label>
                            <div class="col-lg-10">
                                <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                                <span class="help-block">Добавить комментарий</span>
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

    </div>
</div>
@endsection