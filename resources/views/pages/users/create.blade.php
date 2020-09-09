@extends('layouts.contentLayoutMaster')

@section('title', 'Users: User Registration Form')
@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('vendors/css/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom-file-input.css') }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/pages/user.css') }}">
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
                action="{{ route('api.users.store') }}"
                id="user_create_form"
                method="POST"
                enctype="multipart/form-data"
                autocomplete="off">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-12">
                  <div class="border rounded px-1">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-info-circle mr-50 "></i>User Info</h6>
                    <div class="row">
                      <div class="col-12 col-md-8">
                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Student Name">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 col-md-6">
                            <label for="name">Contact No. <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              name="phone"
                              id="phone"
                              value="{{ old('phone') }}"
                              class="form-control @error('phone') is-invalid @enderror"
                              placeholder="Student Contact No.">
                            @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label for="name">Mother Name <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              name="mother_name"
                              id="mother_name"
                              value="{{ old('mother_name') }}"
                              class="form-control @error('mother_name') is-invalid @enderror"
                              placeholder="Student Mother Name">
                            @error('mother_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 col-md-6">
                            <label for="name">Gender <span class="text-danger">*</span></label>
                            <select
                              name="gender_id"
                              id="gender_id"
                              value="{{ old('gender_id') }}"
                              class="form-control @error('gender_id') is-invalid @enderror">
                              <option value="">Select One</option>
                              @if(count($genders) > 0)
                                @foreach($genders as $row)
                                  <option value="{{ $row->id }}" {{ old('gender_id') == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                                @endforeach
                              @endif
                            </select>
                            @error('gender_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-12 col-md-6">
                            <label for="name">Father Name <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              name="father_name"
                              id="father_name"
                              value="{{ old('father_name') }}"
                              class="form-control @error('father_name') is-invalid @enderror"
                              placeholder="Student Father Name">
                            @error('father_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 col-md-6">
                            <label for="name">Blood Group</label>
                            <select name="blood_group_id" id="blood_group_id" value="{{ old('blood_group_id') }}" class="form-control @error('blood_group_id') is-invalid @enderror">
                              <option value="">Select One</option>
                              @if(count($bloodGroups) > 0)
                                @foreach($bloodGroups as $row)
                                  <option value="{{ $row->id }}" {{ old('blood_group_id') == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                                @endforeach
                              @endif
                            </select>
                            @error('blood_group_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                          </div>

                        </div>
                      </div>
                      <div class="col-12 col-md-4">
                        <div class="banner-logo-upload-box passport-size mx-auto">
                          <img id="image_src" src="{{ asset('/storage/students/default.png') }}" alt="">
                          <label class="btn-pill">
                            <i class="fa fa-camera"></i>
                            <input id="image" type="file" name="avatar" class="hidden"/>
                          </label>
                        </div>
                        @error('avatar')
                        <div class="alert alert-danger" role="alert">
                          <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-12 col-md-3">
                        <label for="name">Birth Date <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="birth_date"
                          id="birth_date"
                          value="{{ old('birth_date') }}"
                          class="form-control @error('birth_date') is-invalid @enderror"
                          placeholder="Student Birth Date">
                        @error('birth_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="name">Religion <span class="text-danger">*</span></label>
                        <select
                          name="religion_id"
                          id="religion_id"
                          value="{{ old('religion_id') }}"
                          class="form-control @error('religion_id') is-invalid @enderror">
                          <option value="">Select One</option>
                          @if(count($religions) > 0)
                            @foreach($religions as $row)
                              <option value="{{ $row->id }}" {{ old('religion_id') == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                            @endforeach
                          @endif
                        </select>
                        @error('religion_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="name">Nationality <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          name="nationality"
                          id="nationality"
                          value="{{ old('nationality') }}"
                          class="form-control @error('nationality') is-invalid @enderror"
                          placeholder="Student Nationality">
                        @error('nationality')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-12 col-md-3">
                        <label for="name">Email</label>
                        <input
                          type="email"
                          name="email"
                          id="email"
                          value="{{ old('email') }}"
                          class="form-control @error('email') is-invalid @enderror"
                          placeholder="Student Email Address">
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="border rounded px-1 my-2">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-address-card-o mr-50 "></i>Permanent Address</h6>
                    <div class="col-12">
                      <input type="hidden" id="old_district_id" value="{{ old('district_id') }}">
                      <input type="hidden" id="old_upazilla_id" value="{{ old('upazilla_id') }}">
                      <div class="form-group row">
                        <div class="col-12 col-md-3">
                          <label for="name">Division</label>
                          <select
                              name="division_id"
                              id="division_id"
                              value="{{ old('division_id') }}"
                              class="form-control @error('division_id') is-invalid @enderror">
                            <option value="">Select One</option>
                            @if(count($divisions) > 0)
                              @foreach($divisions as $row)
                                <option value="{{ $row->id }}" {{ old('division_id') == $row->id ? "selected" : "" }}>{{ $row->name }}</option>
                              @endforeach
                            @endif
                          </select>
                          @error('division_id')
                          <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="col-12 col-md-3">
                          <label for="name">District <span class="text-danger">*</span></label>
                          <select
                              name="district_id"
                              id="district_id"
                              value="{{ old('district_id') }}"
                              class="form-control @error('district_id') is-invalid @enderror">
                            <option value="">Select One</option>
                          </select>
                          @error('district_id')
                          <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="col-12 col-md-3">
                          <label for="name">Upazilla <span class="text-danger">*</span></label>
                          <select
                              name="upazilla_id"
                              id="upazilla_id"
                              value="{{ old('upazilla_id') }}"
                              class="form-control @error('upazilla_id') is-invalid @enderror">
                            <option value="">Select One</option>
                          </select>
                          @error('upazilla_id')
                          <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="col-12 col-md-3">
                          <label for="name">Village/House No. <span class="text-danger">*</span></label>
                          <input
                              type="text"
                              name="address"
                              id="address"
                              value="{{ old('address') }}"
                              class="form-control @error('address') is-invalid @enderror"
                              placeholder="Student Village/House No.">
                          @error('address')
                          <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-success m-auto"><i class="feather icon-plus"></i> Submit</button>
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
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/user.js') }}"></script>
@endsection
