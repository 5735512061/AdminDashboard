@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-4">
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
                            <a href="{{url('/admin/staff-dayoff')}}">กรอกวันหยุดประจำปี</a><br>
                        @endif
                        @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                        <a href="{{url('/admin/employee-work-information')}}/{{$staff->id}}">ประวัติการทำงาน</a>
                        @endif
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-header">ข้อมูลวันหยุดประจำปี</h5><hr class="my-0" />
                    @foreach ($dayoffs as $dayoff => $value)
                    <div class="row">
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="{{$value->year}} {{$value->month}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input style="color: red;" class="form-control" type="text" value="วันหยุด : {{$value->dayoff}} วัน"/>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection