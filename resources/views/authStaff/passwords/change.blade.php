@extends("frontend/layouts/employee/template") 

@section("content")
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y" style="min-height: 70vh;">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-5" style="text-align:center;">เปลี่ยนรหัสผ่าน</h3>
                    <form class="mb-3" action="{{ route('update.password') }}" method="POST" enctype="multipart/form-data">@csrf
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">รหัสผ่านเก่า</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="oldpassword"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">รหัสผ่านใหม่</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">ยืนยันรหัสผ่าน</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" style="font-family: 'Sarabun';">เปลี่ยนรหัสผ่าน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection