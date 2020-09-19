<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use CodeIgniter\Controller;
use mysql_xdevapi\Exception;

class ProfileController extends Controller
{

    public function index()
    {
        //intialize model and helper
        $EmployeeModel = new EmployeeModel();
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['Employee'] = $EmployeeModel->getSelectedEmployee(session()->get('Email')); //contains logged in user data

        return view('pages/Profile', $data);
    }
    public function changeProfilePicture(){
        //intialize model and helper
        helper(['form', 'url']);
        $EmployeeModel = new EmployeeModel();

        //validation check of uploaded files
        $isValid = $this->validate([
            'newProfilePicture' => [
                'uploaded[newProfilePicture]',
                'max_size[newProfilePicture,4096]', //max file 4mb
                'mime_in[newProfilePicture,image/png,image/jpg,image/jpeg]', //only jpg,jpeg,png file allowed
            ]
        ]);

        if($isValid){
            try{
                $newProfilePicture = $this->request->getFile('newProfilePicture');
                $newProfilePicture->move( './Uploads/ProfilePicture/'.session()->get('Email').'/',$newProfilePicture->getName(),true);
                $EmployeeModel->changeEmployeeImageUrl($newProfilePicture->getName());
                return redirect()->to(base_url('/profile'));
            }
            catch (Exception $e){
                //add error msg here, after ui done
                return redirect()->to(base_url('/profile'));
            }

        }
        else{
            //add error msg here, after ui done
            dd('error boi');
            return redirect()->to(base_url('/profile'));
        }
    }
}