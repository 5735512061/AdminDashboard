<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
   @php
       $image = Auth::guard('staff')->user()->image;
   @endphp
   <ul class="navbar-nav flex-row align-items-center ms-auto">
     <li class="nav-item navbar-dropdown dropdown-user dropdown">
       <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
         <div class="avatar avatar-online">
          @if($image == NULL)
            <img src="{{ asset('/assets/img/avatars/profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
          @else
            <img src="{{url('img_upload/employee/profile')}}/{{$image}}" alt class="w-px-40 h-auto rounded-circle" style="height: 40px !important;"/>
          @endif
         </div>
       </a>
       <ul class="dropdown-menu dropdown-menu-end">
         <li>
           <a class="dropdown-item" href="#">
             <div class="d-flex">
               <div class="flex-shrink-0 me-3">
                 <div class="avatar avatar-online">
                  @if($image == NULL)
                    <img src="{{ asset('/assets/img/avatars/profile.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                  @else
                    <img src="{{url('img_upload/employee/profile')}}/{{$image}}" alt class="w-px-40 h-auto rounded-circle" style="height: 40px !important;"/>
                  @endif
                 </div>
               </div>
               <div class="flex-grow-1">
                 <span class="fw-semibold d-block">{{Auth::guard('staff')->user()->name}} {{Auth::guard('staff')->user()->surname}}</span>
                 @php
                     $position = DB::table('positions')->where('id',Auth::guard('staff')->user()->position_id)->value('position');
                 @endphp
                 <p>{{$position}}</p>
               </div>
             </div>
           </a>
         </li>
         <li>
           <div class="dropdown-divider"></div>
         </li>
         <li>
           <a class="dropdown-item" href="{{url('/staff/profile')}}">
             <i class="bx bx-user me-2"></i>
             <span class="align-middle">ข้อมูลส่วนตัว</span>
           </a>
         </li>
         <li>
           <div class="dropdown-divider"></div>
         </li>
         <li>
            <a class="dropdown-item" href="{{ route('staff.logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">ออกจากระบบ</span>
            </a>
            <form id="logout-form" action="{{ 'App\Employee' == Auth::getProvider()->getModel() ? route('staff.logout') : route('staff.logout') }}" method="POST" style="display: none;">
              @csrf
            </form> 
         </li>
       </ul>
     </li>
   </ul>
  </div>
</nav>