@extends('layouts/contentLayoutMaster')

@section('title', 'View Book Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
@endsection

@section('content')
<!-- page users view start -->
<section class="page-users-view">
  <div class="row">
    <!-- account start -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Account</div>
          <div class="row">
            <div class="col-2 users-view-image">
              <img src="{{ $user->studentAvatarMedium }}" class="w-100 rounded mb-2"
                   alt="avatar">
              <!-- height="150" width="150" -->
            </div>
            <div class="col-sm-6 col-12">
              <table>
                <tr>
                  <td class="font-weight-bold">Name</td>
                  <td>{{ $user->name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Email</td>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Gender</td>
                  <td>{{ $user->gender->name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Blood Group</td>
                  <td>{{ $user->blood_group->name }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-4 col-12">
              <table class="ml-auto">
                <tr>
                  <td class="font-weight-bold">Status</td>
                  <td>{{ $user->currentStatus }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Role</td>
                  <td>{{ $user->role->name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Religion</td>
                  <td>{{ $user->religion->name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Birth Date</td>
                  <td>{{ $user->birth_date }}</td>
                </tr>
              </table>
            </div>
            <div class="col-12">
              @if(auth()->user()->id == $user->id)
                <a href="{{ route('users.profile') }}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> Edit</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- account end -->
    <!-- information start -->
    <div class="col-md-6 col-12 ">
      <div class="card">
        <div class="card-body">
          <div class="card-title mb-2">Address</div>
          @if($user->address)
            <table class="table">
              <tr>
                <td class="font-weight-bold">Village/House No./Road </td>
                <td>{{ $user->address->address }}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">Upazilla</td>
                <td>
                  @if($user->address->upazilla)
                    {{ $user->address->upazilla->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">District</td>
                <td>
                  @if($user->address->district)
                    {{ $user->address->district->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">Division</td>
                <td>
                  @if($user->address->division)
                    {{ $user->address->division->name }}
                  @endif
                </td>
              </tr>
            </table>
          @endif
        </div>
      </div>
    </div>
    <!-- information start -->
    <!-- department info start -->
    @if($user->isStudent)
      <div class="col-md-6 col-12 ">
        <div class="card">
          <div class="card-body">
            <div class="card-title mb-2">Department Info</div>
            <table class="table">
              <tr>
                <td class="font-weight-bold">Department </td>
                @if($user->department)
                  <td>
                    {{ $user->department->name }} ({{ $user->department->short }})
                  </td>
                @endif

              </tr>
              <tr>
                <td class="font-weight-bold">Batch</td>
                <td>
                  @if($user->batch)
                    {{ $user->batch->name }}
                  @endif
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">Section</td>
                <td>
                  @if($user->section)
                    {{ $user->section->name }}
                  @endif
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    @endif
    <!-- department info end -->
    <!-- permissions start -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">

            @if(count($user->educations) > 0)
              @foreach($user->educations as $education)
                <div class="border rounded my-2">
                  <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="fa fa-address-card-o mr-50 "></i>{{ $education->degree->name }}
                  </h6>
                  <table class="table table-borderless">
                    <thead>
                    <tr>
                      <th>Department</th>
                      <th>Institute</th>
                      <th>Result</th>
                      <th>Passing Year</th>
                      <th>Board</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <th>{{ $education->group->name }}</th>
                      <td>{{ $education->institute }}</td>
                      <td>{{ $education->result }}</td>
                      <td>{{ $education->passing_year }}</td>
                      <th>{{ $education->board->name }}</th>
                    </tr>
                    </tbody>
                  </table>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
    <!-- permissions end -->
  </div>
</section>
<!-- page users view end -->
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{ asset('js/scripts/pages/app-user.js') }}"></script>
@endsection
