@extends('layouts.app') 

@section('content') 
<section class="objects-list">

    @if (session('norooms'))
    <p class="text-center red bolded">
        {{ session('norooms') }}
    </p>
    @endif
    <h1 class="text-center">Explore our hotels</h1>

    @foreach($objects->chunk(4) as $chunk) 

        <div class="objects-list-wrapper">

            @foreach($chunk as $object) 
               
                    <div class="item-holder">
                        <img class="img-responsive" src="{{ $object->shots->first()->path ?? $placeholder }}" alt="..."> 
                        <div class="caption">
                            <h3>{{ $object->name }}   <small>{{ $object->city->name  }}</small> </h3>
                            <p>{{ str_limit($object->description,100) }}</p>
                            <p><a href="{{ route('object' ,['id'=>$object->id]) }}" class="btn btn-primary" role="button">Details</a></p>
                        </div>
                    </div>                
            @endforeach 
        </div>

    @endforeach 

</section>

<div class="container">
<div class="row">
    <div class="col-12 text-center pt-5">
      {{ $objects->links() }}
    </div>
</div>
</div>

@endsection