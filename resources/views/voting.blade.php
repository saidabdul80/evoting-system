@extends('layouts.app')

@section('content')
<voting-stage csrf="{{ csrf_token() }}" ></voting-stage>
@endsection
