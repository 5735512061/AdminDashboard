<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item active">
            <a href="{{ url('/staff/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/staff/profile') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="ข้อมูลส่วนตัว">ข้อมูลส่วนตัว</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/staff/work-information') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div data-i18n="Analytics">ข้อมูลการทำงาน</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-pie-chart-alt-2"></i>
                <div data-i18n="Account Settings">ข้อมูลด้านการเงิน</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ url('/staff/salary-information') }}" class="menu-link">
                        <div data-i18n="Account">ข้อมูลเงินเดือน</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('/staff/provident-fund-information') }}" class="menu-link">
                        <div data-i18n="Account">เงินกองทุนสะสม</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="{{ url('/staff/benefit') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-coupon"></i>
                <div data-i18n="Account">สวัสดิการพนักงาน</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('/staff/rules') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-book-bookmark"></i>
                <div data-i18n="Account">กฎระเบียบของบริษัท</div>
            </a>
        </li>
        @php
            $position = DB::table('positions')
                ->where('id', auth::guard('staff')->user()->position_id)
                ->value('position');
        @endphp
        @if ($position == 'MANAGER')
            <li class="menu-item">
                <a href="{{ url('/staff/list-employee-evaluate') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-news"></i>
                    <div data-i18n="Account">ทำแบบประเมินพนักงาน</div>
                </a>
            </li>
        @endif

        @if ($position == 'MANAGER' || $position == 'ASSISTANT MANAGER')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">SOP</span></li>
            <li class="menu-item">
                <a href="{{ url('/staff/check-list-sop') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div data-i18n="Account">CHECKLIST SOP</div>
                </a>
            </li>
        @elseif($position == 'HEAD CHEF' || $position == 'SOUS CHEF')
            <li class="menu-header small text-uppercase"><span class="menu-header-text">SOP</span></li>
            <li class="menu-item">
                <a href="{{ url('/staff/check-list-sop-chef') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-list-ul"></i>
                    <div data-i18n="Account">CHECKLIST SOP</div>
                </a>
            </li>
        @endif
        <li class="menu-header small text-uppercase"><span class="menu-header-text">ข้อมูลบัญชี</span></li>
        <li class="menu-item">
            <a href="{{ url('/staff/change-password') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-key"></i>
                <div data-i18n="Analytics">เปลี่ยนรหัสผ่าน</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('staff.logout') }}" class="menu-link"
                onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                ออกจากระบบ
            </a>
            <form id="logout-form"
                action="{{ 'App\Employee' == Auth::getProvider()->getModel() ? route('staff.logout') : route('staff.logout') }}"
                method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>
