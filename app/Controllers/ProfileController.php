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
        helper(['form', 'url','security']);
        $EmployeeModel = new EmployeeModel();

        //validation check of uploaded files
        $isValid = $this->validate([
            'newProfilePicture' => [
                'uploaded[newProfilePicture]',
                'max_size[newProfilePicture,4096]', //max file 4mb
                'mime_in[newProfilePicture,image/jpg,image/png,image/jpeg]', //only jpg,jpeg,png file allowed
            ]
        ]);

        if($isValid){
            try{
                $newProfilePicture = $this->request->getFile('newProfilePicture');
                $hashedEmail = md5(session()->get('Email'));
                $hashedPictureNameType = $hashedEmail.'.'.$newProfilePicture->getExtension();
                $newProfilePicture->move( './Uploads/ProfilePicture/'.$hashedEmail.'/',$hashedPictureNameType,true);
                $EmployeeModel->changeEmployeeImageUrl($hashedPictureNameType);
                return redirect()->to(base_url('/profile'));
            }
            catch (Exception $e){
                //add error msg here, after ui done
                $ProfileErrorMsg = "Something goes wrong.";
                session()->setFlashdata('error_msg',$ProfileErrorMsg);
                return redirect()->to(base_url('/profile'));
            }

        }
        else{
            //add error msg here, after ui done
            $ProfileErrorMsg = "Filetype are not allowed.";
            session()->setFlashdata('error_msg',$ProfileErrorMsg);
            return redirect()->to(base_url('/profile'));
        }
    }
}