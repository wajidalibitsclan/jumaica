@php
$headerStyle = $row->header_style ?? '';
@endphp

<header data-add-bg="bg-dark-1" class="header {{ $headerStyle  == 'transparent' ? 'bg-green' : '' }} js-header bravo_header" data-x="header" data-x-toggle="is-menu-opened">
    <div data-anim="fade" class="{{ $container_class ?? 'header__container' }} {{ $headerStyle  == 'transparent' ? 'px-30 sm:px-20' : 'container' }} is-in-view">
        <div class="row justify-between items-center">
            <div class="col-auto">
                <div class="d-flex items-center">
                    @if($headerStyle != 'transparent')
                        <div class="mr-20">
                            <button class="d-flex items-center icon-menu text-white text-20" data-x-click="desktopMenu"></button>
                        </div>
                    @endif
                    <a href="{{url(app_get_locale(false,'/'))}}" class="header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
                        @php
                            $logo_id = setting_item("logo_id_dark");
                            if($headerStyle  == 'transparent') $logo_id = setting_item('logo_id');
                            if(!empty($row->custom_logo)) $logo_id = $row->custom_logo;
                        @endphp
                        @if($logo_id)
                            <?php $logo = get_file_url($logo_id,'full') ?>
                            <img src="{{$logo}}" alt="{{setting_item("site_title")}}">
                        @endif
                    </a>
                    @if($headerStyle == 'transparent')
                    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
                        <div class="mobile-overlay"></div>
                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>
                            <div class="menu js-navList">
                                @php generate_menu('primary',[
                                    'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                                    'custom_class' => ($headerStyle == 'transparent') ? 'text-white' : 'text-dark-1'
                                 ])
                                @endphp
                            </div>
                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($headerStyle != 'transparent')
                        <div class="single-field searchMenu relative xl:d-none">
                            <div data-x-click="searchMenu" class="d-flex items-center">
                                <input class="ml-15 py-0 text-white ph-white rounded-8" type="email" placeholder="{{__('Destination, attraction, hotel, etc')}}">
                                <button class="absolute d-flex items-center h-full">
                                    <i class="icon-search text-20 text-white"></i>
                                </button>
                            </div>

                            <div class="searchMenu__field shadow-2" data-x="searchMenu" data-x-toggle="is-visible">
                                <div class="bg-white px-30 py-30 sm:px-0 sm:py-15 rounded-4">
                                    <div class="y-gap-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="desktopMenu js-desktopMenu" data-x="desktopMenu" data-x-toggle="is-menu-active">
                        <div class="desktopMenu-overlay"></div>

                        <div class="desktopMenu__content">
                            <div class="mobile-bg js-mobile-bg"></div>

                            <div class="px-30 py-20 sm:px-20 sm:py-10 border-bottom-light">
                                <div class="row justify-between items-center">
                                    <div class="col-auto">
                                        <div class="text-20 fw-500">{{__('Main Menu')}}</div>
                                    </div>

                                    <div class="col-auto">
                                        <button class="icon-close text-15" data-x-click="desktopMenu"></button>
                                    </div>
                                </div>
                            </div>

                            <div class="h-full px-30 py-30 sm:px-0 sm:py-10">
                                <div class="menu js-navList">
                                    @php generate_menu('primary',[
                                            'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                                            'custom_class' => ($row->header_style ?? '' == 'transparent') ? 'text-white' : 'text-dark-1',
                                            'desktop_menu' => true
                                         ])
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex items-center text-white">
                    @if($headerStyle != 'transparent')
                        <div class="row x-gap-20 items-center xxl:d-none">
                            <div class="col-auto">
                                @include('Core::frontend.currency-switcher')
                            </div>
                            <div class="col-auto">
                                <div class="w-1 h-20 bg-white-20"></div>
                            </div>
                            <div class="col-auto">
                                @include('Language::frontend.switcher-dropdown')
                            </div>
                        </div>
                    @else
                        @include('Core::frontend.currency-switcher')
                        @include('Language::frontend.switcher-dropdown')
                    @endif

                    @if(!Auth::check())
                        <div class="d-flex items-center ml-20 is-menu-opened-hide md:d-none">
                            <a href="{{ url('/login') }}" class="button px-30 fw-400 text-14 {{ ($row->header_style ?? '' == 'transparent') ? '-white bg-white text-dark-1' : '-blue-1 bg-blue-1 text-white' }} h-50">{{ __('Become An Expert') }}</a>
                            <a href="{{ url('/register') }}" class="button px-30 fw-400 text-14 {{ ($row->header_style ?? '' == 'transparent') ? 'border-white -outline-white text-white' : '-outline-blue-1 text-blue-1' }}  h-50 ml-20">{{ __('Sign In / Register') }}</a>
                        </div>

                        <div class="d-none xl:d-flex x-gap-20 items-center pl-30 text-white" data-x="header-mobile-icons" data-x-toggle="text-white">
                            <div><a href="{{ url('/login') }}" class="d-flex items-center icon-user text-inherit text-22"></a></div>
                            <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                        </div>
                    @else
                        <div class="login-item dropdown ml-20">
                            <a href="#" data-bs-toggle="dropdown" class="is_login">
                                @if($avatar_url = Auth::user()->getAvatarUrl())
                                    <img class="avatar" src="{{$avatar_url}}" alt="{{ Auth::user()->getDisplayName()}}" width="30" height="30">
                                @else
                                    <span class="avatar-text">{{ucfirst( Auth::user()->getDisplayName()[0])}}</span>
                                @endif
                                {{__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])}}
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu text-left">

                                @if(Auth::user()->hasPermissionTo('dashboard_vendor_access'))
                                    <li><a href="{{route('vendor.dashboard')}}" class="dropdown-item"><i class="icon ion-md-analytics"></i> {{__("Vendor Dashboard")}}</a></li>
                                @endif
                                <li class="@if(Auth::user()->hasPermissionTo('dashboard_vendor_access')) menu-hr @endif">
                                    <a href="{{route('user.profile.index')}}" class="dropdown-item"><i class="icon ion-md-construct"></i> {{__("My profile")}}</a>
                                </li>
                                @if(setting_item('inbox_enable'))
                                    <li class="menu-hr"><a href="{{route('user.chat')}}" class="dropdown-item"><i class="fa fa-comments"></i> {{__("Messages")}}</a></li>
                                @endif
                                <li class="menu-hr"><a href="{{route('user.booking_history')}}" class="dropdown-item"><i class="fa fa-clock-o"></i> {{__("Booking History")}}</a></li>
                                <li class="menu-hr"><a href="{{route('user.change_password')}}" class="dropdown-item"><i class="fa fa-lock"></i> {{__("Change password")}}</a></li>
                                @if(Auth::user()->hasPermissionTo('dashboard_access'))
                                    <li class="menu-hr"><a href="{{route('admin.index')}}" class="dropdown-item"><i class="icon ion-ios-ribbon"></i> {{__("Admin Dashboard")}}</a></li>
                                @endif
                                <li class="menu-hr">
                                    <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{__('Logout')}}</a>
                                </li>
                            </ul>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
