@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลสวัสดิการ /</span> การใช้สวัสดิการของพนักงาน</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">สิทธิ์สวัสดิการ</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ชื่อผู้ใช้สิทธิ์</th>
                  <th>พนักงานสาขา</th>
                  <th>รหัสส่วนลด</th>
                  <th>ร้านที่ใช้สิทธิ์</th>
                  <th>สิทธิ์สวัสดิการ</th>
                  <th>วันที่หมดเขต</th>
                  <th>วันที่กดรับสิทธิ์</th>
                  <th>สถานะ</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($benefits as $benefit => $value)
                  @php
                      $name = DB::table('employees')->where('id',$value->employee_id)->value('name');
                      $surname = DB::table('employees')->where('id',$value->employee_id)->value('surname');
                      $branch_id = DB::table('employees')->where('id',$value->employee_id)->value('branch_id');
                      $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
                      $code = DB::table('benefits')->where('id',$value->benefit_id)->value('code');
                      $store = DB::table('benefits')->where('id',$value->benefit_id)->value('store');
                      $coupon_benefit = DB::table('benefits')->where('id',$value->benefit_id)->value('benefit');
                      $expire = DB::table('benefits')->where('id',$value->benefit_id)->value('expire');
                  @endphp
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $benefit+1}}</td>
                  <td>{{$name}} {{$surname}}</td>
                  <td>{{$branch}}</td>
                  <td style="color:green;">{{$code}}</td>
                  <td>{{$store}}</td>
                  <td>{{$coupon_benefit}}</td>
                  <td>{{$expire}}</td>
                  <td>{{$value->updated_at}}</td>
                  @if($value->status == "กดรับสิทธิ์")
                    <td style="color:red;">{{$value->status}}</td>
                  @elseif($value->status == "ใช้สิทธิ์แล้ว")
                    <td style="color:green;">{{$value->status}}</td>
                  @endif

                  @php
                      $today = Carbon\carbon::now()->format('Y-m-d');
                  @endphp

                  @if($value->updated_at > $today)
                    <td><a href="{{url('admin/confirm-coupon')}}/{{$value->id}}" class="btn btn-success" style="font-family:'Sarabun'; line-height: 1 !important;">ยืนยันการใช้สิทธิ์</a></td>
                  @elseif($value->updated_at == $today)
                    <td><a href="{{url('admin/confirm-coupon')}}/{{$value->id}}" class="btn btn-success" style="font-family:'Sarabun'; line-height: 1 !important;">ยืนยันการใช้สิทธิ์</a></td>
                  @elseif($value->updated_at < $today)
                    <td><a href="" class="btn btn-danger" style="font-family:'Sarabun'; line-height: 1 !important;">หมดเวลาใช้สิทธิ์</a></td>
                  @endif
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
