<?php namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PointModel;
use CodeIgniter\Controller;

class LeaderBoardController extends Controller
{

    public function index()
    {
        //intialize model and helper
        $PointModel = new PointModel();
        if(!session()->get('Email')) return redirect()->to(base_url('/login')); // return to login page
        $data['title'] = "leaderboard";
        $data['points'] = $PointModel->getAllEmployeePoint();
        return view('pages/LeaderBoard',$data);
    }
}
