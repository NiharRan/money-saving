@extends('layouts/contentLayoutMaster')

@section('title', 'View Book Page')

@section('page-style')

@section('vue-css')
  {{-- Page js files --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('vue-content')
<!-- page account profile view start -->
<account-profile></account-profile>
<!-- page account profile view end -->
@endsection

@section('vendor-script')
  {{-- Page js files --}}
@endsection

@section('page-script')
  {{-- Page js files --}}

@endsection

@section('vue-js')
  {{-- Page js files --}}
  <script src="{{ asset('js/app.js') }}"></script>
@endsection

