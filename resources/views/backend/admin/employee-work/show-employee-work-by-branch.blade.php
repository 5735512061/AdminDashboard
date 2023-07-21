@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลการทำงาน /</span> เพิ่มข้อมูลการทำงาน</h4>
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
                  <th></th>
                  <th>#</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>เงินเดือนปัจจุบัน</th>
                  <th>ปี</th>
                  <th>เดือน</th>
                  <th>บวกอื่นๆ</th>
                  <th>ขาดงาน (วัน)</th>
                  <th>สาย (วัน)</th>
                  <th>เบี้ยขยัน</th>
                  <th>ค่าประกันสังคม</th>
                  <th>หักอื่นๆ</th>
                  <th>หมายเหตุ</th>
                  <th>ยอดคงเหลือ</th>
                  <th></th>
                </tr>
              </thead>
              @foreach ($employees as $employee => $value)
              @php
                  $position = DB::table('positions')->where('id',$value->position_id)->value('position');
                  $salary = DB::table('salarys')->where('employee_id',$value->id)->orderBy('id','desc')->value('salary');
              @endphp
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <a data-bs-toggle="modal" data-bs-target="#backDropModal{{$value->id}}" data-bs-toggle="modal" data-bs-target="#backDropModal">
                      <i class='bx bx-folder-plus'></i>
                    </a>
                    <a href="{{url('/admin/employee-work-information')}}/{{$value->id}}"><i class='bx bx-folder-open'></i></a>
                  </td>
                  <td>{{$NUM_PAGE*($page-1) + $employee+1}}</td>
                  <td>{{$value->name}} {{$value->surname}}</td>
                  <td>{{$value->nickname}}</td>
                  <td>
                    @if($salary != NULL)
                      {{number_format((float)$salary)}} บาท
                    @else 
                      <a href="{{url('/admin/salary-by-branch')}}/{{$value->branch_id}}">กรอกเงินเดือน</a>
                    @endif
                  </td>
                  <td><?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('year'));?></td>
                  <td><?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('month'));?></td>
                  <td>+ <?php echo number_format((float)(DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('charge')));?></td>
                  <td><?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('absence'));?></td>
                  <td><?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('late'));?></td>
                  @php
                      $late = (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('late'));
                      $absence = (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('absence'));
                  @endphp
                  @if($late == 0 && $absence == 0)
                    <td>+ 1,000</td>
                  @else 
                    <td>0</td>
                  @endif
                  <td>- <?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('insurance'));?></td>
                  <td>- <?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('deduct'));?></td>
                  <td><?php echo (DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('comment'));?></td>
                  @if($salary != NULL)
                    @php
                      $salary = DB::table('salarys')->where('employee_id',$value->id)->orderBy('id','desc')->value('salary');
                      $salary = str_replace(',','',$salary);
                      $salary = (int)$salary;

                      $charge = DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('charge');
                      $charge = str_replace(',','',$charge);
                      $charge = (int)$charge;

                      $insurance = DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('insurance');
                      $insurance = str_replace(',','',$insurance);
                      $insurance = (int)$insurance;

                      $deduct = DB::table('employee_works')->where('employee_id',$value->id)->orderBy('id','desc')->value('deduct');
                      $deduct = str_replace(',','',$deduct);
                      $deduct = (int)$deduct;

                      if($late == 0 && $absence == 0)
                        $salary = (($salary+1000)+($charge))-$insurance-$deduct;
                      elseif($late != 0 || $absence != 0)
                      $salary = ($salary+$charge)-$insurance-$deduct;
                      $salary = number_format($salary);
                    @endphp
                  @endif
                  <td style="color: red;">{{$salary}}</td>
                  <td>
                    <!-- Modal -->
                    <div class="modal fade" id="backDropModal{{$value->id}}" data-bs-backdrop="static" tabindex="-1">
                      <div class="modal-dialog">
                        <form action="{{url('admin/create-work')}}" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                          <input type="hidden" name="employee_id" value="{{$value->id}}">
                          <div class="modal-header">
                            <h5 class="modal-title" id="backDropModalTitle">กรอกข้อมูลการทำงาน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">   
                              <div class="mb-3 col-md-6">
                                <label class="form-label">เลือกปี</label>
                                <select class="select2 form-select" name="year">
                                  <option value="2021">2021</option>
                                  <option value="2022">2022</option>
                                  <option value="2023">2023</option>
                                  <option value="2024">2024</option>
                                  <option value="2025">2025</option>
                                  <option value="2026">2026</option>
                                </select>
                              </div>
                              <div class="mb-3 col-md-6">
                                <label class="form-label">เลือกเดือน</label>
                                <select class="select2 form-select" name="month">
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
                                <label class="form-label">บวกอื่นๆ</label>
                                <input type="text" name="charge" class="form-control" value="0" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label class="form-label">ขาด (วัน)</label>
                                <input type="text" name="absence" class="form-control" value="0" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label class="form-label">สาย (วัน)</label>
                                <input type="text" name="late" class="form-control" value="0" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label class="form-label">ค่าประกันสังคม</label>
                                <input type="text" name="insurance" class="form-control" value="0" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label class="form-label">หักอื่นๆ</label>
                                <input type="text" name="deduct" class="form-control" value="0" style="font-family:'Sarabun';"/>
                              </div>
                              <div class="col-md-6 mb-3"></div>
                              <div class="col-md-12 mb-3">
                                <label class="form-label">หมายเหตุ</label>
                                <textarea class="form-control" rows="3" name="comment" style="font-family:'Sarabun';"></textarea>
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