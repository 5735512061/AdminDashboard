<?php

namespace App\Http\Controllers\AuthStaff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;
use App\Employee;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('authStaff/passwords/change');
    }

    public function changePassword(Request $request)
    {
       $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
       ]);

        $hashedPassword = Auth::guard('staff')->user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)) {
            $member = Employee::find(Auth::guard('staff')->id());
            $member->password = Hash::make($request->password);
            $member->save();
            Auth::guard('staff')->logout();
            return redirect()->route('staff.login')->with('successMsg',"เปลี่ยนรหัสผ่านสำเร็จ");
        }else {
            return redirect()->back()->with('errorMsg',"รหัสผ่านไม่ถูกต้อง");
        }
       
    }
}
