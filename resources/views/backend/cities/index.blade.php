@extends('layouts.backend') <!-- Lecture 37 -->

<!-- Lecture 37 -->
@section('content')
<h1>Cities <small><a class="btn btn-success" href="{{ route('cities.create') /* Lecture 38 */ }}" data-type="button"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>New city </a></small></h1>

<div class="table-responsive">
    <table class="table table-hover table-striped">
        <tr>
            <th>City name</th>
            <th>Edit / Delete</th>
        </tr>
        @foreach( $cities as $city ) <!-- Lecture 38 -->
            <tr>
                <td>{{ $city->name /* Lecture 38 */  }}</td>
                <td>
                    <a href="{{ route('cities.edit',['id'=>$city->id]) /* Lecture 38 */ }}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    
            <!-- Lecture 38 -->    
            <form style="display: inline;" method="POST" action="{{ route('cities.destroy',['id'=>$city->id]) }}">
<button onclick="return confirm('Are you sure?');" class="btn btn-primary btn-xs" type="submit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
{{ method_field('DELETE') }}
{{ csrf_field() }}
           </form>
 
                </td>
            </tr>
        @endforeach <!-- Lecture 38 -->
    </table>
</div>

@endsection