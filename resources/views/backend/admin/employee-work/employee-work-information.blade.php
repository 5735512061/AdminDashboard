@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <center>
                        @php
                            $position = DB::table('positions')->where('id',$staff->position_id)->value('position');
                            $branch = DB::table('branch_groups')->where('id',$staff->branch_id)->value('branch');
                        @endphp
                        <h4 class="mt-5">{{$staff->name}} {{$staff->surname}} ( {{$staff->nickname}} ) ตำแหน่งงาน : {{$position}}</h4>
                        <p>{{$branch}}</p>
                        @php
                            $dayoff = DB::table('dayoffs')->where('employee_id',$staff->id)->orderBy('id','desc')->first();
                        @endphp

                        @if($dayoff != NULL)
                            <div>
                                <i class="ni education_hat mr-2"></i>วันหยุดที่ได้รับ : {{$dayoff->dayoff}} วัน/ปี
                            </div>

                            @if($bonus != 0)
                            <h4>
                                <i class="ni education_hat mr-2"></i>วันหยุดคงเหลือ : {{$absenceBalance}} วัน/ปี
                            </h4>
                            @else 
                                <h4 style="color:red;"><i class="ni education_hat mr-2"></i>ใช้วันหยุดเกิน : {{abs($absenceBalance)}} วัน</h3>
                            @endif
                            <p style="color:red;">ขาดงาน {{$absence}} วัน สาย {{$late}} วัน <br>สรุป : ขาดงาน {{$absenceTotal}} วัน สาย {{$lateBalance}} วัน</p>
                        @else 
                            <a href="{{url('/staff/staff-dayoff')}}">กรอกวันหยุดประจำปี</a><br>
                        @endif
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
        <div class="col-md-12">
            @php
                $salary = DB::table('salarys')->where('employee_id',$staff->id)->orderBy('id','desc')->first();
            @endphp
            @php
                $sum_fund = 0;  
                $fund = 0;
                foreach($funds as $fund => $value) {
                    $fund = str_replace(',','',$value->fund);
                    $sum_fund += floatval($fund);
                    $fund = number_format($sum_fund);
                }

                if($year_work <= 0) {
                    $fundStr = str_replace(',','',$fund);
                    $percent = intval(intval($fundStr) * ($year_work/100));
                    $fundStr += 0;
                    $fundStr = number_format($fundStr);
                }
                elseif($year_work >= 1 && $year_work <= 9) {
                    $fundStr = str_replace(',','',$fund);
                    $percent = intval(intval($fundStr) * ($year_work/100));
                    $fundStr += $percent;
                    $fundStr = number_format($fundStr);
                }
                elseif($year_work >= 10 && $year_work <= 14) {
                    $fundStr = str_replace(',','',$fund);
                    $percent = intval(intval($fundStr) * (20/100));
                    $fundStr += $percent;
                    $fundStr = number_format($fundStr);
                }
                elseif($year_work >= 15 && $year_work <= 19) {
                    $fundStr = str_replace(',','',$fund);
                    $percent = intval(intval($fundStr) * (30/100));
                    $fundStr += $percent;
                    $fundStr = number_format($fundStr);
                }
                else {
                    $fundStr = str_replace(',','',$fund);
                    $percent = intval(intval($fundStr) * (40/100));
                    $fundStr += $percent;
                    $fundStr = number_format($fundStr);
                } 
            @endphp
            <div class="card">
                <h5 class="card-header">ข้อมูลการทำงานแต่ละเดือน</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>เงินเดือน</th>
                            <th>ปี</th>
                            <th>เดือน</th>
                            <th>บวกอื่นๆ</th>
                            <th>ขาด (วัน)</th>
                            <th>สาย (วัน)</th>
                            <th>เบี้ยขยัน</th>
                            <th>ค่าประกันสังคม</th>
                            <th>หักอื่นๆ</th>
                            <th>หมายเหตุ</th>
                            <th>ยอดคงเหลือ</th>
                        </tr>
                    </thead>
                    @foreach ($works as $work => $value)
                    <tbody class="table-border-bottom-0">
                        @php
                            $month_equal = DB::table('salarys')->where('employee_id',$staff->id)->where('year',$value->year)->where('month_',$value->month_)->orderBy('id','desc')->value('month_');
                            // มีค่าเงินเดือน
                            $salary_equal = DB::table('salarys')->where('employee_id',$staff->id)->where('year',$value->year)->where('month_',$value->month_)->orderBy('id','desc')->value('salary');
                            
                            // ไม่มีค่าเงินเดือน
                            $salary = DB::table('salarys')->where('employee_id',$staff->id)->where('year',$value->year)->where('month_','<',$value->month_)->orderBy('id','desc')->value('salary');
                        @endphp
                        <tr>
                            <td>{{$NUM_PAGE*($page-1) + $work+1}}</td>
                            <td>
                                @if($value->month_ == $month_equal)    
                                  {{number_format((float)$salary_equal)}} บาท
                                @elseif($value->month_ != $month_equal)  
                                  {{number_format((float)$salary)}} บาท
                                @else 
                                @endif
                            </td>

                            <td>{{$value->year}}</td>
                            <td>{{$value->month}}</td>

                            @if($value->charge == 0)
                                <td>0</td>
                            @else
                                <td>+ {{$value->charge}}</td>
                            @endif
                            <td>{{$value->absence}}</td>
                            <td>{{$value->late}}</td>

                            @if($value->late == 0 && $value->absence == 0)
                                <td>+ 1,000</td>
                            @else
                                <td>0</td>
                            @endif
                            <td>- {{$value->insurance}}</td>
                            <td>- {{$value->deduct}}</td>


                            {{-- มีค่าเงินเดือน --}}
                            @php 
                                $salary_equal = DB::table('salarys')->where('employee_id',$staff->id)->where('year',$value->year)->where('month_',$value->month_)->orderBy('id','desc')->value('salary');
                                $salary_equal = str_replace(',','',$salary_equal);
                                $salary_equal = (int)$salary_equal;
                                $charge = str_replace(',','',$value->charge);
                                $charge = (int)$charge;
                                $insurance = str_replace(',','',$value->insurance);
                                $insurance = (int)$insurance;
                                $deduct = str_replace(',','',$value->deduct);
                                $deduct = (int)$deduct;
                                if($value->late == 0 && $value->absence == 0)
                                $salary_equal = (($salary_equal+1000)+($charge))-$insurance-$deduct;
                                elseif($value->late != 0 || $value->absence != 0)
                                $salary_equal = ($salary_equal+$charge)-$insurance-$deduct;
                                $salary_equal = number_format($salary_equal);
                            @endphp

                            {{-- ไม่มีค่าเงินเดือน --}}
                            @php 
                                    $salary = DB::table('salarys')->where('employee_id',$staff->id)->where('year',$value->year)->where('month_','<',$value->month_)->orderBy('id','desc')->value('salary');
                                    $salary = str_replace(',','',$salary);
                                    $salary = (int)$salary;
                                    $charge = str_replace(',','',$value->charge);
                                    $charge = (int)$charge;
                                    $insurance = str_replace(',','',$value->insurance);
                                    $insurance = (int)$insurance;
                                    $deduct = str_replace(',','',$value->deduct);
                                    $deduct = (int)$deduct;
                                    if($value->late == 0 && $value->absence == 0)
                                    $salary = (($salary+1000)+($charge))-$insurance-$deduct;
                                    elseif($value->late != 0 || $value->absence != 0)
                                    $salary = ($salary+$charge)-$insurance-$deduct;
                                    $salary = number_format($salary);
                            @endphp

                            @if($value->month_ == $month_equal)
                                <td>{{$value->comment}}</td>
                                <td>{{$salary_equal}}</td>  
                            @elseif($value->month_ != $month_equal)
                                <td>{{$value->comment}}</td>
                                <td>{{$salary}}</td>  
                            @else
                                <td>{{$value->comment}}</td>
                                <td></td>
                            @endif
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