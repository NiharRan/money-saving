
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')

@endsection
@section('vue-css')
  <link rel="stylesheet" href="{{ asset('css/pages/dashboard-analytics.css') }}">
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @endsection

  @section('vue-content')
    {{-- Dashboard Analytics Start --}}
    <dashboard-page></dashboard-page>
  <!-- Dashboard Analytics end -->
  @endsection

@section('vue-js')
  <script src="{{ asset('js/app.js') }}"></script>
@endsection

