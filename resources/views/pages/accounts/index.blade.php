@extends('layouts.contentLayoutMaster')

@section('title', 'Accounts')
@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('css/custom-file-input.css') }}">
@endsection

@section('vue-css')
  <link rel="stylesheet" href="{{ asset("css/app.css") }}">
@endsection

@section('vue-content')
  <!-- customer list start -->
  <account-list></account-list>
  <!-- customer list ends -->
@endsection

@section('vendor-script')
@endsection

@section('vue-js')
  <script src="{{ asset('js/app.js') }}"></script>
@endsection
