@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลวันหยุด /</span> อนุมัติวันลา</h4>
    <div class="row">
      @php
        $branch_group = DB::table('branch_groups')->where('status','เปิด')->get();
      @endphp
      @foreach ($branch_group as $branch => $value)
        <div class="col-md-3 col-12 mb-4">
          <div class="card">
            <div class="card-body" style="padding: 1.5rem 1.5rem 0 1.5rem !important;">
                <div class="่justify-content-between flex-sm-row flex-column gap-3">
                  <div class="flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                      <h5 class="text-nowrap mb-2">{{$value->branch}}</h5>
                      @php
                          $amount_employee = DB::table('employees')->where('branch_id',$value->id)->where('status','เปิด')->count();
                      @endphp
                      <span class="badge bg-label-warning rounded-pill mt-2">จำนวนพนักงานในระบบ {{$amount_employee}} คน</span>
                      <h4 class="mt-3">ข้อความใหม่
                        <span class="badge badge-center bg-danger">4</span>
                      </h4>
                      <a href="{{url('/admin/leave-approval-by-branch')}}/{{$value->id}}"><p style="text-align: right;">ดูเพิ่มเติม >></p></a>
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