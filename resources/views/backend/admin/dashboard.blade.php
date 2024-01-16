@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> แสดงพนักงานในระบบ</h4>
        <div class="row">
            @php
                $branch = DB::table('branch_groups')
                    ->where('id', $branch_id)
                    ->value('branch');
            @endphp
            <div class="col-md-12">
                <!-- Hoverable Table rows -->
                <div class="card">
                    <h5 class="card-header">ข้อมูลพนักงาน {{ $branch }}</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อเล่น</th>
                                    <th>ตำแหน่ง</th>
                                    <th>วันที่เริ่มงาน</th>
                                    @if (Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                                        <th>เงินเดือนปัจจุบัน</th>
                                    @endif
                                    <th>วันหยุดประจำปี</th>
                                    <th>วันหยุดคงเหลือ</th>
                                    <th>ผลการประเมินรายปี (100%)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($employees as $employee => $value)
                                @php
                                    $position = DB::table('positions')
                                        ->where('id', $value->position_id)
                                        ->value('position');

                                    $year = DB::table('employee_works')
                                        ->where('employee_id', $value->id)
                                        ->orderBy('id', 'desc')
                                        ->value('year');

                                    $absence = (int) DB::table('employee_works')
                                        ->where('employee_id', $value->id)
                                        ->where('year', $year)
                                        ->sum('absence'); // หยุด
                                    $late = (int) DB::table('employee_works')
                                        ->where('employee_id', $value->id)
                                        ->where('year', $year)
                                        ->sum('late'); // สาย
                                    $dayoff = DB::table('dayoffs')
                                        ->where('employee_id', $value->id)
                                        ->where('year', $year)
                                        ->value('dayoff'); // วันหยุดประจำปี

                                    if ($late > 3) {
                                        // ถ้าหยุดมากกว่า 3 วัน
                                        $lateBalance = $late % 3; // สายคงเหลือ
                                        $absenceTotal = $absence + ($late - $lateBalance) / 3; // วันหยุดรวมทั้งหมด
                                        $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
                                    } elseif ($late == 3) {
                                        // ถ้าสาย 3 วัน
                                        $lateBalance = $late % 3; // สายคงเหลือ
                                        $absenceTotal = $absence + ($late - $lateBalance) / 3; // วันหยุดรวมทั้งหมด
                                        $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
                                    } else {
                                        // หยุดน้อยกว่า 3 วัน
                                        $lateBalance = $late; // สาย
                                        $absenceTotal = $absence; // หยุด
                                        $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
                                    }

                                    $salary = DB::table('salarys')
                                        ->where('employee_id', $value->id)
                                        ->where('year', $year)
                                        ->value('salary');

                                    if ($absenceBalance >= 0) {
                                        $bonus = $salary;
                                    } else {
                                        $bonus = 0;
                                    }

                                    // ผลการประเมินรายปี
                                    $rate = DB::table('employee_rates')
                                        ->where('employee_id', $value->id)
                                        ->selectRaw('*, sum(rate) as total')
                                        ->groupBy(DB::raw('YEAR(created_at)'))
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $employee + 1 }}</td>
                                        <td>{{ $value->name }} {{ $value->surname }}</td>
                                        <td>{{ $value->nickname }}</td>
                                        <td>{{ $position }}</td>
                                        <td>{{ $value->startdate }}</td>
                                        @php
                                            $salary = DB::table('salarys')
                                                ->where('employee_id', $value->id)
                                                ->orderBy('id', 'desc')
                                                ->first();
                                            $dayoff = DB::table('dayoffs')
                                                ->where('employee_id', $value->id)
                                                ->orderBy('id', 'desc')
                                                ->first();
                                        @endphp
                                        @if (Auth::guard('admin')->user()->role == 'ผู้ดูแล')
                                            <td>
                                                @if ($salary != null)
                                                    {{ number_format((float) $salary->salary) }} บาท
                                                @else
                                                    <a
                                                        href="{{ url('/admin/salary-by-branch') }}/{{ $value->branch_id }}">กรอกเงินเดือน</a>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @if ($dayoff != null)
                                                {{ $dayoff->dayoff }} วัน/ปี
                                            @else
                                                <a
                                                    href="{{ url('/admin/dayoff-by-branch') }}/{{ $value->branch_id }}">กรอกวันหยุดประจำปี</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bonus != 0)
                                                {{ $absenceBalance }} วัน/ปี
                                            @else
                                                หยุดเกิน : {{ abs($absenceBalance) }} วัน
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            @if ($rate != null)
                                                @php
                                                    $average = ($rate->total * 100) / 1200;
                                                    $average = round($average, 0);
                                                @endphp
                                                {{ $average }} %
                                            @else
                                                0%
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/edit-data-employee') }}/{{ $value->branch_id }}/{{ $value->id }}"><i
                                                            class="bx bx-edit-alt me-1"></i> แก้ไขข้อมูล</a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/information-employee') }}/{{ $value->branch_id }}/{{ $value->id }}"><i
                                                            class="bx bx-folder-open"></i> ข้อมูลเพิ่มเติม</a>
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
