<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Error;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfigController extends Controller
{
    public function index() {
        return Inertia::render('Auth/Admin/Config/Config');
    }

    public function update(Request $request) {

        $config = Config::first();

        if(!$config) {
            throw new Error('Config not found');
        }

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'school_name' => 'required|string|max:255',
            'activity_type' => 'required|string|max:255',
            'activity_title' => 'required|string|max:255',
            'activity_title_abbreviation' => 'required|string|max:255',
            'exam_date_start' => 'required|string|regex:/^\d{4}-\d{2}-\d{2}$/',
            'exam_date_end' => 'required|string|regex:/^\d{4}-\d{2}-\d{2}$/',
            'holiday_date' => 'nullable|string',
            'exam_time_start' => 'required|string|regex:/^\d{2}:\d{2}:\d{2}$/',
            'exam_time_end' => 'required|string|regex:/^\d{2}:\d{2}:\d{2}$/',
        ]);

        if($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->storeAs('logo', 'logo.png', 'public');
            $config->logo = 'storage/' . $path;
        }

        $config->school_name = $request->school_name;
        $config->activity_type = $request->activity_type;
        $config->activity_title = $request->activity_title;
        $config->activity_title_abbreviation = $request->activity_title_abbreviation;
        $config->exam_date_start = $request->exam_date_start;
        $config->exam_date_end = $request->exam_date_end;
        $config->holiday_date = $request->holiday_date;
        $config->exam_time_start = $request->exam_time_start;
        $config->exam_time_end = $request->exam_time_end;
        $config->save();

        return redirect()->back();
    }
}