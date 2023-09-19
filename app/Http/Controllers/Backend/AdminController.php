<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\BranchGroup;
use App\Model\Position;
use App\Model\Dayoff;
use App\Model\Salary;
use App\Model\PermissionEmployee;
use App\Model\EmployeeWork;
use App\Model\Benefit;
use App\Model\EmployeeBenefit;
use App\Model\Evaluation;
use App\Model\EvaluationManager;
use App\Model\EmployeeRate;
use App\Model\Fund;
use App\Model\Leave;
use App\Model\LeaveApproval;
use App\Model\Warning;

use App\Admin;
use App\Employee;
use Carbon\Carbon;

use Input;
use Response;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function chooseBranch() {
        return view('backend/admin/choose-branch');
    }

    public function setPermissionAdmin(Request $request) {
        $NUM_PAGE = 10;
        $admins = Admin::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('authAdmin/set-permission-admin')->with('NUM_PAGE',$NUM_PAGE)
                                                     ->with('page',$page)
                                                     ->with('admins',$admins);
    }

    public function permissionAdminDelete(Request $request, $id) {
        Admin::findOrFail($id)->delete();
        $request->session()->flash('alert-success', 'ลบข้อมูลสำเร็จ');
        return back();
    }

    public function permissionAdminEdit(Request $request) {
        $id = $request->get('id');
        $admin = Admin::findOrFail($id);
        $admin->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@setPermissionAdmin'); 
    }

    public function dashboard(Request $request,$branch_id) {
        \Session::put('branch_id', $branch_id);
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/dashboard')->with('NUM_PAGE',$NUM_PAGE)
                                              ->with('page',$page)
                                              ->with('employees',$employees)
                                              ->with('branch_id',$branch_id);
    }

    // จัดการข้อมูลพนักงาน
    public function formCreateEmployee($branch_id) {
        return view('backend/admin/employee/form-create-employee')->with('branch_id',$branch_id);
    }

    public function createEmployee(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_createEmployee(), $this->messages_createEmployee());
        if($validator->passes()) {
            $employee = $request->all();
            $branch_id = BranchGroup::where('branch',$request->get('branch'))->value('id');
            $employee['password'] = bcrypt($employee['password_name']);
            $employee['branch_id'] = $branch_id;
            $employee = Employee::create($employee);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('img_upload/employee/profile', $filename);
                $path = 'img_upload/employee/profile/'.$filename;
                $employee->image = $filename;
                $employee->save();
            } 

            $request->session()->flash('alert-success', 'เพิ่มพนักงานในระบบสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มพนักงานในระบบไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function showDataEmployeeByBranch(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee/show-data-employee-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                          ->with('page',$page)
                                                                          ->with('employees',$employees)
                                                                          ->with('branch_id',$branch_id);
    }

    public function editDataEmployee($branch_id, $id) {
        $employee = Employee::findOrFail($id); 
        return view('backend/admin/employee/edit-data-employee')->with('employee',$employee)
                                                                ->with('branch_id',$branch_id);
    }

    public function editDataEmployeePost(Request $request) {
        
        $id = $request->get('id');
        $employee = Employee::findOrFail($id);

        if($request->get('password_name') == '') {
            $employee['name'] = $request->get('name'); 
            $employee['surname'] = $request->get('surname');
            $employee['nickname'] = $request->get('nickname');
            $employee['idcard'] = $request->get('idcard');
            $employee['bday'] = $request->get('bday');
            $employee['tel'] = $request->get('tel');
            $employee['position_id'] = $request->get('position_id');

            $branch_id = BranchGroup::where('branch',$request->get('branch'))->value('id');

            $employee['branch_id'] = $branch_id;
            $employee['startdate'] = $request->get('startdate');
            $employee['address'] = $request->get('address');
            $employee['district'] = $request->get('district');
            $employee['amphoe'] = $request->get('amphoe');
            $employee['province'] = $request->get('province');
            $employee['zipcode'] = $request->get('zipcode');
            $employee['employee_name'] = $request->get('employee_name');
            $employee['status'] = $request->get('status');
            $employee->update();
            $employee->update($request->except('password'));
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('img_upload/employee/profile', $filename);
                $path = 'img_upload/employee/profile/'.$filename;
                $employee = Employee::findOrFail($id);
                $employee->image = $filename;
                $employee->save();
            }
        } else {
            $employee['name'] = $request->get('name'); 
            $employee['surname'] = $request->get('surname');
            $employee['nickname'] = $request->get('nickname');
            $employee['idcard'] = $request->get('idcard');
            $employee['bday'] = $request->get('bday');
            $employee['tel'] = $request->get('tel');
            $employee['position_id'] = $request->get('position_id');

            $branch_id = BranchGroup::where('branch',$request->get('branch'))->value('id');

            $employee['branch_id'] = $branch_id;
            $employee['startdate'] = $request->get('startdate');
            $employee['address'] = $request->get('address');
            $employee['district'] = $request->get('district');
            $employee['amphoe'] = $request->get('amphoe');
            $employee['province'] = $request->get('province');
            $employee['zipcode'] = $request->get('zipcode');
            $employee['employee_name'] = $request->get('employee_name');
            $employee['password_name'] = $request->get('password_name');
            $employee['password'] = bcrypt($request->get('password_name'));
            $employee['status'] = $request->get('status');
            $employee->update();
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = md5(($image->getClientOriginalName(). time()) . time()) . "_o." . $image->getClientOriginalExtension();
                $image->move('img_upload/employee-profile/', $filename);
                $path = 'img_upload/employee-profile/'.$filename;
                $employee = Employee::findOrFail($id);
                $employee->image = $filename;
                $employee->save();
            }
        }

        return redirect()->action('Backend\AdminController@showDataEmployeeByBranch',['branch_id' => $branch_id]); 
    }

    public function informationEmployee($branch_id, $id) {
        $employee = Employee::findOrFail($id); 

        $year = EmployeeWork::where('employee_id',$employee->id)->orderBy('id','desc')->value('year');

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ, $bonus = โบนัสรายปี

        $absence = (int)EmployeeWork::where('employee_id',$employee->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$employee->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$employee->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าสายมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$employee->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('backend/admin/employee/information-employee')->with('employee',$employee)
                                                                  ->with('branch_id',$branch_id)
                                                                  ->with('absence',$absence)
                                                                  ->with('late',$late)
                                                                  ->with('lateBalance',$lateBalance)
                                                                  ->with('absenceTotal',$absenceTotal)
                                                                  ->with('absenceBalance',$absenceBalance)
                                                                  ->with('bonus',$bonus);
    }

    public function formCreateBranchGroup(Request $request) {
        $NUM_PAGE = 10;
        $branch_groups = BranchGroup::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee/form-create-branch-group')->with('NUM_PAGE',$NUM_PAGE)
                                                                      ->with('page',$page)
                                                                      ->with('branch_groups',$branch_groups);
    }

    public function createBranchGroup(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_createBranchGroup(), $this->messages_createBranchGroup());
        if($validator->passes()) {
            $branch_group = $request->all();
            $branch_group = BranchGroup::create($branch_group);
            $request->session()->flash('alert-success', 'เพิ่มกลุ่มสาขาสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มกลุ่มสาขาไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function branchGroupDelete(Request $request, $id) {
        $status = BranchGroup::where('id',$id)->value('status');
        if($status == "เปิด") {
            BranchGroup::findOrFail($id)->delete();
            $request->session()->flash('alert-success', 'ลบข้อมูลสำเร็จ');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'ลบข้อมูลไม่สำเร็จ เนื่องจากข้อมูลมีการเปิดใช้งาน');
            return back();
        }
        
    }

    public function branchGroupEdit(Request $request) {
        $id = $request->get('id');
        $branch_group = BranchGroup::findOrFail($id);
        $branch_group->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@formCreateBranchGroup'); 
    }

    public function showDataEmployeeResignByBranch(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','พ้นสภาพพนักงาน')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee/show-data-employee-resign-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                                 ->with('page',$page)
                                                                                 ->with('employees',$employees)
                                                                                 ->with('branch_id',$branch_id);
    }

    public function formCreatePosition(Request $request, $branch_id) {
        $NUM_PAGE = 10;
        $positions = Position::where('branch_group_id',$branch_id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee/form-create-position')->with('NUM_PAGE',$NUM_PAGE)
                                                                  ->with('page',$page)
                                                                  ->with('positions',$positions)
                                                                  ->with('branch_id',$branch_id);
    }

    public function createPosition(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_createPosition(), $this->messages_createPosition());
        if($validator->passes()) {
            $position = $request->all();
            $position = Position::create($position);
            $request->session()->flash('alert-success', 'เพิ่มตำแหน่งงานสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มตำแหน่งงานไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function positionDelete(Request $request, $id) {
        $status = Position::where('id',$id)->value('status');
        if($status == "เปิด") {
            Position::findOrFail($id)->delete();
            $request->session()->flash('alert-success', 'ลบข้อมูลสำเร็จ');
            return back();
        } else {
            $request->session()->flash('alert-danger', 'ลบข้อมูลไม่สำเร็จ เนื่องจากข้อมูลมีการเปิดใช้งาน');
            return back();
        }
    }

    public function positionEdit(Request $request) {
        $id = $request->get('id');
        $branch_id = $request->get('branch_id');
        $position = Position::findOrFail($id);
        $position->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@formCreatePosition',['id' => $branch_id]); 
    }

    public function employeeBenefitByBranch(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-benefit/employee-benefit-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                                ->with('page',$page)
                                                                                ->with('employees',$employees)
                                                                                ->with('branch_id',$branch_id);
    }

    public function createBenefitEmployee(Request $request) {
        $employee_id = $request->get('employee_id');
        $benefit_id = $request->get('benefit_id_'.$employee_id);
        $status = $request->get('status');

        for ($i=0; $i < count($benefit_id); $i++) {
            if($benefit_id[$i] != null) {
                $benefit_employee = new EmployeeBenefit;
                $benefit_employee->employee_id = $employee_id;
                $benefit_employee->benefit_id = $benefit_id[$i];
                $benefit_employee->status = $status;
                $benefit_employee->save();
            }
        }

        $request->session()->flash('alert-success', 'เพิ่มสวัสดิการพนักงานสำเร็จ');
        return back();
    }

    public function formCreateBenefit(Request $request, $branch_id) {
        $NUM_PAGE = 10;
        $benefits = Benefit::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-benefit/form-create-benefit')->with('NUM_PAGE',$NUM_PAGE)
                                                                         ->with('page',$page)
                                                                         ->with('benefits',$benefits)
                                                                         ->with('branch_id',$branch_id);
    }

    public function createBenefit(Request $request) {
        $benefit = $request->all();
        $benefit = Benefit::create($benefit);
        $request->session()->flash('alert-success', 'เพิ่มหัวข้อสวัสดิการสำเร็จ');
        return back();
    }

    public function test(){
        return view('backend/admin/employee-benefit/test');
    }

    public function employeeBenefitMore(Request $request, $employee_id) {
        $NUM_PAGE = 10;
        $benefits = EmployeeBenefit::where('employee_id',$employee_id)->orderBy('id','desc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-benefit/employee-benefit-more')->with('NUM_PAGE',$NUM_PAGE)
                                                                           ->with('page',$page)
                                                                           ->with('benefits',$benefits)
                                                                           ->with('employee_id',$employee_id);
    }

    public function employeeUseBenefit(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $benefits = EmployeeBenefit::where('status','ใช้สิทธิ์แล้ว')->OrWhere('status','กดรับสิทธิ์')->orderBy('updated_at','desc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-benefit/employee-use-benefit')->with('NUM_PAGE',$NUM_PAGE)
                                                                          ->with('page',$page)
                                                                          ->with('benefits',$benefits);
    }

    public function confirmCoupon($benefit_id) {
        $benefit = EmployeeBenefit::findOrFail($benefit_id);
        $benefit->status = "ใช้สิทธิ์แล้ว";
        $benefit->update();
        return back();
    }

    // จัดการข้อมูลการทำงาน
    public function createWork(Request $request) {
        $employee_work = $request->all();

        $month = $request->get('month');
            if($month == 'มกราคม') $month_ = '01'; elseif($month == 'กุมภาพันธ์') $month_ = '02';
            elseif($month == 'มีนาคม') $month_ = '03'; elseif($month == 'เมษายน') $month_ = '04';
            elseif($month == 'พฤษภาคม') $month_ = '05'; elseif($month == 'มิถุนายน') $month_ = '06';
            elseif($month == 'กรกฎาคม') $month_ = '07'; elseif($month == 'สิงหาคม') $month_ = '08';
            elseif($month == 'กันยายน') $month_ = '09'; elseif($month == 'ตุลาคม') $month_ = '10';
            elseif($month == 'พฤศจิกายน') $month_ = '11'; elseif($month == 'ธันวาคม') $month_ = '12';
            else $month_ = '';
        $employee_work['month_'] = $month_;

        $employee_work = EmployeeWork::create($employee_work);
        $request->session()->flash('alert-success', 'เพิ่มข้อมูลการทำงานสำเร็จ');
        return back();
    }

    public function showEmployeeWork() {
        return view('backend/admin/employee-work/show-employee-work');
    }

    public function showEmployeeWorkByBranch(Request $request, $branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-work/show-employee-work-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                               ->with('page',$page)
                                                                               ->with('employees',$employees)
                                                                               ->with('branch_id',$branch_id);
    }

    public function employeeWorkInformation(Request $request, $id) {
        $NUM_PAGE = 15;

        $branch_id = Employee::where('id',$id)->value('branch_id');

        $staff = Employee::findOrFail($id);
        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');
        $works = EmployeeWork::where('employee_id',$id)->where('year',$year)->paginate($NUM_PAGE);

        $page = $request->input('page');
        $page = ($page != null)?$page:1;

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ, $bonus = โบนัสรายปี

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าสายมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->orderBy('id','desc')->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        $funds = Fund::where('employee_id',$staff->id)->orderBy('id','asc')->get();  //เงินกองทุนสะสม
        // คำนวณจำนวนปีที่ทำงาน เพื่อนำไปคำนวณเปอร์เซ็นต์
            $startdate = Employee::where('id',$staff->id)->value('startdate');
            $startdate = strtr($startdate,'/','-');
            $startdate_d = date('d',strtotime($startdate));
            $startdate_m = date('m',strtotime($startdate));
            $startdate_y = date('Y',strtotime($startdate));
            
            $date = Carbon::parse($startdate_y."-".$startdate_m."-".$startdate_d);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);    
            $year_work = intval($diff/365);
        // จบ
        return view('backend/admin/employee-work/employee-work-information')->with('NUM_PAGE',$NUM_PAGE)
                                                                            ->with('page',$page)
                                                                            ->with('branch_id',$branch_id)
                                                                            ->with('staff',$staff)
                                                                            ->with('works',$works)
                                                                            ->with('absence',$absence)
                                                                            ->with('late',$late)
                                                                            ->with('lateBalance',$lateBalance)
                                                                            ->with('absenceTotal',$absenceTotal)
                                                                            ->with('absenceBalance',$absenceBalance)
                                                                            ->with('bonus',$bonus)
                                                                            ->with('funds',$funds)
                                                                            ->with('year_work',$year_work);
    }

    public function deleteWorkEmployee(Request $request, $id) {
        EmployeeWork::findOrFail($id)->delete();
        $request->session()->flash('alert-success', 'ลบข้อมูลสำเร็จ');
        return back();
    }

    public function editWorkEmployee(Request $request, $id) {
        $employee_work = EmployeeWork::findOrFail($id); 
        return view('backend/admin/employee-work/edit-work-employee')->with('employee_work',$employee_work);
    }

    public function updateWorkEmployee(Request $request) {
        $id = $request->get('id');
        $employee_work = EmployeeWork::findOrFail($id);
        $employee_work->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@employeeWorkInformation',['employee_id'=>$employee_work->employee_id]); 
    }

    // จัดการข้อมูลวันลา
    public function leaveApproval() {
        return view('backend/admin/employee-leave/leave-approval');
    }

    public function leaveApprovalPost(Request $request) {
        $leave_approval = $request->all();
        $leave_approval = LeaveApproval::create($leave_approval);
        return redirect()->action('Backend\\AdminController@showLeaveInformation'); 
    }

    public function leaveApprovalByBranch($branch_id) {
        $NUM_PAGE = 20;
        $leaves = Leave::join('leave_approvals','leaves.id', '=', 'leave_approvals.leave_id')
                       ->select('leaves.*','leave_approvals.status')->where('leave_approvals.status','!=','อนุมัติการลา')->get();
        return view('backend/admin/employee-leave/leave-approval-by-branch')->with('leaves',$leaves)
                                                                            ->with('branch_id',$branch_id);
    }

    public function showLeaveInformation(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $leaves = Leave::paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-leave/show-leave-information')->with('NUM_PAGE',$NUM_PAGE)
                                                                          ->with('page',$page)
                                                                          ->with('leaves',$leaves)
                                                                          ->with('branch_id',$branch_id);
    }  
    
    public function employeeLeaveInformation(Request $request,$id) {
        $NUM_PAGE = 20;
        $leaves = Leave::where('employee_id',$id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-leave/employee-leave-information')->with('NUM_PAGE',$NUM_PAGE)
                                                                              ->with('page',$page)
                                                                              ->with('leaves',$leaves);
    }

    public function dayoff() {
        return view('backend/admin/employee-leave/dayoff');
    }

    public function dayoffByBranch(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-leave/dayoff-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                    ->with('page',$page)
                                                                    ->with('employees',$employees)
                                                                    ->with('branch_id',$branch_id);
    }

    public function dayoffInformation($branch_id, $id) {
        $staff = Employee::findOrFail($id);
        $dayoffs = Dayoff::where('employee_id',$id)->get();

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าสายมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('backend/admin/employee-leave/dayoff-information')->with('staff',$staff)
                                                                      ->with('dayoffs',$dayoffs)
                                                                      ->with('absence',$absence)
                                                                      ->with('late',$late)
                                                                      ->with('lateBalance',$lateBalance)
                                                                      ->with('absenceTotal',$absenceTotal)
                                                                      ->with('absenceBalance',$absenceBalance)
                                                                      ->with('bonus',$bonus)
                                                                      ->with('branch_id',$branch_id);
    }

    public function createDayoff(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_createDayoff(), $this->messages_createDayoff());
        if($validator->passes()) {
            $dayoff = $request->all();
            $dayoff = Dayoff::create($dayoff);
            $request->session()->flash('alert-success', 'เพิ่มวันหยุดประจำปีสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'เพิ่มวันหยุดประจำปีไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    // จัดการข้อมูลด้านการเงิน
    public function salary() {
        return view('backend/admin/employee-financial/salary');
    }

    public function salaryByBranch(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-financial/salary-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                        ->with('page',$page)
                                                                        ->with('employees',$employees)
                                                                        ->with('branch_id',$branch_id);
    }

    public function createSalary(Request $request) {
        $validator = Validator::make($request->all(), $this->rules_createSalary(), $this->messages_createSalary());
        if($validator->passes()) {
            $salary = $request->all();
            $month = $request->get('month');
            
            if($month == 'มกราคม') $month_ = '01'; elseif($month == 'กุมภาพันธ์') $month_ = '02';
            elseif($month == 'มีนาคม') $month_ = '03'; elseif($month == 'เมษายน') $month_ = '04';
            elseif($month == 'พฤษภาคม') $month_ = '05'; elseif($month == 'มิถุนายน') $month_ = '06';
            elseif($month == 'กรกฎาคม') $month_ = '07'; elseif($month == 'สิงหาคม') $month_ = '08';
            elseif($month == 'กันยายน') $month_ = '09'; elseif($month == 'ตุลาคม') $month_ = '10';
            elseif($month == 'พฤศจิกายน') $month_ = '11'; elseif($month == 'ธันวาคม') $month_ = '12';
            else $month_ = '';
            $salary['month_'] = $month_;

            $salary = Salary::create($salary);
            $request->session()->flash('alert-success', 'กรอกข้อมูลเงินเดือนสำเร็จ');
            return back();
        }
        else {
            $request->session()->flash('alert-danger', 'กรอกข้อมูลเงินเดือนไม่สำเร็จ กรุณาตรวจสอบข้อมูล');
            return back()->withErrors($validator)->withInput();
        }
    }

    public function salaryInformation($branch_id, $id) {
        $staff = Employee::findOrFail($id);
        $salarys = Salary::where('employee_id',$id)->get();

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าสายมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('backend/admin/employee-financial/salary-information')->with('staff',$staff)
                                                                          ->with('salarys',$salarys)
                                                                          ->with('absence',$absence)
                                                                          ->with('late',$late)
                                                                          ->with('lateBalance',$lateBalance)
                                                                          ->with('absenceTotal',$absenceTotal)
                                                                          ->with('absenceBalance',$absenceBalance)
                                                                          ->with('bonus',$bonus)
                                                                          ->with('branch_id',$branch_id);
    }

    public function providentFundByBranch(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-financial/provident-fund-by-branch')->with('NUM_PAGE',$NUM_PAGE)
                                                                                ->with('page',$page)
                                                                                ->with('employees',$employees)
                                                                                ->with('branch_id',$branch_id);
    }

    public function createProvidentFund(Request $request) {
        $fund = $request->all();
        $fund = Fund::create($fund);
        return back();
    }

    public function providentFundInformation(Request $request, $branch_id, $id) {
        $NUM_PAGE = 15;

        $staff = Employee::findOrFail($id);
        $funds = Fund::where('employee_id',$staff->id)->orderBy('id','asc')->paginate($NUM_PAGE);  

            // คำนวณจำนวนปีที่ทำงาน เพื่อนำไปคำนวณเปอร์เซ็นต์
                $startdate = Employee::where('id',$staff->id)->value('startdate');
                $startdate = strtr($startdate,'/','-');
                $startdate_d = date('d',strtotime($startdate));
                $startdate_m = date('m',strtotime($startdate));
                $startdate_y = date('Y',strtotime($startdate));

                $date = Carbon::parse($startdate_y."-".$startdate_m."-".$startdate_d);
                $now = Carbon::now();
                $diff = $date->diffInDays($now);    
                $year_work = intval($diff/365);
            // จบ

        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/employee-financial/provident-fund-information')->with('funds',$funds)
                                                                                  ->with('staff',$staff)
                                                                                  ->with('year_work',$year_work)
                                                                                  ->with('branch_id',$branch_id);
    }

    // เกี่ยวกับการประเมินผล
    public function formEmployeeEvaluate(Request $request, $branch_id) { 
        $NUM_PAGE = 20;
        $evaluates = Evaluation::orderBy('set','desc')->get();
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/evaluate/create-form-employee-evaluate')->with('NUM_PAGE',$NUM_PAGE)
                                                                           ->with('page',$page)
                                                                           ->with('branch_id',$branch_id)
                                                                           ->with('evaluates',$evaluates);
    }

    public function createFormEmployeeEvaluate(Request $request) {
        $evaluate = $request->all();
        $evaluate = Evaluation::create($evaluate);
        $request->session()->flash('alert-success', 'เพิ่มแบบประเมินพนักงานสำเร็จ');
        return back();
    }

    public function editFormEmployeeEvaluate(Request $request) {
        $id = $request->get('id');
        $form_evaluate = Evaluation::findOrFail($id);
        $form_evaluate->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@formEmployeeEvaluate',['branch_id'=>session('branch_id')]); 
    }

    public function listEmployeeEvaluate(Request $request, $branch_id) {
        $NUM_PAGE = 50;
        $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
                             ->select('employees.*', 'positions.position')   
                             ->where('branch_id',$branch_id)
                             ->where('positions.position','!=','MANAGER')
                             ->where('employees.status','เปิด')
                             ->paginate($NUM_PAGE);
                             
        $dateNow = Carbon::now()->format('d/m/Y');
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/evaluate/list-employee-evaluate')->with('NUM_PAGE',$NUM_PAGE)
                                                                    ->with('page',$page)
                                                                    ->with('employees',$employees)
                                                                    ->with('dateNow',$dateNow)
                                                                    ->with('branch_id',$branch_id);
    }

    public function evaluateDetail(Request $request, $id) {
        $employee = Employee::findOrFail($id);

        $yearNow = Carbon::now()->format('Y'); //เพิ่มเปรียบเทียบปีปัจจุบัน

        $rates = EmployeeRate::where('employee_id',$id)
                             ->where('date', 'like', '%'.$yearNow) //เพิ่มเปรียบเทียบปีปัจจุบัน
                            //  ->groupBy('date')
                             ->selectRaw('*, sum(rate) as sum')
                             ->orderBy('created_at','desc')
                             ->get();
        $year = EmployeeRate::where('employee_id',$id)->value('date');
        $year = strtr($year,'/','-');
        $year = date('Y',strtotime($year));
        return view('backend/admin/evaluate/employee-evaluate-detail')->with('employee',$employee)
                                                                      ->with('rates',$rates)
                                                                      ->with('year',$year);
    }

    public function evaluateFormDetail(Request $request,$id,$date_d,$date_m,$date_y) {
        $date = $date_d.'/'.$date_m.'/'.$date_y;
        $rates = EmployeeRate::where('employee_id',$id)
                             ->where('date',$date)
                             ->get();
        $sumRates = EmployeeRate::where('employee_id',$id)
                                ->where('date',$date)
                                ->selectRaw('*, sum(rate) as sum')
                                ->orderBy('created_at','desc')
                                ->get();
            foreach($sumRates as $sumRate => $value) {
                $sum = $value->sum;
            }
        return view('backend/admin/evaluate/employee-evaluate-form-detail')->with('rates',$rates)
                                                                           ->with('sum',$sum);
    }
    
    public function formManagerEvaluate(Request $request, $branch_id) { 
        $NUM_PAGE = 20;
        $evaluates = EvaluationManager::get();
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/evaluate/create-form-manager-evaluate')->with('NUM_PAGE',$NUM_PAGE)
                                                                          ->with('page',$page)
                                                                          ->with('branch_id',$branch_id)
                                                                          ->with('evaluates',$evaluates);
    }

    public function createFormManagerEvaluate(Request $request) {
        $evaluate = $request->all();
        $evaluate = EvaluationManager::create($evaluate);
        $request->session()->flash('alert-success', 'เพิ่มแบบประเมินผู้จัดการสำเร็จ');
        return back();
    }

    public function editFormManagerEvaluate(Request $request) {
        $id = $request->get('id');
        $form_evaluate = EvaluationManager::findOrFail($id);
        $form_evaluate->update($request->all());
        $request->session()->flash('alert-success', 'แก้ไขข้อมูลสำเร็จ');
        return redirect()->action('Backend\\AdminController@formManagerEvaluate',['branch_id'=>session('branch_id')]); 
    }

    public function listManagerEvaluate(Request $request, $branch_id) {
        $NUM_PAGE = 50;
        $managers = EvaluationManager::where('branch_id',$branch_id)->where('status','เปิด')->paginate($NUM_PAGE);
        $dateNow = Carbon::now()->format('d/m/Y');
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/evaluate/list-manager-evaluate')->with('NUM_PAGE',$NUM_PAGE)
                                                                   ->with('page',$page)
                                                                   ->with('managers',$managers)
                                                                   ->with('dateNow',$dateNow)
                                                                   ->with('branch_id',$branch_id);
    }

    // เกี่ยวกับข้อมูลข่าวสาร / ใบเตือน
    public function createNews() {
        return view('backend/admin/news-warning/create-news');
    }

    public function showNews() {
        return view('backend/admin/news-warning/show-news');
    }

    public function createWarning(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $employees = Employee::where('branch_id',$branch_id)->where('status','เปิด')->orderBy('position_id','asc')->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/news-warning/create-warning')->with('NUM_PAGE',$NUM_PAGE)
                                                                ->with('page',$page)
                                                                ->with('employees',$employees)
                                                                ->with('branch_id',$branch_id);
    }

    public function createWarningPost(Request $request) {
        $warning = $request->all();
        $warning = Warning::create($warning);
        $branch_id = session('branch_id');             
        $request->session()->flash('alert-success', 'ยื่นใบเตือนสำเร็จ');
        return redirect()->action('Backend\\AdminController@showWarning',['branch_id'=> $branch_id]); 
    }

    public function showWarning(Request $request,$branch_id) {
        $NUM_PAGE = 20;
        $warnings = Warning::where('branch_id',$branch_id)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('backend/admin/news-warning/show-warning')->with('NUM_PAGE',$NUM_PAGE)
                                                              ->with('page',$page)
                                                              ->with('warnings',$warnings)
                                                              ->with('branch_id',$branch_id);
    }

    // Validate
    public function rules_createBranchGroup() {
        return [
            'branch' => 'required',
        ];
    }

    public function messages_createBranchGroup() {
        return [
            'branch.required' => 'กรุณากรอกชื่อกลุ่มสาขา',
        ];
    }

    public function rules_createPosition() {
        return [
            'position' => 'required',
        ];
    }

    public function messages_createPosition() {
        return [
            'position.required' => 'กรุณากรอกตำแหน่งงาน',
        ];
    }

    public function rules_createEmployee() {
        return [
            'idcard' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'bday' => 'required',
            'nickname' => 'required',
            'tel' => 'required',
            'startdate' => 'required',
            'address' => 'required',
            'district' => 'required',
            'amphoe' => 'required',
            'province' => 'required',
            'zipcode' => 'required',
            'employee_name' => 'required',
            'password_name' => 'required',
        ];
    }

    public function messages_createEmployee() {
        return [
            'idcard.required' => 'กรุณากรอกหมายเลขบัตรประชาชน 13 หลัก',
            'name.required' => 'กรุณากรอกชื่อพนักงาน',
            'surname.required' => 'กรุณากรอกนามสกุล',
            'bday.required' => 'กรุณากรอกวัน/เดือน/ปีเกิด',
            'nickname.required' => 'กรุณากรอกชื่อเล่น',
            'tel.required' => 'กรุณากรอกชื่อเบอร์โทรศัพท์',
            'startdate.required' => 'กรุณากรอกวัน/เดือน/ปี ที่เริ่มงาน',
            'address.required' => 'กรุณากรอกที่อยู่ / หมู่',
            'district.required' => 'กรุณากรอกตำบล',
            'amphoe.required' => 'กรุณากรอกอำเภอ',
            'province.required' => 'กรุณากรอกจังหวัด',
            'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
            'employee_name.required' => 'กรุณากรอกชื่อเข้าใช้งาน',
            'password_name.required' => 'กรุณาตั้งรหัสเพื่อเข้าสู่ระบบ',
        ];
    }

    public function rules_createDayoff() {
        return [
            'dayoff' => 'required',
        ];
    }

    public function messages_createDayoff() {
        return [
            'dayoff.required' => 'กรุณากรอกวันหยุดประจำปี',
        ];
    }

    public function rules_createSalary() {
        return [
            'salary' => 'required',
        ];
    }

    public function messages_createSalary() {
        return [
            'salary.required' => 'กรุณากรอกข้อมูลเงินเดือน',
        ];
    }
}
