@extends('layouts.contentLayoutMaster')

@section('title', 'Accounts: Create A New Transaction')
@section('vendor-style')

@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/pages/account.css') }}">
@endsection

@section('content')
  <!-- accounts list start -->
  <section class="student-list-wrapper">
    <!-- role create form section start -->
    <div id="basic-examples">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form
                action="{{ route('api.accounts.transactions.store') }}"
                id="account_transaction_create_form"
                method="POST"
                autocomplete="off">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12">
                  <div class="border rounded px-1">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-info-circle mr-50 "></i>{{ __('New') }} {{ __('Transaction') }}</h6>
                    <div class="form-group row mt-2">
                        <div class="col-12 col-md-6">
                            <label for="name">{{ __('Transaction Type') }} <span class="text-danger">*</span></label>
                            <select
                                name="transaction_type_id"
                                id="transaction_type_id"
                                value=""
                                class="form-control">
                                <option value="">{{ __("Select One") }}</option>
                                @if(count($transactionTypes) > 0)
                                @foreach($transactionTypes as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="name">{{ __('Amount') }} <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                step="2"
                                class="form-control"
                                placeholder="{{ __('Amount') }}"/>
                            <span class="invalid-feedback"></span>
                        </div>
                      <div class="col-12 col-md-3">
                        <label for="trans_date">{{ __('Transaction Date') }} <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="trans_date"
                          id="trans_date"
                          class="form-control"
                          placeholder="{{ __('Transaction Date') }}"/>
                        <span class="invalid-feedback"></span>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-12 mt-2">
                    <input type="hidden" name="account_id" value="{{ $account_id }}" />
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                    <button type="submit" class="btn btn-success m-auto"><i class="feather icon-plus"></i> {{ __('Submit') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- role create form section end -->
  </section>
  <!-- accounts list ends -->
@endsection

@section('vendor-script')

@endsection

@section('page-script')
  <script>
    $(function () {
      $("#trans_date").datepicker({
        format: 'yy-mm-dd'
      });
    });
  </script>
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/account.js') }}"></script>
@endsection
