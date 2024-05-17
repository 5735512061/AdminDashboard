@extends('backend/layouts/admin/template')

@section('content')
    @php
        $titles = DB::table('title_sops')->where('status', 'เปิด')->get();
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">CHECKLIST SOP /</span> หัวข้อ SOP</h4>
        <div class="row">
            <form action="{{ url('admin/create-form-checklist-sop') }}" method="POST">@csrf
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                    @endif
                @endforeach
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">หัวข้อ SOP</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">ชุดที่</label>
                                    <input class="idcard form-control" type="text" name="set" autofocus />
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">ช่วงเวลา</label>
                                    <select class="select2 form-select" name="period">
                                        <option value="ช่วงเช้า 10.00-12.00">ช่วงเช้า 10.00-12.00</option>
                                        <option value="ช่วงค่ำ 21.00-23.00">ช่วงค่ำ 21.00-23.00</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">หัวข้อหลัก</label>
                                    <select class="select2 form-select" name="title_id">
                                        @foreach ($titles as $title => $value)
                                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">ข้อที่</label>
                                    <input class="form-control" type="text" name="number" autofocus />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">รายละเอียด</label>
                                    <input class="form-control" type="text" name="list" autofocus />
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">ผู้ประเมิน</label>
                                    <select class="select2 form-select" name="position">
                                        <option value="ผู้จัดการ รองผู้จัดการ">ผู้จัดการ รองผู้จัดการ</option>
                                        <option value="หัวหน้าเชฟ รองหัวหน้าเชฟ">หัวหน้าเชฟ รองหัวหน้าเชฟ</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">สถานะ</label>
                                    <select class="select2 form-select" name="status">
                                        <option value="เปิด">เปิด</option>
                                        <option value="ปิด">ปิด</option>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <input type="hidden" name="branch_id" value="{{ $branch_id }}">
                                    <button type="submit" class="btn btn-primary me-2"
                                        style="font-family: 'Sarabun';">บันทึกข้อมูล</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        style="font-family: 'Sarabun';">ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Hoverable Table rows -->
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชุดที่</th>
                                    <th>ช่วงเวลา</th>
                                    <th>หัวข้อหลัก</th>
                                    <th>ข้อที่</th>
                                    <th>รายละเอียด</th>
                                    <th>ผู้ประเมิน</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach ($checklists as $checklist => $value)
                                @php
                                    $title = DB::table('title_sops')
                                        ->where('id', $value->title_id)
                                        ->value('title');
                                    $position = $value->position;
                                    $status = $value->status;
                                    $number = $value->number;
                                    $list = $value->list;
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $checklist + 1 }}</td>
                                        <td>{{ $value->set }}</td>
                                        <td>{{ $value->period }}</td>
                                        <td>{{ $title }}</td>
                                        <td>{{ $value->number }}</td>
                                        <td>{{ $value->list }}</td>
                                        <td>{{ $value->position }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#backDropModal{{ $value->id }}"
                                                        class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#backDropModal">
                                                        <i class="bx bx-edit-alt me-1"></i>แก้ไขข้อมูล
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="backDropModal{{ $value->id }}"
                                                data-bs-backdrop="static" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form action="{{ url('admin/edit-form-checklist-sop') }}"
                                                        method="POST" enctype="multipart/form-data" class="modal-content">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $value->id }}">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="backDropModalTitle">แก้ไขหัวข้อ SOP
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">ชุดที่</label>
                                                                    <input class="idcard form-control" type="text"
                                                                        name="set" value="{{ $value->set }}"
                                                                        autofocus />
                                                                </div>
                                                                <div class="mb-3 col-md-9">
                                                                    <label class="form-label">ช่วงเวลา</label>
                                                                    <select class="select2 form-select" name="period">
                                                                        <option value="{{ $value->period }}">
                                                                            {{ $value->period }}</option>
                                                                        <option value="ช่วงเช้า 10.00-12.00">ช่วงเช้า
                                                                            10.00-12.00</option>
                                                                        <option value="ช่วงค่ำ 21.00-23.00">ช่วงค่ำ
                                                                            21.00-23.00</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-8">
                                                                    <label class="form-label">หัวข้อหลัก</label>
                                                                    <select class="select2 form-select" name="title_id">
                                                                        @php
                                                                            $title = DB::table('title_sops')
                                                                                ->where('id', $value->title_id)
                                                                                ->value('title');
                                                                        @endphp
                                                                        <option value="{{ $value->title_id }}">
                                                                            {{ $title }}</option>
                                                                        @foreach ($titles as $title => $value)
                                                                            <option value="{{ $value->id }}">
                                                                                {{ $value->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">ข้อที่</label>
                                                                    <input class="form-control" type="text"
                                                                        name="number" value="{{ $number }}"
                                                                        autofocus />
                                                                </div>

                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">รายละเอียด</label>
                                                                    <input class="form-control" type="text"
                                                                        name="list" value="{{ $list }}"
                                                                        autofocus />
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">ผู้ประเมิน</label>
                                                                    <select class="select2 form-select" name="position">
                                                                        <option value="{{ $position }}">
                                                                            {{ $position }}</option>
                                                                        <option value="ผู้จัดการ รองผู้จัดการ">ผู้จัดการ
                                                                            รองผู้จัดการ</option>
                                                                        <option value="หัวหน้าเชฟ รองหัวหน้าเชฟ">หัวหน้าเชฟ
                                                                            รองหัวหน้าเชฟ</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">สถานะ</label>
                                                                    <select class="select2 form-select" name="status">
                                                                        <option value="{{ $status }}">
                                                                            {{ $status }}</option>
                                                                        <option value="เปิด">เปิด</option>
                                                                        <option value="ปิด">ปิด</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <input type="hidden" name="branch_id"
                                                                        value="{{ $branch_id }}">
                                                                    <button type="submit" class="btn btn-primary me-2"
                                                                        style="font-family: 'Sarabun';">บันทึกข้อมูล</button>
                                                                    <button type="reset"
                                                                        class="btn btn-outline-secondary"
                                                                        style="font-family: 'Sarabun';">ยกเลิก</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal"
                                                                style="font-family:'Sarabun';">ปิด</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                style="font-family:'Sarabun';">แก้ไขหัวข้อ SOP</button>
                                                        </div>
                                                    </form>
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
