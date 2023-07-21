@extends("backend/layouts/admin/template-login") 

@section("content")
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2" style="text-align:center;">ลงทะเบียนผู้ดูแลระบบ EDO GROUP</h4>
                    <p class="mb-4" style="text-align:center;">กรุณากรอกข้อมูลให้ถูกต้องครบถ้วน</p>
                    <form id="formAuthentication" class="mb-3" action="{{url('admin/register')}}" method="POST" enctype="multipart/form-data">@csrf
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                            @endif
                        @endforeach
                        <div class="mb-3">
                            <label  class="form-label">ชื่อผู้ใช้งาน</label>
                            @if ($errors->has('name'))
                                <strong style="color: red;">( {{ $errors->first('name') }} )</strong>
                            @endif
                            <input type="text" class="form-control" name="name" placeholder="กรอกชื่อผู้ใช้งาน" style="font-family: 'Sarabun';" autofocus/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">สิทธิ์การเข้าใช้งาน</label>
                            <select class="form-select">
                                <option value="ผู้ดูแล" selected>ผู้ดูแล</option>
                                <option value="ผู้แก้ไข">ผู้แก้ไข</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label  class="form-label">ชื่อเข้าใช้งานระบบ</label>
                            @if ($errors->has('username'))
                                <strong style="color: red;">( {{ $errors->first('username') }} )</strong>
                            @endif
                            <input type="text" class="form-control" name="username" placeholder="กรอกชื่อเข้าใช้งานระบบ" style="font-family: 'Sarabun';" autofocus/>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password_name">รหัสผ่าน</label>
                            @if ($errors->has('password_name'))
                                <strong style="color: red;">( {{ $errors->first('password_name') }} )</strong>
                            @endif
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_name"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password_name"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle"> 
                            <label class="form-label">ยืนยันรหัสผ่าน</label>
                            @if ($errors->has('password_confirmation'))
                                <strong style="color: red;">( {{ $errors->first('password_confirmation') }} )</strong>
                            @endif
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password_confirmation"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">สถานะ</label>
                            <select class="form-select">
                                <option value="เปิด" selected>เปิด</option>
                                <option value="ปิด">ปิด</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" style="font-family: 'Sarabun';">ลงทะเบียนผู้ดูแลระบบ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection