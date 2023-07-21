@extends("frontend/layouts/employee/template") 
<style>
/*  */
.container-coupon{
    width: 100%;
    height: 100vh;
    background: #f0fff3;
    display: flex;
    align-items: center;
    justify-content: center;
}

.coupon-card{
    background: linear-gradient(135deg, #0c7839, #91dd38);
    color: #fff;
    text-align: center;
    padding: 5px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 10px 0 rgba(209, 209, 209, 0.15);
    position: relative;
}

.coupon-card h3{
    font-size: 26px;
    font-weight: 400;
    line-height: 40px;
    color: #fff;
}

.coupon-card h4{
    font-size: 20px;
    font-weight: 400;
    color: #fff;
}

.coupon-card p{
    font-size: 15px;
}

.coupon-row{
    display: flex;
    align-items: center;
    margin: 25px auto;
    width: fit-content;
}

#cpnCode{
    border: 1px dashed #fff;
    padding: 10px 20px;
    border-right: 0;
}

#cpnCodeUsed{
    border: 1px dashed #fff;
    padding: 10px 20px;
}

#cpnBtn{
    border: 1px solid #fff;
    background: #fff;
    padding: 10px 20px;
    color: #7158fe;
    cursor: pointer;
}

.circle1, .circle2{
    background: #ffffff;
    width: 50px;
    height: 50px;
    border-radius: 50%; 
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.circle1{
    left: -25px;
}

.circle2{
    right: -25px;
}

.benefit span{
    color: red;
}

.benefit h4 {
    line-height: 1.5;
}
</style>
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="benefit">
                                <h3>สวัสดิการพนักงาน EDO GROUP</h3><hr>
                                <h4><i class='bx bxs-right-arrow'></i> ยางรถยนต์ลด 20% ทุกยี่ห้อ ทุกรุ่น ทุกขนาดในราคาปกติ</h4>
                                <h4><i class='bx bxs-right-arrow'></i> NTP ทุกรายการ ลด 30% จากราคาปกติ <span>** ฟรีค่าแรง</span></h4>
                                <h4><i class='bx bxs-right-arrow'></i> ร้านอาหารในเครือ EDO GROUP ลด 50% ทุกเมนู <span>** เฉพาะทานที่ร้านเท่านั้น</span></h4>
                                <h4><i class='bx bxs-right-arrow'></i> FLAT WHITE CAFE' ลด 50% ทุกเมนู <span>** เฉพาะทานที่ร้านเท่านั้น</span></h4>
                                <h4><i class='bx bxs-right-arrow'></i> OWL CHA ลด 50% ทุกเมนู <span>** เฉพาะที่สาขาโคกกลอยเท่านั้น</span></h4>
                                <h4>เงื่อนไขการใช้สวัสดิการพนักงาน</h4><hr>
                                <p><i class='bx bxs-right-arrow'></i> แสดงบัตรพนักงานออนไลน์ในระบบพนักงานเพื่อรับสิทธิ์ <span>** ห้ามบันทึกหน้าจอส่งให้บุคคลอื่น</span></p>
                                <p><i class='bx bxs-right-arrow'></i> พนักงานจะต้องใช้บริการด้วยตนเองเท่านั้น</p>
                                <p><i class='bx bxs-right-arrow'></i> ในกรณีใช้บริการร้านเอกการยาง พนักงานจะต้องแสดงเล่มรถที่มีชื่อตัวเองพร้อมบัตรพนักงานออนไลน์ หรือคนในครอบครัวที่มีเล่มรถนามสกุลตรงกับพนักงานเท่านั้น <span>** จะต้องแสดงพร้อมบัตรประชาชนเท่านั้น</span></p>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
            @if(count($benefits) !=0 )
                <div class="card mb-4">
                    <div class="card-body">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"/>
                    <div class="col-md-12 ">
                        <div class="row ">
                            @foreach ($benefits as $benefit => $value)
                            @php
                                $benefit = DB::table('benefits')->where('id',$value->benefit_id)->value('benefit');
                                $store = DB::table('benefits')->where('id',$value->benefit_id)->value('store');
                                $expire = DB::table('benefits')->where('id',$value->benefit_id)->value('expire');

                                $today = Carbon\carbon::now()->format('d/m/Y');

                                    //   คูปองหมดอายุ?
                                    if(date_format(date_create_from_format('d/m/Y',$expire),'Y-m-d') < date_format(date_create_from_format('d/m/Y',$today),'Y-m-d')) {
                                        $coupon_expire = "YES";
                                    } elseif(date_format(date_create_from_format('d/m/Y',$expire),'Y-m-d') == date_format(date_create_from_format('d/m/Y',$today),'Y-m-d')) {
                                        $coupon_expire = "NO";
                                    } elseif (date_format(date_create_from_format('d/m/Y',$expire),'Y-m-d') > date_format(date_create_from_format('d/m/Y',$today),'Y-m-d')) {
                                        $coupon_expire = "NO";
                                    }

                                $code = DB::table('benefits')->where('id',$value->benefit_id)->value('code');
                            @endphp
                                <div class="col-xl-4 col-lg-4">
                                    @if($value->status == "เปิด" && $coupon_expire == "NO")
                                    <div class="coupon-card">
                                        <h3>{{$store}}</h3>
                                        <h4>{{$benefit}}</h4>
                                
                                        <div class="coupon-row">
                                            <span id="cpnCode">{{$code}}</span>
                                            <span id="cpnBtn"><a href="{{url('staff/use-benefit')}}/{{$value->id}}">กดรับสิทธิ์</a></span>
                                        </div>
                                        <p>สามารถใช้ได้ถึงวันที่ {{$expire}}</p>

                                        <div class="circle1"></div>
                                        <div class="circle2"></div>
                                    </div><br>
                                    @elseif($value->status == "เปิด" && $coupon_expire == "YES")
                                    <div class="coupon-card" style="opacity: 0.5">
                                        <h3>{{$store}}</h3>
                                        <h4>{{$benefit}}</h4>
                                
                                        <div class="coupon-row">
                                            <span id="cpnBtn"><a href="#">ไม่สามารถรับสิทธิ์ได้</a></span>
                                        </div>
                                        <p>คูปองหมดอายุ</p>

                                        <div class="circle1"></div>
                                        <div class="circle2"></div>
                                    </div><br>
                                    @elseif($value->status == "กดรับสิทธิ์" || $value->status == "ใช้สิทธิ์แล้ว")
                                    <div class="coupon-card" style="opacity: 0.5">
                                        <h3>{{$store}}</h3>
                                        <h4>{{$benefit}}</h4>
                                
                                        <div class="coupon-row">
                                            <span id="cpnBtn">กดรับสิทธิ์แล้ว</span>
                                        </div>
                                        <p>กดรับสิทธิ์วันที่ {{$value->created_at}}</p>

                                        <div class="circle1"></div>
                                        <div class="circle2"></div>
                                    </div><br>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div> 
                    </div>
                    <hr class="my-0" />
                </div> 
            @endif
        </div>
    </div>
</div>
@endsection