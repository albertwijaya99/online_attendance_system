<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{

    public function index()
    {
        //intialize model and helper
        $EmployeeModel = new EmployeeModel();
        $data['Employee'] = $EmployeeModel->getAllEmployee();

        return view('pages/Login',$data);
    }
    public function checkLoginData()
    {
        //initialize model and helper
        $db      = \Config\Database::connect(); //to help sanitize input
        $EmployeeModel = new EmployeeModel();

        $loginEmail = $db->escapeString($_POST['loginEmail']);
        $loginPassword = $db->escapeString(md5($_POST['loginPassword']));
        if($EmployeeModel->loginCheck($loginEmail,$loginPassword) === 'berhasil'){
            $this->createSession($loginEmail);
            return redirect()->to(base_url('/profile'));
        }
        else{
            return 'login gagal boi';
        }

    }

    private function createSession($emailLogin)
    {
        $data = [
            'Email' => $emailLogin,
        ];
        session()->set($data);
        return true;
    }
    public function logout(){
        session()->destroy();
        return redirect()->to(base_url('/login'));
    }
}