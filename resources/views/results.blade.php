@extends('layouts.app')

@section('content')
<results-stage csrf="{{ csrf_token() }}x" ></results-stage>
@endsection
