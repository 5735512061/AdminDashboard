@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-body" style="text-align: center;">
            <h3>สรุปผลการประเมินพนักงานแต่ละไตรมาส</h3>
            <h4>{{$employee->name}} {{$employee->surname}} ({{$employee->nickname}}) ตำแหน่ง {{$employee->position}}</h4>
            <hr class="my-0" />
            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('/staff/from-employee-evaluate')}}" method="POST" enctype="multipart/form-data">@csrf
                        <input type="hidden" name="employee_id" value="{{$employee->id}}">
                        <div class="card-body table-responsive text-nowrap">
                            <table class="table table-responsive table-bordered table-hover">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>ไตรมาส</th>
                                        <th>คะแนนเต็ม 100 คะแนน</th>
                                        <th>เกณฑ์</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($rates as $rate => $value)
                                <?php 
                                    $date = $value->date;
                                    $date = strtr($date,'/','-');

                                    $date_d = date('d',strtotime($date));
                                    $date_m = date('m',strtotime($date));
                                    $date_y = date('Y',strtotime($date));
                                    if($date_m == "03") $date_m = "ไตรมาส 1 (เดือนมกราคม - เดือนมีนาคม)"; if($date_m == "09") $date_m = "ไตรมาส 3 (เดือนกรกฎาคม - เดือนกันยายน)";
                                    if($date_m == "06") $date_m = "ไตรมาส 2 (เดือนเมษายน - เดือนมิถุนายน)"; if($date_m == "12") $date_m = "ไตรมาส 4 (เดือนตุลาคม - เดือนธันวาคม)";

                                    $date_M = date('m',strtotime($date));

                                    if($value->sum >= 70 && $value->sum <= 100) $standard = "ดีมาก";
                                    if($value->sum > 100) $standard = "ดีมาก";
                                    if($value->sum >= 40 && $value->sum <= 69) $standard = "ดี";
                                    if($value->sum >= 0 && $value->sum <= 39) $standard = "แย่";
                                    
                                    $total += $value->sum;
                                    $average = $total/12;
                                    $average = round($average, 0)
                                ?>
                                @if($value->evaluation_id != null)
                                    <tbody>
                                        <tr>
                                            <td>{{$date_m}}</td>
                                            <td>{{$value->sum}}</td>
                                            @if($standard == "ดีมาก")
                                                <td style="color:green;" class="btn btn-success">{{$standard}}</td>
                                            @elseif($standard == "ดี")
                                                <td style="color:yellow;" class="btn btn-warning">{{$standard}}</td>
                                            @else
                                                <td style="color:red;" class="btn btn-danger">{{$standard}}</td>
                                            @endif
                                            <td>
                                                <a href="{{url('/admin/evaluate-form-detail')}}/{{$value->employee_id}}/{{$date_d}}/{{$date_M}}/{{$date_y}}"><i class='bx bxs-bar-chart-alt-2' ></i> รายละเอียดเพิ่มเติม</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @elseif($value->evaluation_id == null)
                                @endif
                            @endforeach
                            </table>
                            <div class="card">
                                <div class="card-body" style="font-family: 'Sarabun';">สรุปผลการประเมินรายปี : {{$average}}/100 คะแนน</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection