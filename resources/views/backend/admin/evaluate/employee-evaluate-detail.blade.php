@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-body" style="text-align: center;">
                <h3>ผลการประเมินพนักงานประจำเดือน</h3>
                @php
                    $position = DB::table('positions')
                        ->where('id', $employee->position_id)
                        ->value('position');
                @endphp
                <h4>{{ $employee->name }} {{ $employee->surname }} ({{ $employee->nickname }}) ตำแหน่ง {{ $position }}
                </h4>
                <hr class="my-0" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body table-responsive text-nowrap">
                            <table class="table table-responsive table-bordered table-hover">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>ประจำเดือน</th>
                                        <th>คะแนนเต็ม 100 คะแนน</th>
                                        <th>เกณฑ์</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($rates as $rate => $value)
                                    @if ($yearID == date('Y', strtotime(strtr($value->date, '/', '-'))))
                                        <?php
                                        $date = $value->date;
                                        $date = strtr($date, '/', '-');
                                        
                                        $date_d = date('d', strtotime($date));
                                        $date_m = date('m', strtotime($date));
                                        $date_y = date('Y', strtotime($date));
                                        
                                        if ($date_m == '01') {
                                            $month = 'เดือนมกราคม';
                                        }
                                        if ($date_m == '02') {
                                            $month = 'เดือนกุมภาพันธ์';
                                        }
                                        if ($date_m == '03') {
                                            $month = 'เดือนมีนาคม';
                                        }
                                        if ($date_m == '04') {
                                            $month = 'เดือนเมษายน';
                                        }
                                        if ($date_m == '05') {
                                            $month = 'เดือนพฤษภาคม';
                                        }
                                        if ($date_m == '06') {
                                            $month = 'เดือนมิถุนายน';
                                        }
                                        if ($date_m == '07') {
                                            $month = 'เดือนกรกฎาคม';
                                        }
                                        if ($date_m == '08') {
                                            $month = 'เดือนสิงหาคม';
                                        }
                                        if ($date_m == '09') {
                                            $month = 'เดือนกันยายน';
                                        }
                                        if ($date_m == '10') {
                                            $month = 'เดือนตุลาคม';
                                        }
                                        if ($date_m == '11') {
                                            $month = 'เดือนพฤศจิกายน';
                                        }
                                        if ($date_m == '12') {
                                            $month = 'เดือนธันวาคม';
                                        }
                                        
                                        $date_M = date('m', strtotime($date));
                                        if ($value->sum >= 70 && $value->sum <= 100) {
                                            $standard = 'ดีมาก';
                                        }
                                        if ($value->sum > 100) {
                                            $standard = 'ดีมาก';
                                        }
                                        if ($value->sum >= 40 && $value->sum <= 69) {
                                            $standard = 'ดี';
                                        }
                                        if ($value->sum >= 0 && $value->sum <= 39) {
                                            $standard = 'แย่';
                                        }
                                        
                                        $total += $value->sum;
                                        $average = ($total * 100) / 1200;
                                        $average = round($average, 0);
                                        ?>
                                        @if ($value->evaluation_id != null)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $month }}</td>
                                                    <td>{{ $value->sum }}</td>
                                                    @if ($standard == 'ดีมาก')
                                                        <td style="color:green;">{{ $standard }}
                                                        </td>
                                                    @elseif($standard == 'ดี')
                                                        <td style="color:rgb(231, 126, 5);">
                                                            {{ $standard }}</td>
                                                    @else
                                                        <td style="color:red;" class="btn btn-danger mt-2 mb-2">
                                                            {{ $standard }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <a
                                                            href="{{ url('/admin/evaluate-form-detail') }}/{{ $value->employee_id }}/{{ $date_d }}/{{ $date_M }}/{{ $date_y }}"><i
                                                                class='bx bxs-bar-chart-alt-2'></i> รายละเอียดเพิ่มเติม</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @elseif($value->evaluation_id == null)
                                        @endif
                                    @endif
                                @endforeach
                            </table>
                            <div class="card">
                                <div class="card-body" style="font-family: 'Sarabun';">สรุปผลการประเมินรายปี :
                                    {{ $average }} %</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
