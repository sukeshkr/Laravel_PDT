<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        return view('admin.dashboard');
    }
    public function selectBranch()
    {
        $branches = Branch::all();
        return view('welcome',compact('branches'));
    }
    public function postBranch()
    {
        $branch = Branch::find(request()->branch);

        session(['branch'=>$branch]);

        return to_route('dashboard');
    }
}
