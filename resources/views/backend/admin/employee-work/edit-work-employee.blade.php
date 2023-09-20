@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลการทำงาน /</span> แก้ไขข้อมูลการทำงาน</h4>
        <div class="row">
            <form action="{{ url('admin/update-work-employee') }}" method="POST" enctype="multipart/form-data">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                    @endif
                @endforeach
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">เลือกปี</label>
                                    <select class="select2 form-select" name="year">
                                        <option value="{{$employee_work->year}}">{{$employee_work->year}}</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">เลือกเดือน</label>
                                    <select class="select2 form-select" name="month">
                                        <option value="{{$employee_work->month}}">{{$employee_work->month}}</option>
                                        <option value="มกราคม">มกราคม</option>
                                        <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                        <option value="มีนาคม">มีนาคม</option>
                                        <option value="เมษายน">เมษายน</option>
                                        <option value="พฤษภาคม">พฤษภาคม</option>
                                        <option value="มิถุนายน">มิถุนายน</option>
                                        <option value="กรกฎาคม">กรกฎาคม</option>
                                        <option value="สิงหาคม">สิงหาคม</option>
                                        <option value="กันยายน">กันยายน</option>
                                        <option value="ตุลาคม">ตุลาคม</option>
                                        <option value="พฤศจิกายน">พฤศจิกายน</option>
                                        <option value="ธันวาคม">ธันวาคม</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">บวกอื่นๆ</label>
                                    <input type="text" name="charge" class="form-control" value="{{$employee_work->charge}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ขาด (วัน)</label>
                                    <input type="text" name="absence" class="form-control" value="{{$employee_work->absence}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">สาย (วัน)</label>
                                    <input type="text" name="late" class="form-control" value="{{$employee_work->late}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ค่าประกันสังคม</label>
                                    <input type="text" name="insurance" class="form-control" value="{{$employee_work->insurance}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">หักอื่นๆ</label>
                                    <input type="text" name="deduct" class="form-control" value="{{$employee_work->deduct}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">ค่าความสามารถ</label>
                                    <input type="text" name="skill" class="form-control" value="{{$employee_work->skill}}"
                                        style="font-family:'Sarabun';" />
                                </div>
                                <div class="col-md-6 mb-3"></div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">หมายเหตุ</label>
                                    <textarea class="form-control" rows="3" name="comment" style="font-family:'Sarabun';">{{$employee_work->comment}}</textarea>
                                </div>
                                <div class="mt-2">
                                    <input type="hidden" name="id" value="{{ $employee_work->id }}">
                                    <button type="submit" class="btn btn-success me-2"
                                        style="font-family: 'Sarabun';">อัพเดตข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
