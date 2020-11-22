<?php namespace App\Models;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employee';
    protected $primaryKey = 'employee_email';
    protected $allowedFields = ['employee_name', 'employee_point','password','employee_paid_leave','division_id','position','image_url_path','remaining_leave'];

    public function getAllEmployee(){
        //get all employee data
        return $this->findAll();
    }
    public function getAllEmployeeWithStringDivision(){
        $db         =   \Config\Database::connect();
        $query = $db->query('select e.*,d.division_name from employee as e,division as d where d.division_id = e.division_id');
        return $query->getResultArray();
    }

    public function getSelectedEmployee($employee_email){
        $Division = new \App\Models\DivisionModel();
        //get employee data with selected email
        $selectedEmployee = $this->find($employee_email);
        $employeeDivision = $Division->getSelectedDivisionName($selectedEmployee['division_id']);
        //trim some data like password,etc
        $data[0] = [
            'employeeEmail'     => $selectedEmployee['employee_email'],
            'employeeName'      => $selectedEmployee['employee_name'],
            'division'          => $employeeDivision['division_name'],
            'employeeImageUrl'  => $selectedEmployee['image_url_path']
        ];
        return $data;
    }

    public function getRemainingLeave($employee_email){
        //get employee data with selected email
        $selectedEmployee = $this->find($employee_email);
        return $selectedEmployee['remaining_leave'];
    }

    public function loginCheck($loginEmail,$loginPassword){
        //if login info and db matched, value of count all result will be 1
        $suspectedEmployee = $this->where('employee_email',$loginEmail)->first();
        if(!empty($suspectedEmployee) && $loginPassword === $suspectedEmployee['password'])
        {
            return "berhasil";
        }
        else {
            return "gagal";
        }
    }

    public function changeEmployeeImageUrl($newProfilePictureName){
        $data = [
            'image_url_path'    => $newProfilePictureName
        ];
        $this->update(session()->get('Email'),$data);
    }

    public function isAdmin($employee_email){
        $selectedEmployee = $this->find($employee_email);
        return $selectedEmployee['is_admin'];
    }

    public function cutRemainingLeave($minus){
        $remainingLeave = $this->getRemainingLeave(session()->get('Email'));
        $remainingLeave -= $minus;
        $data = [
            'remaining_leave' => $remainingLeave
        ];
        $this->update(session()->get('Email'),$data);

    }

}