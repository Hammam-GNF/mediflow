<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Icd10Code;
use Illuminate\Http\Request;

class Icd10Controller extends Controller
{
    public function search(Request $request)
    {
        $term = $request->q;

        return Icd10Code::query()
            ->active()
            ->when($term, fn($q) => $q->search($term))
            ->limit(20)
            ->get(['id','code','name']);
    }

}
