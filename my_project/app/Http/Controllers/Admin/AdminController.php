<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Section;
use App\Models\Task;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'sections' => Section::count(),
            'tasks'    => Task::count(),
            'users'    => User::count(),
        ]);
    }
}
