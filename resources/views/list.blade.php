@extends('main')
@section('content')
@include('sweetalert::alert')

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Active</th>
            <th>Update</th>
            <th style="width: 100px;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        {!! \App\Helpers\Helper::menu($menus) !!}
        
    </tbody>
</table>
@endsection