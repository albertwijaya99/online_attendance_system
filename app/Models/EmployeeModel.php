<?php namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employee';
    protected $primaryKey = 'employee_email';
    protected $allowedFields = ['employee_name', 'employee_point','password','employee_paid_leave','division_id','position','image_url_path'];

    public function getAllEmployee(){
        //get all employee data
        return $this->findAll();
    }
    public function getSelectedEmployee($employee_email){
        //get employee data with selected email
        return $this->find($employee_email);
    }
    public function loginCheck($loginEmail,$loginPassword){
        //if login info and db matched, value of count all result will be 1
        if($this->where('employee_email',$loginEmail)->where('password',$loginPassword)->countAllResults() > 0){
            return "berhasil";
        }
        else{
            return "gagal";
        }
    }
}