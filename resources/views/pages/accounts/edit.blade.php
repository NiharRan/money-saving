@extends('layouts.contentLayoutMaster')

@section('title', "Accounts: Update $account->name's info")
@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('css/custom-file-input.css') }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/select2/select2.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/pages/account.css') }}">
@endsection

@section('content')
  <!-- users list start -->
  <section class="student-list-wrapper">
    <!-- role create form section start -->
    <div id="basic-examples">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form
                action="{{ route('api.accounts.update', $account->id) }}"
                id="account_edit_form"
                method="POST"
                enctype="multipart/form-data"
                autocomplete="off">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12">
                  <div class="border rounded px-1">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2">
                    <i class="fa fa-info-circle mr-50 "></i>{{ __('Update :name Info', ['name' => $account->name]) }}
                    <span class="valid-feedback">{{ $account->name }}</span> {{ __('Information') }}</h6>
                    <div class="row">
                      <div class="col-12 col-md-8">
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ $account->name }}"
                                class="form-control"
                                placeholder="{{ __('Name') }}">
                            <span class="invalid-feedback"></span>
                          </div>
                          <div class="col-12 col-md-6">
                            <label for="name">{{ __('Slugan') }}</label>
                            <input
                              type="text"
                              name="slugan"
                              id="slugan"
                              value="{{ $account->slugan }}"
                              class="form-control"
                              placeholder="{{ __('Slugan') }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label for="name">{{ __('Money Format') }} <span class="text-danger">*</span></label>
                            <select
                              name="money_format_id"
                              id="money_format_id"
                              value="{{ $account->money_format_id }}"
                              class="form-control">
                              <option value="">{{ __('Select One') }}</option>
                              @if(count($moneyFormats) > 0)
                                @foreach($moneyFormats as $row)
                                  <option value="{{ $row->id }}" {{ $account->money_format_id == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                                @endforeach
                              @endif
                            </select>
                            <span class="invalid-feedback"></span>
                          </div>
                          <div class="col-12 col-md-6">
                            <label for="name">{{ __('Account Type') }} <span class="text-danger">*</span></label>
                            <select
                              name="account_type_id"
                              id="account_type_id"
                              value="{{ $account->account_type_id }}"
                              class="form-control">
                              <option value="">{{ __('Select One') }}</option>
                              @if(count($accountTypes) > 0)
                                @foreach($accountTypes as $row)
                                  <option value="{{ $row->id }}" {{ $account->account_type_id == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                                @endforeach
                              @endif
                            </select>
                            <span class="invalid-feedback"></span>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-12">
                            <label for="name">{{ __('Members') }} </label>
                            <select
                              name="users[]"
                              id="users"
                              value=""
                              multiple="multiple"
                              class="form-control select2">
                              <option value="">{{ __('Select') }} </option>
                              @if(count($users) > 0)
                                @foreach($users as $row)
                                  <option value="{{ $row->id }}" {{ in_array($row->id, $account->subscribedUsers) ? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                              @endif
                            </select>
                            <span class="invalid-feedback"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-4">
                        <div class="banner-logo-upload-box passport-size mx-auto">
                          <img id="image_src" src="{{ asset('/storage/accounts/'.$account->logo) }}" alt="">
                          <label class="btn-pill">
                            <i class="fa fa-camera"></i>
                            <input id="logo" type="file" name="logo" class="hidden"/>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
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
  <!-- users list ends -->
@endsection

@section('vendor-script')
  <script src="{{ asset('vendors/js/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset(mix('vendors/js/select2/select2.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script>
    if ($(".select2")) {
      $(".select2").select2();
    }
  </script>
  <script src="{{ asset('js/scripts/pages/account.js') }}"></script>
@endsection
