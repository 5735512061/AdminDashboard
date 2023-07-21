@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลวันหยุด /</span> อนุมัติวันลา</h4>
    <div class="row">
      @foreach ($leaves as $leave => $value)
        @php
          $name = DB::table('employees')->where('id',$value->employee_id)->value('name');
          $surname = DB::table('employees')->where('id',$value->employee_id)->value('surname');
        @endphp
        <div class="col-md-3 col-12 mb-4">
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
                      <a href="" data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" data-bs-toggle="modal" data-bs-target="#backDropModal">
                        <p style="text-align: right;">อนุมัติวันลา</p> 
                      </a>
                      <!-- Modal -->
                      <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog">
                          <form action="{{url('admin/leave-approval')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                            <div class="modal-header">
                              <h5 class="modal-title" id="backDropModalTitle">อนุมัติวันลาหรือไม่ ?</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="mb-3 col-md-12">
                                  <select class="select2 form-select" name="status">
                                    <option value="อนุมัติการลา">อนุมัติการลา</option>
                                    <option value="ไม่อนุมัติการลา">ไม่อนุมัติการลา</option>
                                  </select>
                                </div>
                                <input type="hidden" name="leave_id" value="{{$value->id}}">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                              <button type="submit" class="btn btn-primary" style="font-family:'Sarabun';">บันทึกข้อมูล</button>
                            </div>
                          </form>
                        </div>
                      </div>
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