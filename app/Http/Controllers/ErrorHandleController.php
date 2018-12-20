<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorHandleController extends Controller
{
	public function e404()
	{
		return view('errors.404');
	}
}
