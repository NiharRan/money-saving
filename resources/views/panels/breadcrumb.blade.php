<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <div class="breadcrumb-wrapper col-12">
          @if(@isset($breadcrumbs))
            <ol class="breadcrumb">
              {{-- this will load breadcrumbs dynamically from controller --}}
              @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item">
                  @if(isset($breadcrumb['link']))
                    <a href="{{ $breadcrumb['link'] }}">
                      @endif
                      {{ $breadcrumb['name'] }}
                      @if(isset($breadcrumb['link']))
                    </a>
                  @endif
                </li>
              @endforeach
            </ol>
          @endisset
        </div>
      </div>
    </div>
  </div>
  @if (View::hasSection('create-link'))
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
      <a class="btn btn-primary" href="@yield('create-link')"><i class="feather icon-plus"></i> New</a>
    </div>
  @endif
</div>
