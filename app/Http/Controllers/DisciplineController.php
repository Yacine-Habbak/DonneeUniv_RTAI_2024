<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function allDiscipline()
    {
        $discipline = Discipline::all();
        return view('disciplines.all', compact('discipline'));
    }
}