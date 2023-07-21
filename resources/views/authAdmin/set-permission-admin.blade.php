@extends("backend/layouts/admin/template-without-menu") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลผู้ดูแล /</span> กำหนดสิทธิ์การใช้งาน</h4>
    <div class="row">
      <div class="col-md-12">
        <a href="{{url('/admin/register')}}" class="btn btn-primary mb-2" style="font-family: 'Sarabun';">ลงทะเบียนผู้ดูแลระบบ</a>
        <div class="card">
          <h5 class="card-header">กำหนดสิทธิ์การใช้งานผู้ดูแลระบบ</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ</th>
                  <th>username</th>
                  <th>รหัสผ่าน</th>
                  <th>บทบาท</th>
                  <th>สถานะ</th>
                  <th></th>
                </tr>
              </thead>
              @foreach ($admins as $admin => $value)
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $admin+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->username}}</td>
                  <td>{{$value->password_name}}</td>
                  <td>{{$value->role}}</td>
                  <td>{{$value->status}}</td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#backDropModal">
                          <i class="bx bx-edit-alt me-1"></i>แก้ไขข้อมูล
                        </a>
                        <a class="dropdown-item" href="{{url('/admin/permission-admin-delete/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')"><i class="bx bx-trash me-1"></i> ลบข้อมูล</a>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/permission-admin-edit')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="id" value="{{$value->id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">แก้ไขสิทธิ์การใช้งานผู้ดูแลระบบ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="mb-3">
                                <label  class="form-label">ชื่อผู้ใช้งาน</label>
                                @if ($errors->has('name'))
                                    <strong style="color: red;">( {{ $errors->first('name') }} )</strong>
                                @endif
                                <input type="text" class="form-control" name="name" value="{{$value->name}}" style="font-family: 'Sarabun';" autofocus/>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label">สิทธิ์การเข้าใช้งาน</label>
                                  <select class="form-select" name="role">
                                      <option value="{{$value->role}}">{{$value->role}}</option>
                                      <option value="ผู้ดูแล">ผู้ดูแล</option>
                                      <option value="ผู้แก้ไข">ผู้แก้ไข</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label">ชื่อเข้าใช้งานระบบ</label>
                                  @if ($errors->has('username'))
                                      <strong style="color: red;">( {{ $errors->first('username') }} )</strong>
                                  @endif
                                  <input type="text" class="form-control" name="username" value="{{$value->username}}" style="font-family: 'Sarabun';" autofocus/>
                              </div>
                              <div class="mb-3">
                                  <label class="form-label">สถานะ</label>
                                  <select class="form-select" name="status">
                                      <option value="{{$value->status}}">{{$value->status}}</option>
                                      <option value="เปิด">เปิด</option>
                                      <option value="ปิด">ปิด</option>
                                  </select>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                            <button type="submit" class="btn btn-primary" style="font-family:'Sarabun';">แก้ไขสิทธิ์การใช้งานผู้ดูแลระบบ</button>
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