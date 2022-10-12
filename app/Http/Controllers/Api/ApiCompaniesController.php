<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;

class ApiCompaniesController extends Controller
{
    /**
     * Return the contents of Company table in tabular form
     *
     */
    public function getCompaniesTabular()
    {
        $companies = Company::with('prefecture')->orderBy('id', 'desc')->get();
        return response()->json($companies);
    }
}
