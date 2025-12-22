<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;
use App\Models\UserTaskProgress;
class HomeController extends Controller
{
    public function index()
    {
        // Разделы
        $sections = Section::all();

        // Анонимная статистика
        $totalUsers = User::count();
        $totalCompletedTasks = UserTaskProgress::count();

        return view('home', compact('sections', 'totalUsers', 'totalCompletedTasks'));
    }
}
