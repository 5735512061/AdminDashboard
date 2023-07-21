@extends("frontend/layouts/employee/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
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
                  <th>ประเมินพนักงาน</th>
                </tr>
              </thead>
              @foreach ($employees as $employee => $value)
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>{{$NUM_PAGE*($page-1) + $employee+1}}</td>
                  <td>{{$value->name}} {{$value->surname}}</td>
                  <td>{{$value->nickname}}</td>
                  @php
                    $date = App\Model\EmployeeRate::where('employee_id',$value->id)->orderBy('created_at','desc')->first();

                    if($date == NULL) {
                      $date_mY = NULL;

                      $dateNow = strtr($dateNow,'/','-');           
                      $date_dN = date('d',strtotime($dateNow));
                      $date_mN = date('m',strtotime($dateNow));
                      $date_yN = date('Y',strtotime($dateNow));
                      $date_mYN = $date_mN.'/'.$date_yN;
                    }
                          
                    else {
                      $date = strtr($date->date,'/','-');
                      $date_d = date('d',strtotime($date));
                      $date_m = date('m',strtotime($date));
                      $date_y = date('Y',strtotime($date));
                      $date_mY = $date_m.'/'.$date_y;
                      
                      $dateNow = strtr($dateNow,'/','-');           
                      $date_dN = date('d',strtotime($dateNow));
                      $date_mN = date('m',strtotime($dateNow));
                      $date_yN = date('Y',strtotime($dateNow));
                      $date_mYN = $date_mN.'/'.$date_yN;
                    }
                    @endphp
                      @if($date_mY === $date_mYN)
                        <td>
                          <a style="color:green;">
                              <i class="fa fa-check"></i> ประเมินเรียบร้อย
                          </a>
                        </td>
                      @elseif($date_mY !== $date_mYN)
                        <td>
                          <a style="color:#525F7F;" href="{{url('/staff/from-employee-evaluate/')}}/{{$value->id}}">
                              <i class="ni ni-chart-bar-32 text-primary"></i> ประเมินพนักงาน
                          </a>
                        </td>
                      @elseif($date_mY == NULL || $date_mYN == NULL)
                        <td>
                          <a style="color:#525F7F;" href="{{url('/staff/from-employee-evaluate/')}}/{{$value->id}}">
                              <i class="ni ni-chart-bar-32 text-primary"></i> ประเมินพนักงาน
                          </a>
                        </td>
                      @endif
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