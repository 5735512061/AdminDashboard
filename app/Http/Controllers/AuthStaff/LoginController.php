<?php

namespace App\Http\Controllers\AuthStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Employee;

class LoginController extends Controller
{

    public function __construct(){
        $this->middleware('guest:staff')->except('logout');
    }

    public function showLoginForm(){
        return view('authStaff.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
          'employee_name' => 'required',
          'password' => 'required|min:6'
        ],[
          'employee_name.required' => "กรุณากรอกชื่อผู้ใช้",
          'password.required' => "กรุณากรอกรหัสผ่าน",
          'password.min' => "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัวอักษร",
        ]);


        $credential = [
          'employee_name' => $request->employee_name,
          'password' =>$request->password
        ];

        $employee_name = $request->employee_name;
        $employee_status = Employee::where('employee_name',$employee_name)->value('status');

        if($employee_status == "เปิด") {
          if(Auth::guard('staff')->attempt($credential,$request->employee_name)){
            return redirect()->intended(route('staff.home'));
          }
        } else {
          $request->session()->flash('alert-danger', 'เข้าสู่ระบบไม่สำเร็จ ผู้ใช้ถูกปิดการใช้งาน');
          return redirect()->back()->withInput($request->only('username','remember'));
        }
       
       return redirect()->back()->withInput($request->only('username','remember'));
    }
    
    protected function validateLogin(Request $request){
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request){
        Auth::guard('staff')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->guest(route( 'staff.login' ));
    }
}
