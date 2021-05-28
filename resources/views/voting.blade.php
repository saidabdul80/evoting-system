@extends('layouts.app')

@section('content')
<voting-stage csrf="{{ csrf_token() }}x" ></voting-stage>
@endsection
