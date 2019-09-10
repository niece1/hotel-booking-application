@extends('layouts.app') <!-- Lecture 5  -->

@section('content') <!-- Lecture 5  -->
<div class="container-fluid places">

    <h1 class="text-center">{{ $object->name }}  object  <small>{{ $object->city->name }} </small></h1>

    <p>{{ $object->description }} <!-- Lecture 16 --></p>


    <ul class="nav nav-tabs">
        <li class="active"><a href="#gallery" data-toggle="tab" aria-expanded="true">Image gallery</a></li>
        <li><a href="#people" data-toggle="tab" aria-expanded="true">Object is liked <span class="badge">{{ $object->users->count() }} <!-- Lecture 16 --></span></a></li>
        <li><a href="#adress" data-toggle="tab" aria-expanded="false">Address</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="gallery">

            @foreach($object->shots->chunk(3) as $chunked_shots) <!-- Lecture 16 -->

                <div class="row top-buffer">
                
                @foreach($chunked_shots as $shot) <!-- Lecture 16 -->

                    <div class="col-md-4">
                        <img class="img-responsive" src="{{ $shot->path ?? $placeholder }}" alt=""> 
                    </div>
                    
                @endforeach 
                </div>

            @endforeach 

        </div>
        <div class="tab-pane fade" id="people">

            <ul class="list-inline">
                @foreach( $object->users as $user) 
                    <li><a href="{{ route('person') }}"><img title="{{ $user->FullName  }}" class="media-object img-responsive" width="50" height="50" src="{{ $user->shots->first()->path ?? $placeholder  }}" alt="..."> </a></li>

                @endforeach <!-- Lecture 16 -->
            </ul>


        </div>
        <div class="tab-pane fade" id="adress">
            <p>{{ $object->address->street }} {{ $object->address->number }} </p>
        </div>
    </div>

    <section>

        <h2 class="text-center">Object rooms</h2>

        @foreach($object->rooms->chunk(4) as $chunked_rooms) 

            <div class="row">

                @foreach($chunked_rooms as $room) 

                    <div class="col-md-3 col-sm-6">

                        <div class="thumbnail">
                            <img class="img-responsive img-circle" src="{{ $room->shots->first()->path ?? $placeholder  }}" alt="...">
                            <div class="caption">
                                <h3>Nr {{ $room->room_number}} <!-- Lecture 16 --></h3>
                                <p>{{ str_limit($room->description,70) }} <!-- Lecture 16 --> </p>
                                <p><a href="{{ route('room',['id'=>$room->id]) }}" class="btn btn-primary" role="button">Details</a><a href="{{ route('room',['id'=>$room->id]) }}#reservation" class="btn btn-success pull-right" role="button">Reservation</a></p>
                            </div>
                        </div>
                    </div>

                @endforeach 
            </div>

        @endforeach 

    </section>

    <section>
        <h2 class="green">Object comments</h2>
        @foreach( $object->comments as $comment ) <!-- Lecture 16 -->
            <div class="media">
                <div class="media-left media-top">
                    <a title="{{ $comment->user->FullName  }}" href="{{ route('person') }}">
                        <img class="media-object" width="50" height="50" src="{{ $comment->user->shots->first()->path ?? $placeholder  }}" alt="...">
                    </a>
                </div>
                <div class="media-body">
                    {{ $comment->content }} <!-- Lecture 16 -->
                    {!! $comment->rating !!} <!-- Lecture 16 -->
                </div>
            </div>
            <hr>
        @endforeach <!-- Lecture 16 -->
    </section>

    <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Add comment
    </a>
    <div class="collapse" id="collapseExample">
        <div class="well">


            <form method="POST" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Comment</label>
                        <div class="col-lg-10">
                            <textarea required name="content" class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Add a comment about this object.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label">Rating</label>
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
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </fieldset>
            </form>

        </div>
    </div>

    <section>
        <h2 class="red">Articles about the object / area</h2>
        @foreach($object->articles as $article) <!-- Lecture 16 -->
            <div class="articles-list">
                <h4 class="top-buffer">{{ $article->title }} <!-- Lecture 16 --></h4>
                <p><b> {{ $article->user->FullName }} <!-- Lecture 16 --></b>
                    <i>{{ $article->created_at }} <!-- Lecture 16 --></i>
                </p>
                <p>{{ str_limit($article->content,250) }} <!-- Lecture 16 --> </p> <a href="{{ route('article',['id'=>$article->id]) }}">More</a>
            </div>

        @endforeach <!-- Lecture 16 -->
    </section>

    <a href="#" class="btn btn-primary btn-xs top-buffer">Like this object</a>
</div>
@endsection