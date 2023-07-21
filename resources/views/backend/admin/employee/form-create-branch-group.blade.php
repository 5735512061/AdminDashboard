@extends("backend/layouts/admin/template-without-menu") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> เพิ่มกลุ่มสาขาในเครือ</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">เพิ่มกลุ่มสาขาในเครือ (EDO GROUP)</h5>
          <div class="card-body">
            <form action="{{url('admin/create-branch-group')}}" method="POST" enctype="multipart/form-data">@csrf
              @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
              @endforeach
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">ร้านค้าในเครือ (EDO GROUP)</label>
                  @if ($errors->has('branch'))
                    <strong style="color: red;">( {{ $errors->first('branch') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="branch" autofocus/>
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
                <button type="submit" class="btn btn-primary me-2" style="font-family: 'Sarabun';">เพิ่มกลุ่มสาขาในเครือ</button>
                <button type="reset" class="btn btn-outline-secondary" style="font-family: 'Sarabun';">ยกเลิก</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">สาขาในเครือ (EDO GROUP)</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อร้านค้าในเครือ</th>
                  <th>สถานะ</th>
                  <th>แก้ไข / ลบ</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($branch_groups as $branch_group => $value)
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $branch_group+1}}</td>
                  <td>{{$value->branch}}</td>
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
                        <a class="dropdown-item" href="{{url('/admin/branch-group-delete/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                          <i class="bx bx-trash me-1"></i>ลบ
                        </a>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/branch-group-edit')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">แก้ไขชื่อร้านค้าในเครือ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <label class="form-label">ชื่อร้านค้าในเครือ</label>
                                <input type="text" name="branch" class="form-control" value="{{$value->branch}}" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="mb-3 col-md-6">
                                <label class="form-label">สถานะ</label>
                                <select class="select2 form-select" name="status">
                                  <option value="{{$value->status}}">{{$value->status}}</option>
                                  <option value="เปิด">เปิด</option>
                                  <option value="ปิด">ปิด</option>
                                </select>
                              </div>
                              <input type="hidden" name="id" value="{{$value->id}}">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                            <button type="submit" class="btn btn-primary" style="font-family:'Sarabun';">แก้ไขชื่อร้านค้า</button>
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