@extends("frontend/layouts/employee/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
          <div class="col-md-4">
            <a class="btn btn-secondary mb-4" style="width: 100%; font-family:'Sarabun'; color:#fff;" data-bs-toggle="modal" data-bs-target="#backDropModal" data-bs-toggle="modal" data-bs-target="#backDropModal">
              แสดงบัตรพนักงาน
          </a>
          <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                  <form action="#" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                      @php
                          $position = DB::table('positions')->where('id',$staff->position_id)->value('position');
                          $branch = DB::table('branch_groups')->where('id',$staff->branch_id)->value('branch');
                          $datenow = Carbon\Carbon::now()->format('d/m/Y H:i:s');
                      @endphp
                      {{-- <div style="text-align:end;"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div> --}}
                      <div class="modal-header" style="margin-top: -24px; padding-right:0px !important;">
                          <div class="row">
                              <div class="col-3">
                                  <center><img class="mt-2" src="{{url('image/logo_store/edogroup_logo.png')}}" width="150%"/></center>
                              </div>
                              <div class="col-9">
                                  <div style="color:#fff; background: linear-gradient(299deg, #000000 70%, #ffffff 71%); padding-top: 60px;  padding-left:0px !important;"><br></div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-body">
                          {{-- style="background: linear-gradient(150deg, #389b38 40%, #ffffff 40%);" --}}
                          <center><img src="{{url('img_upload/employee/profile')}}/{{$staff->image}}" alt="profile" width="50%"/></center><br>
                          <center><h5 style="line-height: 0.8; !important">{{$staff->name}} {{$staff->surname}} ({{$staff->nickname}})</h5></center>
                          <center><h6 style="color: #006a00; line-height: 0.8; !important">ตำแหน่ง : {{$position}}</h6></center>
                          <center><h6 style="color: #006a00; line-height: 0.8; !important">{{$branch}}</h6></center>
                          <center><h6 style="color: rgb(255, 0, 0); line-height: 0.8; !important">{{$datenow}}</h6></center>
                      </div>
                      <div class="modal-footer" style="background-color: #000000; justify-content:center !important; padding: 0.25rem 1.5rem 0.5rem !important;">
                          <h6 style="color:#fff;">EDO GROUP</h6> 
                      </div>
                  </form>
              </div>
          </div>
            <div class="card mb-4">
                <div class="card-body">
                    <center>
                        @php
                            $position = DB::table('positions')->where('id',$staff->position_id)->value('position');
                            $branch = DB::table('branch_groups')->where('id',$staff->branch_id)->value('branch');
                        @endphp
                        <h4 class="mt-5">{{$staff->name}} {{$staff->surname}} ( {{$staff->nickname}} ) ตำแหน่งงาน : {{$position}}</h4>
                        <p>{{$branch}}</p>
                        @php
                            $dayoff = DB::table('dayoffs')->where('employee_id',$staff->id)->orderBy('id','desc')->first();
                        @endphp

                        @if($dayoff != NULL)
                            <div>
                                <i class="ni education_hat mr-2"></i>วันหยุดที่ได้รับ : {{$dayoff->dayoff}} วัน/ปี
                            </div>

                            @if($bonus != 0)
                            <h4>
                                <i class="ni education_hat mr-2"></i>วันหยุดคงเหลือ : {{$absenceBalance}} วัน/ปี
                            </h4>
                            @else 
                                <h4 style="color:red;"><i class="ni education_hat mr-2"></i>ใช้วันหยุดเกิน : {{abs($absenceBalance)}} วัน</h3>
                            @endif
                            <p style="color:red;">ขาดงาน {{$absence}} วัน สาย {{$late}} วัน <br>สรุป : ขาดงาน {{$absenceTotal}} วัน สาย {{$lateBalance}} วัน</p>
                        @else 
                            <a href="{{url('/staff/staff-dayoff')}}">กรอกวันหยุดประจำปี</a><br>
                        @endif
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลการทำงาน</h4><hr>
                        <a href="{{url('/staff/work-information')}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลใบลางาน</h4><hr>
                        <a href="{{url('/staff/leave-work')}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลใบเตือน</h4><hr>
                        <a href="{{url('/staff/warning')}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection