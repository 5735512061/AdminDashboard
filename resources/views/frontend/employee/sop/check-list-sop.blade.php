@extends('frontend/layouts/employee/template')
<style>
    .table> :not(caption)>*>* {
        padding: 0.3rem 1.25rem !important;
        font-size: small;
    }
</style>
@section('content')
    @php
        $date = Carbon\Carbon::now()->format('d/m/Y h:i a');
        $time = Carbon\Carbon::now()->format('h:i');
    @endphp
    @if ($time > '10:00' && $time < '12:00')
        <div class="container-xxl flex-grow-1 container-p-y">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
            <div class="card mb-4">
                <form action="{{ url('/staff/from-checklist-sop') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-header text-center">CHECKLIST SOP ช่วงเช้า 10:00 - 12:00 น.</h5>
                        <hr>
                        @foreach ($titles as $title => $value)
                            @php
                                $checklists = DB::table('list_sops')
                                    ->where('title_id', $value->title_id)
                                    ->where('period', 'ช่วงเช้า 10.00-12.00')
                                    ->where('position', 'ผู้จัดการ รองผู้จัดการ')
                                    ->get();
                                $title = DB::table('title_sops')
                                    ->where('id', $value->title_id)
                                    ->value('title');
                            @endphp
                            @if (count($checklists) != 0)
                                <h6><strong>{{ $title }}</strong></h6>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>list</th>
                                                <th>check</th>
                                            </tr>
                                        </thead>
                                        @foreach ($checklists as $checklist => $value)
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>{{ $value->number }}</td>
                                                    <td>{{ $value->list }}</td>
                                                    <td><input name="checklist" type="checkbox" required/></td>
                                                </tr>
                                            </tbody>
                                            @php
                                                $set = $value->set;
                                            @endphp
                                        @endforeach
                                    </table>
                                </div><br>
                            @endif
                        @endforeach
                        <input type="hidden" name="employee_id" value="{{ Auth::guard('staff')->id() }}">
                        <input type="hidden" name="branch_id" value="{{ Auth::guard('staff')->user()->branch_id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="period" value="ช่วงเช้า 10.00-12.00">
                        <input type="hidden" name="position" value="ผู้จัดการ รองผู้จัดการ">
                        <input type="hidden" name="set" value="{{ $set }}">
                        <center><button class="btn btn-info mt-3" style="font-family:Sarabun; ">บันทึกข้อมูล</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    @elseif($time > '21:00' && $time < '23:00')
        <div class="container-xxl flex-grow-1 container-p-y">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
            <div class="card mb-4">
                <form action="{{ url('/staff/from-checklist-sop') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-header text-center">CHECKLIST SOP ช่วงค่ำ 21:00 - 23:00 น.</h5>
                        <hr>
                        @foreach ($titles as $title => $value)
                            @php
                                $checklists = DB::table('list_sops')
                                    ->where('title_id', $value->title_id)
                                    ->where('period', 'ช่วงค่ำ 21.00-23.00')
                                    ->where('position', 'ผู้จัดการ รองผู้จัดการ')
                                    ->get();
                                $title = DB::table('title_sops')
                                    ->where('id', $value->title_id)
                                    ->value('title');
                            @endphp
                            @if (count($checklists) != 0)
                                <h6><strong>{{ $title }}</strong></h6>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>list</th>
                                                <th>check</th>
                                            </tr>
                                        </thead>
                                        @foreach ($checklists as $checklist => $value)
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>{{ $value->number }}</td>
                                                    <td>{{ $value->list }}</td>
                                                    <td><input name="checklist" type="checkbox" required/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            @php
                                                $set = $value->set;
                                            @endphp
                                        @endforeach
                                    </table>
                                </div><br>
                            @endif
                        @endforeach

                        <input type="hidden" name="employee_id" value="{{ Auth::guard('staff')->id() }}">
                        <input type="hidden" name="branch_id" value="{{ Auth::guard('staff')->user()->branch_id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="period" value="ช่วงค่ำ 21.00-23.00">
                        <input type="hidden" name="position" value="ผู้จัดการ รองผู้จัดการ">
                        <input type="hidden" name="set" value="{{ $set }}">
                        <center><button class="btn btn-info mt-3" style="font-family:Sarabun; ">บันทึกข้อมูล</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-header text-center">สามารถเข้าทำ CHECKLIST SOP ได้ในช่วงเช้าเวลา 10:00 - 12:00 น.
                        และช่วงค่ำเวลา 21:00 - 23:00 น.</h5>
                </div>
            </div>
        </div>
    @endif
@endsection
