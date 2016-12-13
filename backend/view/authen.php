<?php
class authen_view
{

  function __construct()
  {}
  public function register_complete()
  {
    echo "ลงทะเบียนสำเร็จ";
  }
  public function register_haveuser()
  {
    echo "มีชื่อผู้ใช้งานนี้แล้ว";
  }
  public function error()
  {
    echo "เกิดปัญหาโปรดลองใหม่ภายหลัง";
  }
  public function login_fail()
  {
    echo "รหัสผ่านไม่ถูกต้อง";
  }
}


 ?>
