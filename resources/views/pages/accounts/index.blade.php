@extends('layouts.contentLayoutMaster')

@section('title', 'Accounts')
@section('create-link', route('accounts.create'))
@section('vendor-style')
  {{-- Page js files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection


@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/pages/account.css') }}">
@endsection

@section('content')
  <!-- accounts list start -->
  <section class="users-list-wrapper">
    <!-- Ag Grid users list section start -->
    <div id="basic-examples">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

              <div class="table-responsive">
                <table id="data-table" class="table table-bordered display responsive nowrap mb-0" style="width: 100%">
                  <thead>
                  <tr>
                    <th scope="col">S.N.</th>
                    <th>Name</th>
                    <th>Members</th>
                    <th>Type</th>
                    <th>Money Format</th>
                    <th>Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Actions</th>
                  </tr>
                  </thead>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Ag Grid users list section end -->
  </section>
  <!-- users list ends -->
@endsection

@section('vendor-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/account.js') }}"></script>
  <script>
    $(function () {
      if ($("#data-table")) {
        $('#data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{!! route('api.accounts.index') !!}',
          columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'members', name: 'users.name', orderable: false },
            { data: 'account_type.name', name: 'account_type_id' },
            { data: 'money_format.name', name: 'money_format_id' },
            { data: 'last_updated', name: 'updated_at' },
            { data: 'status', name: 'status', orderable: false , searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false}
          ]
        });
      }
    });
  </script>
@endsection
