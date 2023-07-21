@extends("frontend/layouts/employee/template") 

@section("content")
@php
    $date_now = Carbon\Carbon::today()->format('d/m/Y');
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <center>
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
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4>ข้อมูลวันหยุด</h4>
                    @foreach ($leave_days as $leave_day => $value)
                        <div class="row">
                            <div class="mb-3 mt-3 col-md-6">
                                <input class="form-control" type="text" value="{{$value->year}} {{$value->month}}"/>
                            </div>
                            <div class="mb-3 mt-3 col-md-6">
                                <input class="form-control" type="text" value="วันหยุด {{$value->dayoff}} วัน"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h4>ยื่นใบลางาน</h4>
                    <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#backDropModal" style="font-family: 'Sarabun';">
                        แบบฟอร์มใบลางาน
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{url('staff/leave-work')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                                <input type="hidden" name="employee_id" value="{{auth::guard('staff')->user()->id}}">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="backDropModalTitle">แบบฟอร์มใบลางาน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <hr class="my-0" />
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">วันที่ยื่นใบลา</label>
                                            <input type="text" class="form-control" value="{{$date_now}}" name="date" readonly/>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">ประเภทการลา</label>
                                            <select class="select2 form-select" name="type_leave">
                                                <option value="ลาป่วย">ลาป่วย</option>
                                                <option value="ลากิจ">ลากิจ</option>
                                                <option value="ลาอื่นๆ">ลาอื่นๆ</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">จำนวนวันที่ลา</label>
                                            <input type="text" class="form-control" name="number_of_leave"/>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">ตั้งแต่วันที่</label>
                                            <input name="start_date" class="form-control" type="date" id="html5-date-input" />
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">ถึงวันที่</label>
                                            <input name="end_date" class="form-control" type="date" id="html5-date-input" />
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">เหตุผล และรายละเอียด</label>
                                            <textarea name="detail" cols="10" rows="5" class="form-control"></textarea>
                                        </div>
                                        <p style="color: red;">หมายเหตุ : การลาทุกประเภทต้องลาล่วงหน้า ยกเว้นลาป่วย ซึ่งจะต้องส่งใบลาย้อนหลังตั้งแต่วันแรกที่มาทำงาน และหากลาป่วยมากกว่า 3 วัน ต้องแนบใบรับรองแพทย์มาพร้อมกับใบลาป่วย</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family: 'Sarabun';">
                                        ปิด
                                    </button>
                                    <button type="submit" class="btn btn-primary" style="font-family: 'Sarabun';">ยื่นใบลางาน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h4>ประวัติการลางาน</h4>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>วันที่ยื่นใบลา</th>
                                <th>ประเภทการลา</th>
                                <th>จำนวนวันลา</th>
                                <th>ตั้งแต่วันที่</th>
                                <th>ถึงวันที่</th>
                                <th>สถานะ</th>
                                <th></th>
                                </tr>
                            </thead>
                            @foreach ($leave_works as $leave_work => $value)
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>{{$NUM_PAGE*($page-1) + $leave_work+1}}</td>
                                    <td>{{$value->date}}</td>
                                    <td>{{$value->type_leave}}</td>
                                    <td>{{$value->number_of_leave}} วัน</td>
                                    <td>{{$value->start_date}}</td>
                                    <td>{{$value->end_date}}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection