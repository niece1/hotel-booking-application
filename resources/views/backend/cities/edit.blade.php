@extends('layouts.backend') <!-- Lecture 37 -->

<!-- Lecture 37 -->
@section('content')

<h1>Edit city</h1>
<form {{ $novalidate /* Lecture 38 */ }} method="POST" action="{{ route('cities.update',['id'=>$city->id]) /* Lecture 38 */ }}">
<h3>Name * </h3>
<input class="form-control" value="{{ $city->name /* Lecture 38 */ }}" type="text" required name="name"><br>
<button class="btn btn-primary" type="submit">Save <!-- Lecture 38 --></button>  
{{ csrf_field() /* Lecture 38 */ }}
{{ method_field('PUT') /* Lecture 38 */ }}
</form>

@endsection