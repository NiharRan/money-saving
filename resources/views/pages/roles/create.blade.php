@extends('layouts.contentLayoutMaster')

@section('title', 'Roles: Create New Role')


@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset('css/pages/role.css') }}">
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- role create form section start -->
  <div id="basic-examples">
    <div class="card">
        <div class="card-header">
          <h4 class="card-title">Create New Role</h4>
        </div>
        <div class="card-content collapse show">
          <div class="card-body">
            <form action="{{ route('api.roles.store') }}" id="role_create_form" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-12 offset-md-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="Name"
                                autofocus>
                              <span class="invalid-feedback" role="alert">
                                  <strong></strong>
                              </span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Create" class="btn btn-success">
                        </div>
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

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset('js/scripts/pages/role.js') }}"></script>
@endsection
