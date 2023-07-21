@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <center>
                        <div class="align-items-start align-items-sm-center gap-4">
                            @if($employee->image == NULL)
                              <img src="{{ asset('/assets/img/avatars/profile.png')}}" alt="profile" width="50%"/>
                            @else
                              <img src="{{url('img_upload/employee/profile')}}/{{$employee->image}}" alt="profile" width="50%"/>
                            @endif
                        </div>
                        @php
                            $position = DB::table('positions')->where('id',$employee->position_id)->value('position');
                            $branch = DB::table('branch_groups')->where('id',$employee->branch_id)->value('branch');
                        @endphp
                        <h4 class="mt-5">{{$employee->name}} {{$employee->surname}} ( {{$employee->nickname}} ) ตำแหน่งงาน : {{$position}}</h4>
                        <p>{{$branch}}</p>
                        @php
                            $dayoff = DB::table('dayoffs')->where('employee_id',$employee->id)->orderBy('id','desc')->first();
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
                            <a href="{{url('/employee/employee-dayoff')}}">กรอกวันหยุดประจำปี</a><br>
                        @endif
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body" style="margin-bottom: 100px;">
                    <h5 class="card-header">ข้อมูลส่วนตัว</h5><hr class="my-0" />
                    <div class="row">
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="ชื่อ : {{$employee->name}} {{$employee->surname}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="หมายเลขบัตรประชาชน : {{$employee->idcard}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="วัน/เดือน/ปีเกิด : {{$employee->bday}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="เบอร์โทรศัพท์ : {{$employee->tel}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="วันที่เริ่มงาน : {{$employee->startdate}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                          @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                            @php
                                $salary = DB::table('salarys')->where('employee_id',$employee->id)->orderBy('id','desc')->first();
                            @endphp
                            @if($salary != NULL)
                                <input class="form-control" type="text" value="เงินเดือนปัจจุบัน : {{number_format((float)$salary->salary)}} บาท"/>
                            @else 
                                <a href="{{url('/admin/salary-by-branch')}}/{{$employee->branch_id}}">กรอกเงินเดือน</a>
                            @endif
                          @endif
                        </div>
                        <div class="mb-3 mt-3 col-md-12">
                            <input class="form-control" type="text" value="ที่อยู่ : {{$employee->address}} ตำบล{{$employee->district}} อำเภอ{{$employee->amphoe}} จังหวัด{{$employee->province}} {{$employee->zipcode}}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลการทำงาน</h4><hr>
                        <a href="{{url('/admin/employee-work-information')}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      @endif
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลการลางาน</h4><hr>
                        <a href="{{url('/admin/employee-leave-information')}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลเงินเดือน</h4><hr>
                        <a href="{{url('/admin/salary-information')}}/{{$employee->branch_id}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      @endif
      @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">ข้อมูลเงินกองทุนสะสม</h4><hr>
                        <a href="{{url('/admin/provident-fund-information')}}/{{$employee->branch_id}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
      @endif
        <div class="col-md-3 col-12 mb-4">
            <div class="card">
              <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                  <div class="่justify-content-between flex-sm-row flex-column gap-3">
                    <div class="flex-sm-column flex-row align-items-start justify-content-between">
                      <div class="card-title">
                        <h4 class="text-nowrap mb-2">การใช้สิทธิ์สวัสดิการ</h4><hr>
                        <a href="{{url('#')}}/{{$employee->branch_id}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
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
                        <h4 class="text-nowrap mb-2">ผลการประเมิน</h4><hr>
                        <a href="{{url('#')}}/{{$employee->branch_id}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
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
                        <a href="{{url('#')}}/{{$employee->branch_id}}/{{$employee->id}}"><p style="text-align: right;">ข้อมูลเพิ่มเติม >></p></a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection