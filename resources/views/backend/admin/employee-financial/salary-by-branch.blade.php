@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลด้านการเงิน /</span> เงินเดือน</h4>
    <div class="row">
      @php
      $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
  @endphp
  <div class="col-md-12">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
          <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
      @endif
    @endforeach
    <div class="card">
      <h5 class="card-header">ข้อมูลพนักงาน {{$branch}}</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>#</th>
              <th>ชื่อ-นามสกุล</th>
              <th>ชื่อเล่น</th>
              <th>เบอร์โทรศัพท์</th>
              <th>ตำแหน่ง</th>
              <th>วันที่เริ่มงาน</th>
              <th>เงินเดือนปัจจุบัน</th>
              <th></th>
            </tr>
          </thead>
          @foreach ($employees as $employee => $value)
          @php
              $position = DB::table('positions')->where('id',$value->position_id)->value('position');
          @endphp
          <tbody class="table-border-bottom-0">
            <tr>
              <td>
                <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" data-bs-toggle="modal" data-bs-target="#backDropModal">
                  <i class='bx bx-folder-plus'></i>
                </a>
                <a href="{{url('/admin/salary-information')}}/{{$branch_id}}/{{$value->id}}"><i class='bx bx-folder-open'></i></a>
              </td>
              <td>{{$NUM_PAGE*($page-1) + $employee+1}}</td>
              <td>{{$value->name}} {{$value->surname}}</td>
              <td>{{$value->nickname}}</td>
              <td>{{$value->tel}}</td>
              <td>{{$position}}</td>
              <td>{{$value->startdate}}</td>
              @php
                $salary = DB::table('salarys')->where('employee_id',$value->id)->orderBy('id','desc')->first();
                $dayoff = DB::table('dayoffs')->where('employee_id',$value->id)->orderBy('id','desc')->first();
              @endphp
              <td>
                @if($salary != NULL)
                  {{number_format((float)$salary->salary)}} บาท
                @else 
                  <a href="{{url('/admin/salary-by-branch')}}/{{$value->branch_id}}">กรอกเงินเดือน</a>
                @endif
              </td>
              <td>
                <!-- Modal -->
                <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                  <div class="modal-dialog">
                    <form action="{{url('admin/create-salary')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                      <div class="modal-header">
                        <h5 class="modal-title" id="backDropModalTitle">กรอกเงินเดือน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label class="form-label">เลือกปี</label>
                            <select class="select2 form-select" name="year">
                              <option value="เลือกปี">เลือกปี</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                              <option value="2023">2023</option>
                              <option value="2024">2024</option>
                              <option value="2025">2025</option>
                              <option value="2026">2026</option>
                              <option value="2027">2027</option>
                              <option value="2028">2028</option>
                              <option value="2029">2029</option>
                              <option value="2030">2030</option>
                            </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">เลือกเดือน</label>
                            <select class="select2 form-select" name="month">
                              <option value="เลือกเดือน">เลือกเดือน</option>
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
                            <label class="form-label">เงินเดือน</label>
                            <input type="text" name="salary" class="form-control" value="0" style="font-family:'Sarabun';"/>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label">สถานะ</label>
                            <select class="select2 form-select" name="status">
                              <option value="เปิด">เปิด</option>
                              <option value="ปิด">ปิด</option>
                            </select>
                          </div>
                          <input type="hidden" name="employee_id" value="{{$value->id}}">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                        <button type="submit" class="btn btn-primary" style="font-family:'Sarabun';">บันทึกข้อมูล</button>
                      </div>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
          @endforeach
        </table>
      </div>
    </div>
  </div>
    </div>
</div>
@endsection