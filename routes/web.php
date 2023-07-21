<?php

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});

Route::group(['prefix' => 'admin'], function(){
    // Route::get('/test','Backend\\AdminController@test');
    // เลือกสาขา
    Route::get('/choose-branch','Backend\\AdminController@chooseBranch')->name('admin.home');

    // เกี่ยวกับผู้ดูแลระบบ
    Route::get('/register','AuthAdmin\RegisterController@ShowRegisterForm'); //ฟอร์มลงทะเบียนแอดมิน
    Route::post('/register','AuthAdmin\RegisterController@register'); //ลงทะเบียนแอดมิน
    Route::get('/set-permission-admin','Backend\AdminController@setPermissionAdmin'); //กำหนดสิทธิ์การใช้งานของแอดมิน
    Route::get('/permission-admin-delete/{id}','Backend\\AdminController@permissionAdminDelete'); 
    Route::post('/permission-admin-edit','Backend\\AdminController@permissionAdminEdit'); 

    Route::get('/login','AuthAdmin\LoginController@ShowLoginForm')->name('admin.login'); //ฟอร์มเข้าสู่ระบบของแอดมิน
    Route::post('/login','AuthAdmin\LoginController@login')->name('admin.login.submit'); //แอดมินเข้าสู่ระบบ
    Route::post('/logout', 'AuthAdmin\LoginController@logout')->name('admin.logout'); //ออกจากระบบ

    Route::get('/dashboard/{id}','Backend\\AdminController@dashboard'); //หน้าหลัก Dashboard

    // จัดการข้อมูลพนักงาน
    Route::get('/form-create-employee/{id}','Backend\\AdminController@formCreateEmployee'); //ฟอร์มเพิ่มพนักงานในระบบ
    Route::post('/create-employee','Backend\\AdminController@createEmployee'); //เพิ่มพนักงานในระบบ
    Route::get('/show-data-employee/{id}','Backend\\AdminController@showDataEmployeeByBranch');
    Route::get('/edit-data-employee/{branch_id}/{id}','Backend\\AdminController@editDataEmployee');
    Route::post('/edit-data-employee','Backend\\AdminController@editDataEmployeePost');
    Route::get('/information-employee/{branch_id}/{id}','Backend\\AdminController@informationEmployee');

    Route::get('/form-create-branch-group','Backend\\AdminController@formCreateBranchGroup');
    Route::post('/create-branch-group','Backend\\AdminController@createBranchGroup');
    Route::get('/branch-group-delete/{id}','Backend\\AdminController@branchGroupDelete'); 
    Route::post('/branch-group-edit','Backend\\AdminController@branchGroupEdit'); 

    Route::get('/show-data-employee-resign-by-branch/{id}','Backend\\AdminController@showDataEmployeeResignByBranch');

    Route::get('/form-create-position/{id}','Backend\\AdminController@formCreatePosition');
    Route::post('/create-position','Backend\\AdminController@createPosition');
    Route::get('/position-delete/{id}','Backend\\AdminController@positionDelete'); 
    Route::post('/position-edit','Backend\\AdminController@positionEdit'); 

    // สวัสดิการ
    Route::get('/employee-benefit-by-branch/{id}','Backend\\AdminController@employeeBenefitByBranch');
    Route::post('/create-benefit-employee','Backend\\AdminController@createBenefitEmployee');
    Route::get('/form-create-benefit/{id}','Backend\\AdminController@formCreateBenefit');
    Route::post('/create-benefit','Backend\\AdminController@createBenefit');
    Route::get('/employee-benefit-more/{employee_id}','Backend\\AdminController@employeeBenefitMore');
    Route::get('/employee-use-benefit/{branch_id}','Backend\\AdminController@employeeUseBenefit');
    Route::get('/confirm-coupon/{benefit_id}','Backend\\AdminController@confirmCoupon');

    // จัดการข้อมูลการทำงาน
    Route::get('/show-employee-work-by-branch/{id}','Backend\\AdminController@showEmployeeWorkByBranch');
    Route::get('/employee-work-information/{id}','Backend\\AdminController@employeeWorkInformation');
    Route::get('/from-create-work','Backend\\AdminController@fromCreateWork');
    Route::post('/create-work','Backend\\AdminController@createWork');

    // จัดการข้อมูลวันลา และวันหยุดประจำปี
    Route::get('/leave-approval-by-branch/{id}','Backend\\AdminController@leaveApprovalByBranch');
    Route::post('/leave-approval','Backend\\AdminController@leaveApprovalPost');
    Route::get('/show-leave-information/{id}','Backend\\AdminController@showLeaveInformation');
    Route::get('/dayoff-by-branch/{id}','Backend\\AdminController@dayoffByBranch');
    Route::get('/dayoff-information/{branch_id}/{id}','Backend\\AdminController@dayoffInformation');
    Route::post('/create-dayoff','Backend\\AdminController@createDayoff');
    Route::get('/employee-leave-information/{id}','Backend\\AdminController@employeeLeaveInformation');

    // จัดการข้อมูลด้านการเงิน
    Route::get('/salary','Backend\\AdminController@salary');
    Route::get('/salary-by-branch/{id}','Backend\\AdminController@salaryByBranch');
    Route::post('/create-salary','Backend\\AdminController@createSalary');
    Route::get('/salary-information/{branch_id}/{id}','Backend\\AdminController@salaryInformation');

    Route::get('/provident-fund-by-branch/{id}','Backend\\AdminController@providentFundByBranch');
    Route::post('/create-provident-fund','Backend\\AdminController@createProvidentFund');
    Route::get('/provident-fund-information/{branch_id}/{id}','Backend\\AdminController@providentFundInformation');

    // เกี่ยวกับการประเมินผล
    Route::get('/form-employee-evaluate/{branch_id}','Backend\\AdminController@formEmployeeEvaluate');
    Route::post('/create-form-employee-evaluate','Backend\\AdminController@createFormEmployeeEvaluate');
    Route::post('/edit-form-employee-evaluate','Backend\\AdminController@editFormEmployeeEvaluate');
    Route::get('/list-employee-evaluate/{branch_id}','Backend\\AdminController@listEmployeeEvaluate');
    Route::get('/evaluate-detail/{id}','Backend\\AdminController@evaluateDetail');
    Route::get('/evaluate-form-detail/{id}/{date_d?}/{date_m?}/{date_y?}','Backend\\AdminController@evaluateFormDetail');

    Route::get('/form-manager-evaluate/{branch_id}','Backend\\AdminController@formManagerEvaluate');
    Route::post('/create-form-manager-evaluate','Backend\\AdminController@createFormManagerEvaluate');
    Route::post('/edit-form-manager-evaluate','Backend\\AdminController@editFormManagerEvaluate');
    Route::get('/list-manager-evaluate/{branch_id}','Backend\\AdminController@listManagerEvaluate');


    // เกี่ยวกับข้อมูลข่าวสาร / ใบเตือน
    Route::get('/create-news','Backend\\AdminController@createNews');
    Route::get('/show-news','Backend\\AdminController@showNews');
    Route::get('/create-warning/{branch_id}','Backend\\AdminController@createWarning');
    Route::post('/create-warning','Backend\\AdminController@createWarningPost');
    Route::get('/show-warning/{branch_id}','Backend\\AdminController@showWarning');

});

Route::group(['prefix' => 'staff'], function(){
    Route::get('/login','AuthStaff\LoginController@ShowLoginForm')->name('staff.login');
    Route::post('/login','AuthStaff\LoginController@login')->name('staff.login.submit');
    Route::post('/logout', 'AuthStaff\LoginController@logout')->name('staff.logout');

    // เปลี่ยนรหัสผ่าน
    Route::get('/change-password', 'AuthStaff\ChangePasswordController@index')->name('password.change');
    Route::post('/change-password', 'AuthStaff\ChangePasswordController@changePassword')->name('update.password');

    Route::get('/dashboard','Frontend\\StaffController@dashboard')->name('staff.home');
    Route::get('/profile','Frontend\\StaffController@profile');
    Route::get('/work-information','Frontend\\StaffController@workInformation');
    Route::get('/salary-information','Frontend\\StaffController@salaryInformation');
    Route::get('/provident-fund-information','Frontend\\StaffController@providentFundInformation');
    Route::get('/leave-work','Frontend\\StaffController@leaveWork');
    Route::post('/leave-work','Frontend\\StaffController@leaveWorkPost');
    Route::get('/benefit','Frontend\\StaffController@benefit');
    Route::get('/use-benefit/{id}','Frontend\\StaffController@useBenefit');

    // แบบประเมิน
    Route::get('/list-employee-evaluate','Frontend\\StaffController@listEmployeeEvaluate');
    Route::get('/from-employee-evaluate/{id}','Frontend\\StaffController@formEmployeeEvaluate');
    Route::post('/from-employee-evaluate','Frontend\\StaffController@formEmployeeEvaluatePost');
});

Auth::routes();

