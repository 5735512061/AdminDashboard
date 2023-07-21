@extends("backend/layouts/admin/template") 

@section("content")
@php
    $date_now = Carbon\Carbon::today()->format('d/m/Y');
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลใบเตือน /</span> ยื่นใบเตือนผ่านระบบ</h4>
    <div class="row">
      @php
          $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
      @endphp
      <div class="col-md-12">
        <!-- Hoverable Table rows -->
        <div class="card">
          <h5 class="card-header">พนักงาน {{$branch}}</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>เบอร์โทรศัพท์</th>
                  <th>ตำแหน่ง</th>
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
                  <td>
                    <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" data-bs-toggle="modal" data-bs-target="#backDropModal">
                      <i class='bx bx-folder-plus'></i> สร้างใบเตือน
                    </a>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/create-warning')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="employee_id" value="{{$value->id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">หนังสือเตือน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">   
                              <div class="mb-3 col-md-6">
                                <label class="form-label">วันที่ยื่นใบเตือน</label>
                                <input type="text" class="form-control" value="{{$date_now}}" name="date" readonly/>
                              </div>
                              <div class="col-md-6 mb-3"></div>
                              <div class="col-md-12 mb-3">
                                <label class="form-label">ฝ่าฝืนคำสั่ง ระเบียบ หรือข้อบังคับเกี่ยวกับการทำงานของบริษัท กล่าวคือ</label>
                                <textarea class="form-control" rows="10" name="warning" style="font-family:'Sarabun';"></textarea>
                              </div>
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
        <!--/ Hoverable Table rows -->
      </div>
    </div>
</div>
@endsection