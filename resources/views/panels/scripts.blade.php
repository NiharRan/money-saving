
<script>
  window.Laravel = {!! json_encode([
       'token' => csrf_token()
   ]) !!};
</script>
{{-- Vendor Scripts --}}
  <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
  <script src="{{ asset('vendors/js/sweetalert/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('vendors/js/axios.min.js') }}"></script>
@yield('vendor-script')
  {{-- Theme Scripts --}}
  <script src="{{ asset('js/core/app-menu.js') }}"></script>
  <script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/customizer.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
@if($configData['blankPage'] == false)
        <script src="{{ asset('js/scripts/footer.js') }}"></script>
@endif
<script>
  axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.token,
    'X-Requested-With': 'XMLHttpRequest',
  };
</script>
{{-- page script --}}
@yield('page-script')
