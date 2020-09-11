
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/pages/dashboard-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/card-analytics.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/tour/tour.css')) }}">
  @endsection

  @section('content')
    {{-- Dashboard Analytics Start --}}
    <section id="dashboard-analytics">
      <div class="row">
          <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="card bg-analytics text-white">
            <div class="card-content">
              <div class="card-body text-center">
                <img src="{{ asset('images/elements/decore-left.png') }}" class="img-left" alt="card-img-left">
                <img src="{{ asset('images/elements/decore-right.png')}}" class="img-right" alt="card-img-right">
                <div class="avatar avatar-xl bg-primary shadow mt-0">
                    <div class="avatar-content">
                        <i class="feather icon-award white font-large-1"></i>
                    </div>
                </div>
                <div class="text-center">
                  <h1 class="mb-2 text-white">{{ __('Congratulations', ['name' => auth()->user()->name]) }},</h1>
                  <p class="m-auto w-75">You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
              <div class="card-header d-flex flex-column align-items-start pb-0">
                  <div class="avatar bg-rgba-primary p-50 m-0">
                      <div class="avatar-content">
                          <i class="feather icon-users text-primary font-medium-5"></i>
                      </div>
                  </div>
                  <h2 class="text-bold-700 mt-1 mb-25">92.6k</h2>
                  <p class="mb-0">Subscribers Gained</p>
              </div>
              <div class="card-content">
                  <div id="subscribe-gain-chart"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column align-items-start pb-0">
                    <div class="avatar bg-rgba-warning p-50 m-0">
                        <div class="avatar-content">
                            <i class="feather icon-package text-warning font-medium-5"></i>
                        </div>
                    </div>
                    <h2 class="text-bold-700 mt-1 mb-25">97.5K</h2>
                    <p class="mb-0">Orders Received</p>
                </div>
                <div class="card-content">
                    <div id="orders-received-chart"></div>
                </div>
            </div>
          </div>
      </div>
      @if(auth()->user()->isSubscriber)
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="mb-0">{{ __('Recent Transactions') }}</h4>
            </div>
            <div class="card-content">
              <div class="table-responsive mt-1">
                <table id="data-table" class="table table-hover-animation mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-center">{{ __("Invoice") }}</th>
                      <th class="text-uppercase">{{ __("Account") }}</th>
                      <th class="text-uppercase">{{ __('Transaction Type') }}</th>
                      <th class="text-uppercase text-right">{{ __('Amount') }}</th>
                      <th class="text-uppercase text-center">{{ __("Status") }}</th>
                      <th class="text-uppercase text-center">{{ __('Date') }}</th>
                    </tr>
                  </thead>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" id="url" value="{{ route('api.users.transactions.index', auth()->user()->id) }}" />
      @endif

      @if(auth()->user()->isAdmin)
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="mb-0">{{ __('Recent Transactions') }}</h4>
              </div>
              <div class="card-content">
                <div class="table-responsive mt-1">
                  <table id="data-table" class="table table-bordered display responsive nowrap mb-0" style="width: 100%">
                    <thead>
                    <tr>
                      <th class="text-uppercase text-center">{{ __("Invoice") }}</th>
                      <th class="text-uppercase">{{ __('Account') }}</th>
                      <th class="text-uppercase">{{ __('Member') }}</th>
                      <th class="text-uppercase">{{ __('Transaction Type') }}</th>
                      <th class="text-uppercase text-right">{{ __('Amount') }}</th>
                      <th class="text-uppercase text-center">{{ __("Status") }}</th>
                      <th class="text-uppercase text-center">{{ __('Date') }}</th>
                    </tr>
                    </thead>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" id="url" value="{{ route('api.transactions.index') }}" />
      @endif
    </section>
  <!-- Dashboard Analytics end -->
  @endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
        @if(auth()->user()->isSubscriber)
          <script>
            $(function () {
              const url = $("#url").val();
              if ($("#data-table")) {
                $('#data-table').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: url,
                  columns: [
                    { data: 'invoice', name: 'invoice' },
                    { data: 'account.name', name: 'account.name' },
                    { data: 'transaction_type.name', name: 'transaction_type_id' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status', searchable: false , searchable: false},
                    { data: 'default_date_time', name: 'updated_at' },
                  ]
                });
              }
            });
          </script>
        @endif

        @if(auth()->user()->isAdmin)
          <script>
            $(function () {
              const url = $("#url").val();
              if ($("#data-table")) {
                $('#data-table').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: url,
                  columns: [
                    { data: 'invoice', name: 'invoice' },
                    { data: 'account.name', name: 'account.name' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'transaction_type.name', name: 'transaction_type_id' },
                    { data: 'amount', name: 'amount' },
                    { data: 'status', name: 'status', searchable: false , searchable: false},
                    { data: 'default_date_time', name: 'updated_at' },
                  ]
                });
              }
            });
          </script>
        @endif
@endsection
