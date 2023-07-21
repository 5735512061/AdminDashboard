@extends("backend/layouts/admin/template") 
<style>
    /* The container */
    .containerRadio {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 22px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      font-size: 16px;
    }
    
    /* Hide the browser's default radio button */
    .containerRadio input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }
    
    /* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 20px;
      width: 20px;
      background-color: #bec7d0;
      border-radius: 50%;
    }
    
    /* On mouse-over, add a grey background color */
    .containerRadio:hover input ~ .checkmark {
      background-color: #ccc;
    }
    
    /* When the radio button is checked, add a blue background */
    .containerRadio input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    
    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    
    /* Show the indicator (dot/circle) when checked */
    .containerRadio input:checked ~ .checkmark:after {
      display: block;
    }
    
    /* Style the indicator (dot/circle) */
    .checkmark:after {
      top: 6px;
      left: 6px;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: white;
    }
</style>
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-body" style="text-align: center;">
            <h1 class="h1Font">สรุปผลการประเมิน</h1>
                <?php 
                    if($sum >= 70 && $sum <= 100) $standard = "ดีมาก";
                    if($sum > 100 ) $standard = "ดีมาก";
                    if($sum >= 40 && $sum <= 69) $standard = "ดี";
                    if($sum >= 0 && $sum <= 39) $standard = "แย่";
                ?>
            <h2 class="h2Font">(คะแนนรวม {{$sum}}/100 คะแนน)</h2>
            <h2 class="h2Font" style="color:red;">อยู่ในเกณฑ์ {{$standard}}</h2>
            <hr class="my-0" />
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body table-responsive text-nowrap">
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr style="text-align:center;">
                                    <th>รายการประเมิน</th>
                                    <th>ดีมาก</th>
                                    <th>ดี</th>
                                    <th>ปานกลาง</th>
                                    <th>น้อย</th>
                                    <th>ปรับปรุง</th>
                                </tr>
                            </thead>
                            @foreach($rates as $rate => $value)
                                <tbody>
                                    <tr>
                                        @php
                                            $scoreValue = DB::table('evaluations')->where('id',$value->evaluation_id)->value('score');
                                            $score = ($scoreValue)/5;
                                            $score1 = ($scoreValue) - 0;
                                            $score2 = $score1 - $score;
                                            $score3 = $score2 - $score;
                                            $score4 = $score3 - $score;
                                            $score5 = $score4 - $score;
                                        @endphp
                                        <td>
                                            <?php 
                                                $number = DB::table('evaluations')->where('id',$value->evaluation_id)->value('number');
                                                $list = DB::table('evaluations')->where('id',$value->evaluation_id)->value('list');
                                            ?>
                                            {{$number}} {{$list}}
                                        </td>
                                        <td>
                                            <label class="containerRadio" >
                                                <input type="radio" {{ ($value->rate==$score1)? "checked" : "" }}>
                                                <span style="margin-left:10px;" class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" {{ ($value->rate==$score2)? "checked" : "" }}>
                                                <span style="margin-left:8px;" class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" {{ ($value->rate==$score3)? "checked" : "" }}> 
                                                <span style="margin-left:20px;" class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" {{ ($value->rate==$score4)? "checked" : "" }}>
                                                <span style="margin-left:8px;" class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" {{ ($value->rate==$score5)? "checked" : "" }}>
                                                <span style="margin-left:15px;" class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                            </tbody>
                            @endforeach 
                        </table><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection