@extends('layouts.backend')

@section('content')

<h2>Редактировать</h2>
<form {{ $novalidate  }} method="POST" action="{{ route('cities.update',['id'=>$city->id]) }}">
    <h3 style="color: #ee2852">Название </h3>
    <input class="form-control" value="{{ $city->name  }}" type="text" required name="name"><br>
    <button class="btn btn-primary" type="submit">Сохранить</button>
    @csrf
    {{ method_field('PUT')  }}
</form>

@endsection