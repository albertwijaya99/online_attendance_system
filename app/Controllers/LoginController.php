<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{

    public function index()
    {
        //intialize model and helper
        session()->start();
        return view('pages/Login');
    }
    public function checkLoginData()
    {
        //initialize model and helper
        $db      = \Config\Database::connect(); //to help sanitize input
        $EmployeeModel = new EmployeeModel();

        $loginEmail = $db->escapeString($_POST['loginEmail']);
        $loginPassword = $db->escapeString($_POST['loginPassword']);
        $hashedPassword = hash('sha512',$loginPassword);
        $hashedEmail = hash('sha512',$loginEmail);
        $saltedPassword = hash('sha512',$hashedEmail.$hashedPassword);

        if($EmployeeModel->loginCheck($loginEmail,$saltedPassword) === 'berhasil'){
            $this->createSession($loginEmail);
            return redirect()->to(base_url('/profile'));
        }
        else{
            $loginErrorMsg = "Email or Password incorrect";
            session()->setFlashdata('error_msg',$loginErrorMsg);
            return redirect()->to(base_url('/login'));
        }

    }

    private function createSession($emailLogin)
    {
        //initialize model and helper
        $EmployeeModel = new EmployeeModel();

        $data = [
            'Email' => $emailLogin,
            'isAdmin' => $EmployeeModel->isAdmin($emailLogin)
        ];
        session()->set($data);
        return true;
    }
    public function logout(){
        session()->destroy();
        return redirect()->to(base_url('/login'));
    }
}