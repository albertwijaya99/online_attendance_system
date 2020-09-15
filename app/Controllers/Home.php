<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
	    $db = \Config\Database::connect();aasd
        if ($db->query("SELECT 1 AS one")) {
            echo "a";
        } else {
            echo "b";
        }

		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
