<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
		$data = [];
		return view('dashboard', $data);
    }
	public function employee_dashboard()
	{
		$data = [];
		return view('employee', $data);
	}
	public function client_dashboard()
	{
		$data = [];
		return view('client', $data);
	}
}
