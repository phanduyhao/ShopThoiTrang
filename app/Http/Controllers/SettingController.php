<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // Lấy toàn bộ settings dưới dạng key-value
          $settings = Setting::pluck('value', 'setting_code')->toArray();

          return view('admin.setting.index', compact('settings'),[
            'title' => 'Cấu hình'
          ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'setting_code' => 'required|string|unique:settings,setting_code',
        //     'value' => 'nullable|string',
        // ]);

        Setting::create($request->only(['setting_code', 'value']));

        return redirect()->route('settings.index')->with('success', 'Tạo setting thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAjax(Request $request)
    {
        $request->validate([
            'setting_code' => 'required|string',
            'value' => 'nullable|string'
        ]);
    
        $setting = Setting::updateOrCreate(
            ['setting_code' => $request->setting_code], 
            ['value' => $request->value]
        );
    
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!',
            'setting' => $setting
        ]);
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
