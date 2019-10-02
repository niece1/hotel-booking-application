@extends('layouts.backend')

@section('content')
<h2>Города <small><a class="btn btn-primary" href="{{ route('cities.create') }}" data-type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Добавить </a></small></h2>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>Город</th>
            <th>Редактировать / Удалить</th>
        </tr>
        @foreach( $cities as $city )
        <tr>
            <td>{{ $city->name }}</td>
            <td>
                <a href="{{ route('cities.edit',['id'=>$city->id])  }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                <form style="display: inline;" method="POST" action="{{ route('cities.destroy',['id'=>$city->id]) }}">
                    <button onclick="return confirm('Вы уверены?');" class="btn btn-primary btn-xs" type="submit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    {{ method_field('DELETE') }}
                    @csrf
                </form>

            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection