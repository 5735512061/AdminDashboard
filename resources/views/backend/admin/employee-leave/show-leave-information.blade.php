@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลวันหยุด /</span> ข้อมูลวันลา</h4>
    <div class="row">
      <div class="col-md-12">
        <!-- Hoverable Table rows -->
        <div class="card">
          <h5 class="card-header">ข้อมูลวันลา</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>ประเภท</th>
                  <th>วันที่ยื่นใบลา</th>
                  <th>จำนวนวันลา</th>
                  <th>วันที่ลา</th>
                  <th>รายละเอียด</th>
                  <th>สถานะ</th>
                </tr>
              </thead>
              @foreach ($leaves as $leave => $value)
              @php
                $name = DB::table('employees')->where('id',$value->employee_id)->value('name'); 
                $surname = DB::table('employees')->where('id',$value->employee_id)->value('surname'); 
                $nickname = DB::table('employees')->where('id',$value->employee_id)->value('nickname'); 
                $status_leave_approval = DB::table('leave_approvals')->where('leave_id',$value->id)->value('status');
              @endphp
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $leave+1}}</td>
                  <td>{{$name}} {{$surname}}</td>
                  <td>{{$nickname}}</td>
                  <td>{{$value->type_leave}}</td>
                  <td>{{$value->date}}</td>
                  <td>{{$value->number_of_leave}} วัน</td>
                  <td>{{$value->start_date}} ถึง {{$value->end_date}}</td>
                  <td>
                    <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" data-bs-toggle="modal" data-bs-target="#backDropModal">
                      <i class='bx bx-folder-open'></i> เหตุผลการลา
                    </a>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/create-work')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="employee_id" value="{{$value->id}}">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">   
                              <div class="mb-3 col-md-12">
                                <div class="card">
                                  <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                                      <div class="่justify-content-between flex-sm-row flex-column gap-3">
                                        <div class="flex-sm-column flex-row align-items-start justify-content-between">
                                          <div class="card-title">
                                            <h5 class="text-nowrap 2">{{$name}} {{$surname}}</h5><hr>
                                            <p>ยื่นใบลาวันที่ {{$value->date}}</p>
                                            <p>ประเภทการลา : {{$value->type_leave}}</p>
                                            <p>{{$value->number_of_leave}} วัน ตั้งแต่ {{$value->start_date}} - {{$value->end_date}}</p>
                                            <p style="color: red;">เหตุผล : {{$value->detail}}</p>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </td>
                  <td style="color: green;">{{$status_leave_approval}}</td>
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