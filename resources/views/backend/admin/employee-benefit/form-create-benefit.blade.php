@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลสวัสดิการ /</span> เพิ่มหัวข้อสวัสดิการ</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">หัวข้อสวัสดิการ</h5>
          <div class="card-body">
            <form action="{{url('admin/create-benefit')}}" method="POST" enctype="multipart/form-data">@csrf
              @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
              @endforeach
              <div class="row">
                <div class="mb-3 col-md-4">
                  <label class="form-label">สวัสดิการ</label>
                  @if ($errors->has('benefit'))
                    <strong style="color: red;">( {{ $errors->first('benefit') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="benefit"/>
                </div>
                <div class="mb-3 col-md-4">
                  <label class="form-label">ร้านที่ใช้สิทธิ์</label>
                  <select class="select2 form-select" name="store">
                    <option value="LITTLE EDO">LITTLE EDO</option>
                    <option value="EDO RAMEN">EDO RAMEN</option>
                    <option value="EAKKARNYANG">EAKKARNYANG</option>
                  </select>
                </div>
                <div class="mb-3 col-md-4">
                  <label class="form-label">รหัสส่วนลด</label>
                  @php
                      $code = str_random(5);
                      $codeUpper = strtoupper($code);
                  @endphp
                  @if ($errors->has('code'))
                    <strong style="color: red;">( {{ $errors->first('code') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="code" value="#{{$codeUpper}}"/>
                </div>
                <div class="mb-3 col-md-4">
                  <label class="form-label">วันที่หมดเขต</label>
                  @if ($errors->has('expire'))
                    <strong style="color: red;">( {{ $errors->first('expire') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="expire" placeholder="ตัวอย่าง เช่น 31/12/2022"/>
                </div>
                <div class="mb-3 col-md-4">
                  <label class="form-label">สถานะ</label>
                  <select class="select2 form-select" name="status">
                    <option value="เปิด">เปิด</option>
                    <option value="ปิด">ปิด</option>
                  </select>
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-success me-2" style="font-family: 'Sarabun';">เพิ่มหัวข้อสวัสดิการ</button>
                <button type="reset" class="btn btn-outline-secondary" style="font-family: 'Sarabun';">ยกเลิก</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">หัวข้อสวัสดิการ</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>หัวข้อสวัสดิการ</th>
                  <th>ร้านที่ใช้สิทธิ์</th>
                  <th>รหัสส่วนลด</th>
                  <th>วันที่หมดเขต</th>
                  <th>สถานะ</th>
                  <th>แก้ไข / ลบ</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($benefits as $benefit => $value)
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $benefit+1}}</td>
                  <td>{{$value->benefit}}</td>
                  <td>{{$value->store}}</td>
                  <td>{{$value->code}}</td>
                  <td>{{$value->expire}}</td>
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
                        <a class="dropdown-item" href="{{url('/admin/benefit-delete/')}}/{{$value->id}}" onclick="return confirm('Are you sure to delete ?')">
                          <i class="bx bx-trash me-1"></i>ลบ
                        </a>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/benefit-edit')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="id" value="{{$value->id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">แก้ไขหัวข้อสวัสดิการ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12 mb-3">
                                <label class="form-label">หัวข้อสวัสดิการ</label>
                                <input type="text" name="benefit" class="form-control" value="{{$value->benefit}}" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="mb-3 col-md-12">
                                <label class="form-label">ร้านที่ใช้สิทธิ์</label>
                                <select class="select2 form-select" name="status">
                                  <option value="{{$value->store}}">{{$value->store}}</option>
                                  <option value="LITTLE EDO">LITTLE EDO</option>
                                  <option value="EDO RAMEN">EDO RAMEN</option>
                                  <option value="EAKKARNYANG">EAKKARNYANG</option>
                                </select>
                              </div>
                              <div class="mb-3 col-md-12">
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
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                            <button type="submit" class="btn btn-success" style="font-family:'Sarabun';">แก้ไขหัวข้อสวัสดิการ</button>
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
