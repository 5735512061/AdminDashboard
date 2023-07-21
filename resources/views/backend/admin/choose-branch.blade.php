@extends("backend/layouts/admin/template-without-menu") 

@section("content")

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-md-3 col-12 mb-4">
        <a href="{{url('/admin/form-create-branch-group')}}">
          <div class="card">
            <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                <div class="่justify-content-between flex-sm-row flex-column gap-3">
                  <div class="flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                      <center><h4>เพิ่มกลุ่มสาขาในเครือ</h4></center>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </a>
      </div>
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
      <div class="col-md-3 col-12 mb-4">
        <a href="{{url('/admin/set-permission-admin')}}">
          <div class="card">
            <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                <div class="่justify-content-between flex-sm-row flex-column gap-3">
                  <div class="flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                      <center><h4>จัดการข้อมูลผู้ดูแลระบบ</h4></center>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </a>
      </div>
      @endif
    </div>
    <h4 class="fw-bold py-3 mb-4">เลือกสาขาในเครือ EDO GROUP จัดการข้อมูลพนักงาน</h4>
      <div class="row">
        @php
          $branch_group = DB::table('branch_groups')->where('status','เปิด')->get();
        @endphp
        @foreach ($branch_group as $branch => $value)
          <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h5 class="text-nowrap mb-2">{{$value->branch}}</h5><hr>
                        @php
                            $amount_employee = DB::table('employees')->where('branch_id',$value->id)->where('status','เปิด')->count();
                        @endphp
                        <p>จำนวนพนักงานในระบบ {{$amount_employee}} คน</p>
                        <a href="{{url('/admin/dashboard')}}/{{$value->id}}"><p style="text-align: right;">จัดการข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
  </div>
@endsection