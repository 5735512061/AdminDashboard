@php
    $branch_id = session('branch_id');
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
      <li class="menu-item active">
        <a href="{{url('/admin/choose-branch')}}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-log-out"></i>
          <div data-i18n="Analytics">กลับไปหน้าเลือกสาขา</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/dashboard')}}/{{$branch_id}}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">เกี่ยวกับข้อมูลพนักงาน</span></li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bxs-user"></i>
          <div>จัดการข้อมูลพนักงาน</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/form-create-employee')}}/{{$branch_id}}" class="menu-link">
              <div>เพิ่มพนักงานในระบบ</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/show-data-employee')}}/{{$branch_id}}" class="menu-link">
              <div>แสดงพนักงานในระบบ</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/form-create-position')}}/{{$branch_id}}" class="menu-link">
              <div>เพิ่มตำแหน่งงาน</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/show-data-employee-resign-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>แสดงพนักงานที่ลาออก</div>
            </a>
          </li>
        </ul>
      </li>
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-book-content"></i>
          <div>จัดการข้อมูลการทำงาน</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/show-employee-work-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>ข้อมูลการทำงาน</div>
            </a>
          </li>
        </ul>
      </li>
      @endif
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bxs-calendar-x"></i>
          <div>จัดการข้อมูลวันหยุด</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/leave-approval-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>อนุมัติวันลา</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/show-leave-information')}}/{{$branch_id}}" class="menu-link">
              <div>แสดงข้อมูลการลา</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/dayoff-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>วันหยุดประจำปี</div> 
            </a>
          </li>
        </ul>
      </li>
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-wallet"></i>
          <div>จัดการข้อมูลด้านการเงิน</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/salary-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>เงินเดือน</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/provident-fund-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>เงินกองทุนสะสม</div>
            </a>
          </li>
        </ul>
      </li>
      @endif
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bxs-coupon"></i>
          <div>จัดการข้อมูลสวัสดิการ</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/employee-benefit-by-branch')}}/{{$branch_id}}" class="menu-link">
              <div>เพิ่มสวัสดิการพนักงาน</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/employee-use-benefit')}}/{{$branch_id}}" class="menu-link">
              <div>การใช้สิทธิ์สวัสดิการ</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/form-create-benefit')}}/{{$branch_id}}" class="menu-link">
              <div>เพิ่มหัวข้อสวัสดิการ</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">เกี่ยวกับการประเมินผล</span></li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-news"></i>
          <div>ประเมินพนักงาน</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/form-employee-evaluate')}}/{{$branch_id}}" class="menu-link">
              <div>แบบประเมินพนักงาน</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/list-employee-evaluate')}}/{{$branch_id}}" class="menu-link">
              <div>ผลการประเมินพนักงาน</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bxs-news"></i>
          <div>ประเมินผู้จัดการ</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/form-manager-evaluate')}}/{{$branch_id}}" class="menu-link">
              <div>แบบประเมินผู้จัดการ</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/list-manager-evaluate')}}/{{$branch_id}}" class="menu-link">
              <div>ผลการประเมินผู้จัดการ</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">เกี่ยวกับข้อมูลข่าวสาร / ใบเตือน</span></li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-news"></i>
          <div>จัดการข้อมูลข่าวสาร</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/create-news')}}" class="menu-link">
              <div>เพิ่มข้อมูลข่าวสาร</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/show-news')}}" class="menu-link">
              <div>แสดงข้อมูลข่าวสาร</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-file"></i>
          <div>จัดการข้อมูลใบเตือน</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{url('/admin/create-warning')}}/{{$branch_id}}" class="menu-link">
              <div>เพิ่มใบเตือน</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{url('/admin/show-warning')}}/{{$branch_id}}" class="menu-link">
              <div>แสดงข้อมูลใบเตือน</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-header small text-uppercase"><span class="menu-header-text">ออกจากระบบ</span></li>
      <li class="menu-item">
        <a href="{{ route('admin.logout') }}" class="menu-link" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
          <i class="menu-icon tf-icons bx bx-log-out"></i>
          ออกจากระบบ
        </a>
        <form id="logout-form" action="{{ 'App\Admin' == Auth::getProvider()->getModel() ? route('admin.logout') : route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
</aside>