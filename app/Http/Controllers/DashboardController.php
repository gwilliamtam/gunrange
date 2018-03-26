<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
    protected $redirectTo = '/';

    public function index(Request $request)
    {
        $user = Auth::user();

        return view('dashboard', [
            'count' => $user->dashboardCount()
        ]);
    }
}
