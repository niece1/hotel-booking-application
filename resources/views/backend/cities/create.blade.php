@extends('layouts.backend')

@section('content')

<h2>Создайте новый город</h2>
<form {{ $novalidate }} method="POST" action="{{ route('cities.store')  }}">
    <h3 style="color: #ee2852">Название</h3>
    <input class="form-control" type="text" required name="name"><br>
    <button class="btn btn-primary" type="submit">Создать</button>
    @csrf
</form>

@endsection