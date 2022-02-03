<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooks;

class APIController extends Controller
{

    public function companyInfo()
    {
        $quickbooks = app('QuickBooks');
        return response()->json($quickbooks->getDataService()->getCompanyInfo());
    }
}
