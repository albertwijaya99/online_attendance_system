<?php namespace App\Controllers;
use App\Models\CheckTimeModel;
use App\Models\EmployeeModel;
use CodeIgniter\I18n\Time;
class HomeController extends BaseController
{
	public function index()
	{
	    if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
	    //initialize model and helper
        $CheckTimeModel = new CheckTimeModel;
        $EmployeeModel  = new EmployeeModel;
        $isAlreadyTapIn = $CheckTimeModel->isAlreadyTappingIn(session()->get('Email'));
        $isAlreadyTapIn ? $data['buttonTitle'] = "CHECK-OUT" : $data['buttonTitle'] = "CHECK-IN";
        $data['disableButton'] = $this->isNationalHoliday();
        if(!$data['disableButton']) $data['disableButton'] = $CheckTimeModel->isAlreadyTappingOut(session()->get('Email'));
        $currEmployee = $EmployeeModel->getSelectedEmployee(session()->get('Email'));
        $data['EmployeeName'] = $currEmployee[0]['employeeName'];
        $data['title'] = "home";
		return view('pages/Home',$data);
	}

	public function CheckTappedIn(){
	    //initialize model and helper
        $CheckTimeModel = new CheckTimeModel;
        $message = $CheckTimeModel->tapIn(session()->get('Email'));
        session()->setFlashdata('tapping_msg',$message);
        return redirect()->to(base_url());
	}
	public function isNationalHoliday(){
	    $Time = new Time('now');
	    $ch = curl_init('https://holidays.abstractapi.com/v1/?api_key=acb977094b5c420fadee68a5c12c7617&country=ID&year='.$Time->year.'&month='.$Time->month.'&day='.$Time->day.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        if(date('D',$Time->getTimestamp()) == 'Sun') return false; // sunday checker
        if($data === "[]") return false; //national holiday checker
        return true;

    }
}

