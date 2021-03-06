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
  <section class="page-users-view">
    <div class="row">
      <!-- account info start -->
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-md-3 user-profile border-right">
                <img src="{{ $user->avatarMedium }}" class="w-100 rounded mb-2"
                     alt="avatar">
                <h3>{{ $user->name }}</h3>
                <p class="mb-0">{{ $user->phone }}</p>
              </div>
              <div class="col-md-6 col-12">
                <table class="table table-bordered">
                  @if(count($transactionTypes) > 0)
                    @foreach($transactionTypes as $transactionType)
                      <tr>
                        <td class="font-weight-bold">{{ $transactionType->name }}</td>
                        <td>{{ $transactionType->amount }}</td>
                      </tr>
                    @endforeach
                  @endif
                </table>
              </div>
              <div class="col-md-3 col-12 user-trans-btn">
                <a href="{{ route('users.transactions.create', $user->id) }}" class="btn btn-primary"><i class="feather icon-plus"></i> Transaction</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- account info end -->

      <!-- account member info start -->
      <div class="col-12">
        <div class="row match-height">
          @if(count($accounts) > 0)
            @foreach($accounts as $account)
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-md-6 account-profile border-right">
                        <img src="{{ $account->logoMedium }}" class="w-100 rounded mb-2"
                             alt="avatar">
                        <h3>{{ $account->name }}</h3>
                        <p class="mb-0">{{ $account->slugan }}</p>
                      </div>
                      <div class="col-md-6 col-12">
                        <table class="table table-bordered">
                          @if(count($account->transactionTypes) > 0)
                            @foreach($account->transactionTypes as $transactionType)
                              <tr>
                                <td class="font-weight-bold">{{ $transactionType->name }}</td>
                                <td>{{ $transactionType->amount }}</td>
                              </tr>
                            @endforeach
                          @endif
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
      <!-- account member info end -->

      <!-- account transaction start -->
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Transactions</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="data-table" class="table table-bordered display responsive nowrap mb-0" style="width: 100%">
                <thead>
                <tr>
                  <th scope="col">S.N.</th>
                  <th class="text-center">Invoice</th>
                  <th>Account</th>
                  <th>Transaction Type</th>
                  <th class="text-right">Amount</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Date</th>
                </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- account transaction end -->
      <input type="hidden" id="url" value="{{ route('api.users.transactions.index', $user->id) }}" />
    </div>
  </section>
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

