@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> เพิ่มตำแหน่งงาน</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">ตำแหน่งงาน</h5>
          <div class="card-body">
            <form action="{{url('admin/create-position')}}" method="POST" enctype="multipart/form-data">@csrf
              @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
              @endforeach
              <div class="row">
                <input type="hidden" name="branch_group_id" value="{{$branch_id}}">
                <div class="mb-3 col-md-6">
                  <label class="form-label">ตำแหน่งงาน</label>
                  @if ($errors->has('position'))
                    <strong style="color: red;">( {{ $errors->first('position') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="position" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">สถานะ</label>
                  <select class="select2 form-select" name="status">
                    <option value="เปิด">เปิด</option>
                    <option value="ปิด">ปิด</option>
                  </select>
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2" style="font-family: 'Sarabun';">เพิ่มตำแหน่งงาน</button>
                <button type="reset" class="btn btn-outline-secondary" style="font-family: 'Sarabun';">ยกเลิก</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">ตำแหน่งงาน</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>สาขาในเครือ</th>
                  <th>ตำแหน่งงาน</th>
                  <th>สถานะ</th>
                  <th>แก้ไข / ลบ</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($positions as $position => $value)
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $position+1}}</td>
                  @php
                      $brach_group = DB::table('branch_groups')->where('id',$value->branch_group_id)->value('branch');
                  @endphp
                  <td>{{$brach_group}}</td>
                  <td>{{$value->position}}</td>
                  <td>{{$value->status}}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#backDropModal">
                          <i class="bx bx-edit-alt me-1"></i>แก้ไข
                        </a>
                        <a class="dropdown-item" href="{{url('/admin/position-delete/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                          <i class="bx bx-trash me-1"></i>ลบ
                        </a>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/position-edit')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="id" value="{{$value->id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">แก้ไขตำแหน่งงาน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <label class="form-label">ตำแหน่งงาน</label>
                                <input type="text" name="position" class="form-control" value="{{$value->position}}" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="mb-3 col-md-6">
                                <label class="form-label">สถานะ</label>
                                <select class="select2 form-select" name="status">
                                  <option value="{{$value->status}}">{{$value->status}}</option>
                                  <option value="เปิด">เปิด</option>
                                  <option value="ปิด">ปิด</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" name="branch_id" value="{{$branch_id}}">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                            <button type="submit" class="btn btn-primary" style="font-family:'Sarabun';">แก้ไขตำแหน่งงาน</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
