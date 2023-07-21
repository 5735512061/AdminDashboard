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

                        <div>
                            <i class="ni education_hat mr-2"></i>เงินกองทุนสะสม : {{$fundStr}} บาท
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>เงินต้นสะสม : {{$fund}} เงินสมทบ : {{$percent}} บาท
                        </div>
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
        @php
            $fundTotal = 0;
        @endphp
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-header">เงินกองทุนสะสม</h5><hr class="my-0" />
                    @foreach ($funds as $fund => $value)
                    <div class="row">
                        <div class="mb-2 mt-2 col-md-4">
                            <input class="form-control" type="text" value="{{$value->year}} {{$value->month}}"/>
                        </div>
                        <div class="mb-2 mt-2 col-md-4">
                            <input class="form-control" type="text" value="เงินสะสม : {{number_format((float)$value->fund)}} บาท"/>
                        </div>
                        @php
                            $fundTotal += $value->fund;
                        @endphp
                        <div class="mb-2 mt-2 col-md-4">
                            <input style="color: red;" class="form-control" type="text" value="ยอดรวมสะสม : {{number_format((float)$fundTotal)}} บาท"/>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection