@extends("backend/layouts/admin/template") 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link type="text/css" href="{{ asset('css/filter_multi_select.css')}}" rel="stylesheet">
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลสวัสดิการ /</span> เพิ่มสวัสดิการพนักงาน</h4>
    <div class="row">
      @php
          $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
      @endphp
      <div class="col-md-12">
        <!-- Hoverable Table rows -->
        <div class="card">
          <h5 class="card-header">ข้อมูลพนักงาน {{$branch}}</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>ตำแหน่ง</th>
                  <th>สวัสดิการ</th>
                  <th></th>
                </tr>
              </thead>
              @foreach ($employees as $employee => $value)
              @php 
                  $employee_id = $value->id;
                  $position = DB::table('positions')->where('id',$value->position_id)->value('position');
              @endphp
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $employee+1}}</td>
                  <td>{{$value->name}} {{$value->surname}}</td>
                  <td>{{$value->nickname}}</td>
                  <td>{{$position}}</td>
                  @php
                      $benefits = DB::table('employee_benefits')->where('employee_id',$value->id)->orderBy('id','desc')->paginate(1);
                  @endphp
                  <td>
                    @foreach ($benefits as $benefit => $value)
                      @php
                          $benefit = DB::table('benefits')->where('id',$value->benefit_id)->value('benefit');
                          $store = DB::table('benefits')->where('id',$value->benefit_id)->value('store');
                      @endphp
                        / {{$benefit}} ที่ {{$store}} ... <a href="{{url('/admin/employee-benefit-more')}}/{{$employee_id}}">ดูเพิ่มเติม</a> 
                    @endforeach
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$employee_id}}" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#backDropModal">
                          <i class="bx bx-edit-alt me-1"></i>เพิ่มสวัสดิการ
                        </a>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$employee_id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/create-benefit-employee')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="employee_id" value="{{$employee_id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">เพิ่มสวัสดิการ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            @php
                                $benefits = DB::table('benefits')->where('status','เปิด')->get();
                            @endphp   
                            <div class="row">
                              <div class="col-md-12 mb-3">
                                <label class="form-label">หัวข้อสวัสดิการ</label>
                                <select multiple name="benefit_id_{{$employee_id}}[]" class="filter-multi-select">
                                  @foreach ($benefits as $benefit => $value)
                                    <option value="{{$value->id}}">{{$value->benefit}} ที่ {{$value->store}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="mb-3 col-md-12">
                                <label class="form-label">สถานะ</label> 
                                <select class="select2 form-select" name="status">
                                  <option value="เปิด">เปิด</option>
                                  <option value="ปิด">ปิด</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-family:'Sarabun';">ปิด</button>
                            <button type="submit" class="btn btn-success" style="font-family:'Sarabun';">เพิ่มสวัสดิการ</button>
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
<script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script>
<script src="{{ asset('js/filter-multi-select-bundle.min.js')}}"></script>
@endsection