<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

 public function index()
  {
     try
      {
         return view('admin.home.index');
      }
     catch (\Exception $e)
      {

      }
  }
}
