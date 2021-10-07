<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DynamicController extends Controller
{
    public function index() {
        return view('top');
    }
    
    public function seek_project() {
        return view('seek_project');
    }
    public function make_project() {
        return view('make_project');
    }
    public function project_list() {
        return view('project_list');
    }
}
