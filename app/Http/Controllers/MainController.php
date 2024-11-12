<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MainController extends Controller
{

   public function __construct(){
    $this->middleware('auth');
   }

    public function RenderDashboard(): View
    {
        return view('Pages/dashboard');
    }
}
