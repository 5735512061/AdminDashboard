@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลการทำงาน /</span> เพิ่มข้อมูลการทำงาน</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">ข้อมูลการทำงาน</h5>
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAccountSettings" method="POST" onsubmit="return false">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">หมายเลขบัตรประชาชน</label>
                  <input class="form-control" type="text" name="idCard" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">ชื่อพนักงาน</label>
                  <input class="form-control" type="text" name="firstName" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">นามสกุล</label>
                  <input class="form-control" type="text" name="lastName" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">ชื่อเล่น</label>
                  <input class="form-control" type="text" name="nickname" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">วัน/เดือน/ปีเกิด</label>
                    <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">เบอร์โทรศัพท์</label>
                  <input class="form-control" type="text" name="tel" autofocus/>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="country">ตำแหน่งงาน</label>
                  <select name="position" class="select2 form-select">
                    <option value="">Select</option>
                    <option value="Australia">Australia</option>
                    <option value="Bangladesh">Bangladesh</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">วัน/เดือน/ปี ที่เริ่มงาน</label>
                    <input class="form-control" type="date" value="2021-06-18" id="html5-date-input" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="state" class="form-label">State</label>
                  <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="zipCode" class="form-label">Zip Code</label>
                  <input
                    type="text"
                    class="form-control"
                    id="zipCode"
                    name="zipCode"
                    placeholder="231465"
                    maxlength="6"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="country">Country</label>
                  <select id="country" class="select2 form-select">
                    <option value="">Select</option>
                    <option value="Australia">Australia</option>
                    <option value="Bangladesh">Bangladesh</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="language" class="form-label">Language</label>
                  <select id="language" class="select2 form-select">
                    <option value="">Select Language</option>
                    <option value="en">English</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                    <option value="pt">Portuguese</option>
                  </select>
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2" style="font-family: 'Sarabun';">บันทึกข้อมูล</button>
                <button type="reset" class="btn btn-outline-secondary" style="font-family: 'Sarabun';">ยกเลิก</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection