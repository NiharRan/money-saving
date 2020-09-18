@extends('layouts/contentLayoutMaster')

@section('title', $user->name)

@section('vue-css')
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('vue-content')
  <!-- page users view start -->
  <user-profile></user-profile>
  <!-- page users view end -->
@endsection

@section('vendor-script')
@endsection

@section('page-script')

@endsection

@section('vue-js')
  <script src="{{ asset('js/app.js') }}"></script>
@endsection

