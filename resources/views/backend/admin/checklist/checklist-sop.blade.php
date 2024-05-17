@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">SOP /</span> ผลการตรวจเช็ค SOP</h4>
        {{ $checklists->links() }}
        <div class="row">
            @php
                $branch = DB::table('branch_groups')->where('id', $branch_id)->value('branch');
            @endphp
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ผู้ทำ Checklist</th>
                                    <th>ตำแหน่ง</th>
                                    <th>สาขา</th>
                                    <th>วันที่ทำ checklist</th>
                                    <th>หัวข้อ</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            @foreach ($checklists as $checklist => $value)
                                @php
                                    $name = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('name');
                                    $surname = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('surname');
                                    $nickname = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('nickname');
                                    $position_id = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('position_id');
                                    $position = DB::table('positions')->where('id', $position_id)->value('position');
                                    $branch_id = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('branch_id');
                                    $branch = DB::table('branch_groups')->where('id', $position_id)->value('branch');
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $checklist + 1 }}</td>
                                        <td>{{ $name }} {{ $surname }} ({{ $nickname }})</td>
                                        <td>{{ $position }}</td>
                                        <td>{{ $branch }}</td>
                                        <td>{{ $value->date }}</td>
                                        <td>{{ $value->set }} {{ $value->period }}</td>
                                        <td>{{ $value->status }}</td>
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
