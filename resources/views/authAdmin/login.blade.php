@extends("backend/layouts/admin/template-login") 

@section("content")
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2" style="text-align:center;">เข้าสู่ระบบหลังบ้าน EDO GROUP</h4>
                    <p class="mb-4" style="text-align:center;">กรุณากรอกชื่อผู้ใช้งาน และรหัสผ่าน</p>
                    <form id="formAuthentication" class="mb-3" action="{{url('admin/login')}}" method="POST" enctype="multipart/form-data">@csrf
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                            @endif
                        @endforeach
                        <div class="mb-3">
                            <label for="email" class="form-label">ชื่อผู้ใช้งาน</label>
                            <input type="text" class="form-control" name="username" placeholder="กรอกชื่อผู้ใช้งาน" style="font-family: 'Sarabun';" autofocus/>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">รหัสผ่าน</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" style="font-family: 'Sarabun';">เข้าสู่ระบบ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection