<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMediaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $media = $user->getMedia('uploads');

        return view('admin.media.index', compact('media'));
    }

    public function store(StoreMediaRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user
            ->addMediaFromRequest('file')
            ->toMediaCollection('uploads');

        return back()->with('success', 'File uploaded successfully.');
    }
}
