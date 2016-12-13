<?php
include dirname(__DIR__).'\model\DB\authen.php';
include dirname(__DIR__).'\view\authen.php';
class authen_controller
{
  private $authen;
  private $view;
  function __construct()
  {
    $this->authen = new authen();
    $this->view = new authen_view();
  }
  public function register(string $user, string $password, string $email,int $flag,string $name,
                           string $surname,array $image,string $payment_number =  null)
  {
    $check = $this->authen->register($user,$password,$email,$flag,$name,$surname,$image,$payment_number);
    if ($check == true) {
        $this->view->register_complete();
    }elseif ($check == 'have_user') {
        $this->view->register_haveuser();
    }else {
      $this->view->error();
    }
  }
  public function login(string $user, string  $password, string  $email)
  {
    $check = $this->authen->login($user,$password,$email);
    if ($check != null && gettype($check) == 'array') {
      header('location: main.php');
    }else {
      $this->view->login_fail();
    }

  }
}
 ?>
