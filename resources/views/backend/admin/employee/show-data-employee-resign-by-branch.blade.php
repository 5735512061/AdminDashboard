@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> แสดงข้อมูลพนักงานที่ลาออก</h4>
    <div class="row">
      @php
          $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
      @endphp
      <div class="col-md-12">
        <!-- Hoverable Table rows -->
        <div class="card">
          <h5 class="card-header">ข้อมูลพนักงานที่ลาออก {{$branch}}</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>เบอร์โทรศัพท์</th>
                  <th>ตำแหน่ง</th>
                  <th>วันที่เริ่มงาน</th>
                  @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                  <th>เงินเดือนปัจจุบัน</th>
                  @endif
                  <th></th>
                </tr>
              </thead>
              @foreach ($employees as $employee => $value)
              @php
                  $position = DB::table('positions')->where('id',$value->position_id)->value('position');
              @endphp
              <tbody class="table-border-bottom-0">
                <tr>
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
                  @if(Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                    <td>
                      @if($salary != NULL)
                        {{number_format((float)$salary->salary)}} บาท
                      @else 
                        <a href="{{url('/admin/salary-by-branch')}}/{{$value->branch_id}}">กรอกเงินเดือน</a>
                      @endif
                    </td>
                  @endif
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
              @endforeach
            </table>
          </div>
        </div>
        <!--/ Hoverable Table rows -->
      </div>
    </div>
</div>
@endsection