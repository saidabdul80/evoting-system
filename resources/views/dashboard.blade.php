@extends('layouts.app')

@section('content')
<dashboard-stage csrf="{{ csrf_token() }}x" ></dashboard-stage>
@endsection
