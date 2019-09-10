@extends('layouts.app') 

@section('content') 
<div class="container">

    <h1>Article <small>about: <a href="{{ route('object',['id'=>$article->object->id]) }}">{{ $article->object->name  }}</a> object</small></h1>
    <p>{{ $article->content  }}</p>


    <a class="btn btn-primary top-buffer" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Article is liked <span class="badge">{{ $article->users->count()  }}</span>
    </a>
    <div class="collapse" id="collapseExample">
        <div class="well">

            <ul class="list-inline">
                @foreach( $article->users as $user ) 
                    <li><a href="{{ route('person',['id'=>$user->id]) }}"><img title="{{ $user->FullName  }}" class="media-object img-responsive" width="50" height="50" src="{{ $user->shots->first()->path ?? $placeholder  }}" alt="..."> </a></li>

                @endforeach 
            </ul>


        </div>
    </div>

    <h3>Comments</h3>

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

    <a href="#" class="btn btn-primary btn-xs">Like this article</a><br><br>

    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
        Add comment
    </a>
    <div class="collapse" id="collapseExample2">
        <div class="well">


            <form method="POST" class="form-horizontal">
                <fieldset>

                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Comment</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Add a comment about this article.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </fieldset>
            </form>

        </div>
    </div>


</div>
@endsection