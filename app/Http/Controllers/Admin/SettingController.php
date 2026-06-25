<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {

            Setting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' => is_bool($value)
                        ? (int) $value
                        : $value,
                ]
            );
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
