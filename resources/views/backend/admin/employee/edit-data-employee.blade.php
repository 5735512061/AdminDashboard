@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> แก้ไขข้อมูลพนักงาน</h4>
    <div class="row">
      <form action="{{url('admin/edit-data-employee')}}" method="POST" enctype="multipart/form-data">@csrf
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))
              <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
          @endif
        @endforeach
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">ข้อมูลพนักงาน</h5>
            <div class="card-body">
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                <div class="button-wrapper">
                  <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">แก้ไขรูปภาพ</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input name="image" type="file" class="account-file-input" accept="image/png, image/jpeg"/>
                  </label>
                </div>
              </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label class="form-label">หมายเลขบัตรประชาชน</label>
                    @if ($errors->has('idcard'))
                      <strong style="color: red;">( {{ $errors->first('idcard') }} )</strong>
                    @endif
                    <input class="idcard form-control" type="text" name="idcard" value="{{$employee->idcard}}" autofocus/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">ชื่อพนักงาน</label>
                    @if ($errors->has('name'))
                      <strong style="color: red;">( {{ $errors->first('name') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="name" value="{{$employee->name}}" autofocus/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">นามสกุล</label>
                    @if ($errors->has('surname'))
                      <strong style="color: red;">( {{ $errors->first('surname') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="surname" value="{{$employee->surname}}" autofocus/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">ชื่อเล่น</label>
                    @if ($errors->has('nickname'))
                      <strong style="color: red;">( {{ $errors->first('nickname') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="nickname" value="{{$employee->nickname}}" autofocus/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">วัน/เดือน/ปีเกิด</label>
                    @if ($errors->has('bday'))
                      <strong style="color: red;">( {{ $errors->first('bday') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="bday" placeholder="กรุณากรอก วัน/เดือน/ปีเกิด เช่น 01/01/1995" value="{{$employee->bday}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    @if ($errors->has('tel'))
                      <strong style="color: red;">( {{ $errors->first('tel') }} )</strong>
                    @endif
                    <input class="phone_format form-control" type="text" name="tel" value="{{$employee->tel}}" autofocus/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">สาขาในเครือ</label>
                    @php
                        $branch = DB::table('branch_groups')->where('id',$employee->branch_id)->value('branch');
                        $branchs = DB::table('branch_groups')->get();
                    @endphp
                    <select name="branch_id" class="select2 form-select">
                        <option value="{{$employee->branch_id}}">{{$branch}}</option>          
                      @foreach ($branchs as $branch => $value)
                        <option value="{{$value->id}}">{{$value->branch}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label" for="country">ตำแหน่งงาน</label>
                    @php
                        $position = DB::table('positions')->where('id',$employee->position_id)->value('position');
                        $positions = DB::table('positions')->where('branch_group_id',$branch_id)->get();
                    @endphp
                    <select name="position_id" class="select2 form-select">
                        <option value="{{$employee->position_id}}">{{$position}}</option>          
                      @foreach ($positions as $position => $value)
                        <option value="{{$value->id}}">{{$value->position}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">วัน/เดือน/ปี ที่เริ่มงาน</label>
                    @if ($errors->has('startdate'))
                      <strong style="color: red;">( {{ $errors->first('startdate') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="startdate" placeholder="กรุณากรอก วัน/เดือน/ปี ที่เริ่มงาน เช่น 01/01/2022" value="{{$employee->startdate}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">ที่อยู่</label>
                    @if ($errors->has('address'))
                      <strong style="color: red;">( {{ $errors->first('address') }} )</strong>
                    @endif
                    <input type="text" class="form-control" name="address" value="{{$employee->address}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">ตำบล</label>
                    @if ($errors->has('district'))
                      <strong style="color: red;">( {{ $errors->first('district') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="district" value="{{$employee->district}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">อำเภอ</label>
                    @if ($errors->has('amphoe'))
                      <strong style="color: red;">( {{ $errors->first('amphoe') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="amphoe" value="{{$employee->amphoe}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">จังหวัด</label>
                    @if ($errors->has('province'))
                      <strong style="color: red;">( {{ $errors->first('province') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="province" value="{{$employee->province}}"/>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="form-label">รหัสไปรษณีย์</label>
                    @if ($errors->has('zipcode'))
                      <strong style="color: red;">( {{ $errors->first('zipcode') }} )</strong>
                    @endif
                    <input class="form-control" type="text" name="zipcode" value="{{$employee->zipcode}}"/>
                  </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">ชื่อเข้าใช้งาน</label>
                  @if ($errors->has('employee_name'))
                    <strong style="color: red;">( {{ $errors->first('employee_name') }} )</strong>
                  @endif
                  <input class="form-control" type="text" name="employee_name" value="{{$employee->employee_name}}"/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">รหัสผ่าน</label>
                  @if ($errors->has('password_name'))
                    <strong style="color: red;">( {{ $errors->first('password_name') }} )</strong>
                  @endif
                  <input class="form-control" type="password" name="password_name"/>
                </div>
              </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="country">สิทธิ์การเข้าใช้งาน</label>
                  <select name="status" class="select2 form-select">      
                    <option value="{{$employee->status}}">{{$employee->status}}</option>
                    <option value="เปิด">เปิด</option>
                    <option value="ปิด">ปิด</option>
                    <option value="พ้นสภาพพนักงาน">พ้นสภาพพนักงาน</option>
                  </select>
                </div>
                <div class="mt-2">
                  <input type="hidden" name="id" value="{{$employee->id}}">
                  <button type="submit" class="btn btn-primary me-2" style="font-family: 'Sarabun';">บันทึกข้อมูล</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
</div>
<script type="text/javascript" src="{{asset('https://code.jquery.com/jquery-3.2.1.min.js')}}"></script>
<script>
  // phone
	function phoneFormatter() {
    $('input.phone_format').on('input', function() {
        var number = $(this).val().replace(/[^\d]/g, '')
            if (number.length >= 5 && number.length < 10) { number = number.replace(/(\d{3})(\d{2})/, "$1-$2"); } else if (number.length >= 10) {
                number = number.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3"); 
            }
        $(this).val(number)
        $('input.phone_format').attr({ maxLength : 12 });    
    });
  };
  $(phoneFormatter);

  // idcard
	function idFormatter() {
    $('input.idcard').on('input', function() {
        var number = $(this).val().replace(/[^\d]/g, '')
            if (number.length >= 10) {
                number = number.replace(/(\d{1})(\d{4})(\d{5})(\d{2})(\d{1})/, "$1-$2-$3-$4-$5"); 
            }
        $(this).val(number)
        $('input.idcard').attr({ maxLength : 17 });    
    });
  };
  $(idFormatter);
</script>
@endsection