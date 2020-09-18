@extends('layouts/contentLayoutMaster')

@section('title', $user->name)

@section('page-style')

@section('vendor-style')
  {{-- Page js files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/user.css')) }}">
@endsection

@section('content')
  <!-- page users view start -->

  <!-- page users view end -->
@endsection

@section('vendor-script')
  {{-- Page js files --}}

  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/user.js') }}"></script>
  <script>
    $(function () {
      const url = $("#url").val();
      if ($("#data-table")) {
        $('#data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: url,
          columns: [
            { data: 'id', name: 'id' },
            { data: 'invoice', name: 'invoice' },
            { data: 'account.name', name: 'account_id' },
            { data: 'transaction_type.name', name: 'transaction_type_id' },
            { data: 'amount', name: 'amount' },
            { data: 'status', name: 'status', searchable: false , searchable: false},
            { data: 'created_at', name: 'created_at' },
          ]
        });
      }
    });
  </script>
@endsection

