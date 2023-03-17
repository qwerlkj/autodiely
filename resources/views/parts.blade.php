@extends('header')
@section('title', 'List of Parts')
@section('content')
    <list-of-parts parts="{{$parts}}" cars="{{$cars}}"></list-of-parts>
@endsection
