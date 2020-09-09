@extends('layouts.contentLayoutMaster')

@section('title', 'Roles: Edit Role')


@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset('css/pages/role.css') }}">
@endsection

@section('content')
<!-- users list start -->
<section class="users-list-wrapper">
  <!-- role edit form section start -->
  <div id="basic-examples">
    <div class="card">
        <div class="card-header">
          <h4 class="card-title">Edit <strong class="text-success">{{ $role->name }}'s </strong>Info</h4>
        </div>
        <div class="card-content collapse show">
          <div class="card-body">
            <form action="{{ route('api.roles.update', $role->id) }}" id="role_edit_form" method="POST" autocomplete="off">
                {{ csrf_field() }}
                @method("PUT")
                <div class="row">
                    <div class="col-12 col-md-6 offset-md-3 col-sm-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="Name"
                                value="{{ $role->name }}"
                                autofocus>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-success">
                            <ul class="list-unstyled mb-0 float-right">
                              <li class="d-inline-block mt-1">
                                <fieldset>
                                  <label>
                                    <input type="radio" value="1" name="status" {{ $role->status == 1 ? 'checked' : ''}}>
                                    Active
                                  </label>
                                </fieldset>
                              </li>
                              <li class="d-inline-block mr-2">
                                <fieldset>
                                  <label>
                                    <input type="radio" value="0" name="status" {{ $role->status == 0 ? 'checked' : ''}}>
                                    Inactive
                                  </label>
                                </fieldset>
                              </li>
                            </ul>
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
