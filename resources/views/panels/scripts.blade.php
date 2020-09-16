
<script>
  window.Laravel = {!! json_encode([
       'token' => csrf_token()
   ]) !!};
</script>
{{-- Vendor Scripts --}}
<script src="/vendors/js/vendors.min.js"></script>
@yield('vendor-script')

{{-- Theme Scripts --}}
<script src="/js/core/app-menu.js"></script>
<script src="/js/core/app.js"></script>
<script src="/js/scripts/customizer.js"></script>
<script src="/js/scripts/components.js"></script>

@if($configData['blankPage'] == false)
    <script src="/js/scripts/footer.js"></script>
@endif

<script>
  window._locale = '{{ app()->getLocale() }}';
  window._translations = {!! cache('translations') !!};
  window.auth = {!! auth()->user() !!};
  window.text = '{{ isset($config) ? $config['text'] : '' }}';
  @if(isset($config) && $config['vue'] === true && isset($breadcrumbs))
    window.breadcrumbs = @json($breadcrumbs)
  @else
     window.breadcrumbs = [];
   @endif
</script>

@if(isset($config) && $config['vue'] == true)
  @yield('vue-js')
@else
  <script src="/vendors/js/axios.min.js"></script>
  <script src="/vendors/js/sweetalert2.js"></script>
  <script src="/vendors/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
@endif

<script>
  axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.token,
    'X-Requested-With': 'XMLHttpRequest',
  };
</script>

{{-- page script --}}
@yield('page-script')

