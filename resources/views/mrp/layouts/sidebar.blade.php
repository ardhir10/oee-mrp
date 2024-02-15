<nav class="sidebar dark_sidebar mini_sidebar">
    <div class="logo d-flex justify-content-between " style="border-bottom: #ffffff26 1px solid;">
        <a class="large_logo mx-auto" href="{{ url('/') }}"><img src="{{asset('assets')}}/img/itokin-2.png" alt="" style=" max-width: 140; width: auto; max-height: 31px;"></a>
        <a class="small_logo" href="{{ url('/') }}"><img src="{{ asset('assets') }}/img/mini-itokin2.png" alt="" width="50"></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu">

        <li class="">
            <a class="" href="{{ url('/') }}" aria-expanded="true">
                <div class="nav_icon_small">
                    <i class="ti-bag"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Home Page </span>
                </div>
            </a>

        </li>

        <!-- Forecast -->
        <li class="">
            <a class="" href="{{ route('dashboard') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-dashboard"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Dashboard MRP </span>
                </div>
            </a>
        </li>
        <!-- End Forecast -->

         <!-- Forecast -->
         <li class="">
            <a class="" href="{{ route('mrp.forecast-list') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="far fa-newspaper"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Forecast </span>
                </div>
            </a>
        </li>
        <!-- End Forecast -->

        <!-- Production -->
        <li class="">
            <a class="" href="{{ route('mrp.production-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-hummer"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Production </span>
                </div>
            </a>

        </li>
        <!-- End Production -->

        <!-- Delivery -->
        <li class="">
            <a class="" href="{{ route('mrp.delivery-index') }} "
                aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-truck"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Delivery </span>
                </div>
            </a>
        </li>
        <!-- End Delivery -->

        <!-- Inventory -->
        <li class="">
            <a class="" href="{{ route('mrp.inventory-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-archive"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Inventory </span>
                </div>
            </a>
        </li>
        <!-- End Inventory -->

        <!-- Report  -->
        <li class="">
            <a class="has-arrow" href="#" aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-bar-chart"></i>
                </div>
                <div class="nav_title">
                    <span>Report </span>
                </div>
            </a>

            <ul>
                <li><a href="{{ route('mrp.report_smc-list')}}">Report Forecast</a></li>
                <li><a href="{{ route('mrp.report_planning-list')}}">Report Planning Production</a></li>
                <li><a href="{{ route('mrp.report.report-list')}}">Report Production</a></li>
                <li><a href="{{ route('mrp.report.report_wip-list')}}">Report WIP</a></li>
                <!-- <li><a href="{{ route('mrp.report_initial-list')}}">Report Initial</a></li> -->
                <!-- <li><a href="{{ route('mrp.report.report_bom-list')}}">Report BOM</a></li> -->
                <li><a href="{{ route('mrp.report-inventory-index')}}">Report Inventory</a></li>
                <!-- <li><a href="{{ route('mrp.report.report_delivery-list')}}">Report Delivery</a></li> -->

            </ul>
        </li>
        <!-- End Report  -->

        <!-- Master Data -->
        <li class="">
            <a class="" href="{{ route('mrp.master-data-index') }} " aria-expanded="false">
                <div class="nav_icon_small">
                    <i class="ti-folder"></i>
                    {{-- <img src="{{asset('assets')}}/img/menu-icon/dashboard.svg" alt=""> --}}
                </div>
                <div class="nav_title">
                    <span>Master Data </span>
                </div>
            </a>
        </li>
        <!-- End Master Data -->

    </ul>
</nav>
