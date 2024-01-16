@extends('frontend/layouts/employee/template')
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
    .containerRadio:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .containerRadio input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .containerRadio input:checked~.checkmark:after {
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
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            @php
                if ($date == '01') {
                    $month = 'มกราคม';
                }
                if ($date == '07') {
                    $month = 'กรกฎาคม';
                }
                if ($date == '02') {
                    $month = 'กุมภาพันธ์';
                }
                if ($date == '08') {
                    $month = 'สิงหาคม';
                }
                if ($date == '03') {
                    $month = 'มีนาคม';
                }
                if ($date == '09') {
                    $month = 'กันยายน';
                }
                if ($date == '04') {
                    $month = 'เมษายน';
                }
                if ($date == '10') {
                    $month = 'ตุลาคม';
                }
                if ($date == '05') {
                    $month = 'พฤษภาคม';
                }
                if ($date == '11') {
                    $month = 'พฤศจิกายน';
                }
                if ($date == '06') {
                    $month = 'มิถุนายน';
                }
                if ($date == '12') {
                    $month = 'ธันวาคม';
                }
            @endphp
            <div class="card-body" style="text-align: center;">
                <h3>แบบประเมินพนักงาน</h3>
                <h4>เพื่อปรับปรุงคุณภาพการทำงานของพนักงานในร้านประจำเดือน {{ $month }}</h4>
                <h4>(คะแนนเต็ม 100 คะแนน)</h4>
                <h4>{{ $employee->name }} {{ $employee->surname }} ({{ $employee->nickname }}) ตำแหน่ง
                    {{ $employee->position }}</h4>
                <hr class="my-0" />
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('/staff/from-employee-evaluate') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="card-body table-responsive text-nowrap">
                                <table class="table table-responsive table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>รายการประเมิน</th>
                                            <th>ดีมาก</th>
                                            <th>ดี</th>
                                            <th>ปานกลาง</th>
                                            <th>น้อย</th>
                                            <th>ปรับปรุง</th>
                                        </tr>
                                    </thead>
                                    @foreach ($evaluations as $evaluation => $value)
                                        <tbody>
                                            <tr>
                                                @php
                                                    $score = $value->score / 5;
                                                    $score1 = $value->score - 0;
                                                    $score2 = $score1 - $score;
                                                    $score3 = $score2 - $score;
                                                    $score4 = $score3 - $score;
                                                    $score5 = $score4 - $score;
                                                @endphp
                                                <td>{{ $value->number }}) {{ $value->list }}</td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score1 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score2 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score3 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score4 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score5 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                                <br>
                                <textarea name="comment" cols="10" rows="5" class="form-control" placeholder="ความคิดเห็นเพิ่มเติม"></textarea><br><br>
                                <button class="btn btn-info"
                                    style="font-family:Sarabun; padding-right:10px; padding-left:10px;">ส่งแบบประเมิน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
