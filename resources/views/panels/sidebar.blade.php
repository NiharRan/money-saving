@php
    $configData = Helper::applClasses();
@endphp
<div class="main-menu {{ $configData['menuType'] }} {{($configData['theme'] === 'light') ? "menu-light" : "menu-dark"}} menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="/">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">SMS</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary collapse-toggle-icon" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
  <div class="main-menu-content ps ps--active-y">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">


      <li class="nav-item">
        <a href="/">
          <i class="feather icon-home"></i>
          <span class="menu-title" data-i18n="">{{ __('Dashboard') }}</span>
        </a>
      </li>


      @if (auth()->user()->is_subscriber)
        <li class="nav-item">
          <a href="/accounts">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">{{ __('Account') }}</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="/customers">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">{{ __('Customer') }}</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->is_admin)
        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-users"></i>
            <span class="menu-title" data-i18n="">{{ __('User') }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/users/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __('New') }}</span>
              </a>
            </li>
            <li class="">
              <a href="/users">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __('List') }}</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="navigation-header">
          <span>Settings</span>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-unlock"></i>
            <span class="menu-title" data-i18n="">{{ __('Role') }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/roles/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __('New') }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/roles">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __('List') }}</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-unlock"></i>
            <span class="menu-title" data-i18n="">{{ __('Account Type') }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/account-types/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __('New') }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/account-types">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __('List') }}</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-unlock"></i>
            <span class="menu-title" data-i18n="">{{ __('Transaction Type') }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/transaction-types/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/transaction-types">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-unlock"></i>
            <span class="menu-title" data-i18n="">{{ __("Money Format") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/money-formats/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/money-formats">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("Religion") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/religions/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/religions">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("Blood Group") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/blood_groups/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/blood_groups">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>                                            </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("Gender") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/genders/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/genders">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>                                            </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("Division") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/divisions/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/divisions">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>                                            </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("District") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/districts/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/districts">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>                                            </li>

        <li class="nav-item has-sub">
          <a href="">
            <i class="feather icon-book"></i>
            <span class="menu-title" data-i18n="">{{ __("Upazilla") }}</span>
          </a>
          <ul class="menu-content">
            <li class="">
              <a href="/settings/upazillas/create">
                <i class="feather icon-plus"></i>
                <span class="menu-title" data-i18n="">{{ __("New") }}</span>
              </a>
            </li>
            <li class="">
              <a href="/settings/upazillas">
                <i class="feather icon-circle"></i>
                <span class="menu-title" data-i18n="">{{ __("List") }}</span>
              </a>
            </li>
          </ul>
        </li>
      @endif
    </ul>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
      <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 260px; right: 0px;">
      <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 69px;"></div>
    </div>
  </div>
</div>
<!-- END: Main Menu-->
