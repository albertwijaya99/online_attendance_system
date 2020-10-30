<?php namespace App\Controllers;
use App\Models\CheckTimeModel;
class HomeController extends BaseController
{
	public function index()
	{
	    if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
	    //initialize model and helper
        $CheckTimeModel = new CheckTimeModel;
        $isAlreadyTapIn = $CheckTimeModel->isAlreadyTappingIn(session()->get('Email'));
        $isAlreadyTapIn ? $data['buttonTitle'] = "CHECK-OUT" : $data['buttonTitle'] = "CHECK-IN";
        $isAlreadyTapOut = $CheckTimeModel->isAlreadyTappingOut(session()->get('Email'));
        $data['disableButton'] = $isAlreadyTapOut;
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
}

