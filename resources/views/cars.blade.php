@extends('header')
@section('title', 'List of Cars')
@section('content')

    <list-of-cars cars="{{$cars}}"></list-of-cars>
@endsection
