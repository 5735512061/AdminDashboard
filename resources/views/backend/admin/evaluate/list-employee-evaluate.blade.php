@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">การประเมินผล /</span> ผลการประเมินพนักงาน</h4>
        <div class="row">
            @php
                $branch = DB::table('branch_groups')
                    ->where('id', $branch_id)
                    ->value('branch');
            @endphp
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">ผลการประเมินพนักงาน {{ $branch }}</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อเล่น</th>
                                    <th>ตำแหน่ง</th>
                                    <th>ผลการประเมิน</th>
                                    <th></th>
                                    <th>คะแนนการประเมินล่าสุด</th>
                                </tr>
                            </thead>
                            @foreach ($employees as $employee => $value)
                                @php
                                    $position = DB::table('positions')
                                        ->where('id', $value->position_id)
                                        ->value('position');

                                    $yearNow = Carbon\Carbon::now()->format('Y'); //เพิ่มเปรียบเทียบปีปัจจุบัน

                                    $employee_rates = DB::table('employee_rates')
                                        ->where('employee_id', $value->id)
                                        // ->where('date', 'like', '%' . $yearNow) //เพิ่มเปรียบเทียบปีปัจจุบัน
                                        ->groupBy('created_at')
                                        ->selectRaw('*, sum(rate) as sum')
                                        ->orderBy('created_at', 'desc')
                                        ->first();
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $employee + 1 }}</td>
                                        <td>{{ $value->name }} {{ $value->surname }}</td>
                                        <td>{{ $value->nickname }}</td>
                                        <td>{{ $position }}</td>
                                        <td>
                                            <a href="{{ url('/admin/evaluate-for-month') }}/{{ $value->id }}"><i
                                                    class='bx bxs-bar-chart-alt-2'></i> ตรวจสอบผลการประเมิน</a>
                                        </td>

                                        @php
                                            $date = DB::table('employee_rates')
                                                ->where('employee_id', $value->id)
                                                ->orderBy('created_at', 'desc')
                                                ->first();

                                            if ($date == null) {
                                                $date_mY = null;

                                                $rate = DB::table('employee_rates')
                                                    ->where('employee_id', $value->id)
                                                    ->where('date', 'like', '%' . $date_mY)
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();

                                                $dateNow = strtr($dateNow, '/', '-');
                                                $date_dN = date('d', strtotime($dateNow));
                                                $date_mN = date('m', strtotime($dateNow));
                                                $date_yN = date('Y', strtotime($dateNow));
                                                $date_mYN = $date_mN . '/' . $date_yN;

                                                $rateNow = DB::table('employee_rates')
                                                    ->where('employee_id', $value->id)
                                                    ->where('date', 'like', '%' . $date_mYN)
                                                    ->count();
                                            } else {
                                                $date = strtr($date->date, '/', '-');
                                                $date_d = date('d', strtotime($date));
                                                $date_m = date('m', strtotime($date));
                                                $date_y = date('Y', strtotime($date));
                                                $date_mY = $date_m . '/' . $date_y;

                                                $rate = DB::table('employee_rates')
                                                    ->where('employee_id', $value->id)
                                                    ->where('date', 'like', '%' . $date_mY)
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();

                                                $dateNow = strtr($dateNow, '/', '-');
                                                $date_dN = date('d', strtotime($dateNow));
                                                $date_mN = date('m', strtotime($dateNow));
                                                $date_yN = date('Y', strtotime($dateNow));
                                                $date_mYN = $date_mN . '/' . $date_yN;

                                                $rateNow = DB::table('employee_rates')
                                                    ->where('employee_id', $value->id)
                                                    ->where('date', 'like', '%' . $date_mYN)
                                                    ->count();
                                            }
                                        @endphp

                                        @if ($date_mY === $date_mYN)
                                            <td style="color:green">ประเมินเรียบร้อย</td>
                                        @elseif($date_mY !== $date_mYN)
                                            <td style="color:red">ยังไม่ประเมิน</td>
                                        @elseif($date_mY == null || $date_mYN == null)
                                            <td style="color:red">ยังไม่ประเมิน</td>
                                        @endif

                                        @if ($date_mY !== $date_mYN)
                                            <td></td>
                                        @elseif($date_mY == null || $date_mYN == null)
                                            <td></td>
                                        @else
                                            <td>{{ $employee_rates->sum }} คะแนน</td>
                                        @endif

                                        {{-- <td>
                                    <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    </div>
                                    </div>
                                </td> --}}
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
