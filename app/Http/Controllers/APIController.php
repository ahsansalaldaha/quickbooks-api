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

    public function findCustomer(Request $request)
    {
        $quickbooks = app('QuickBooks');
        $data = $quickbooks->getDataService()->query("SELECT * FROM Customer WHERE Id = '{$request->id}'");
        return response()->json($data);
    }
    public function createCustomer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_name' => '',
            'no_of_employee' => ''
        ]);

        $quickbooks = app('QuickBooks');
        $data = $quickbooks->getDataService()->create('Customer', [
            "FullyQualifiedName" => "King Groceries",
            "PrimaryEmailAddr" => [
                "Address" => "jdrew@myemail.com"
            ],
            "DisplayName" => "King's Groceries",
            "Suffix" => "Jr",
            "Title" => "Mr",
            "MiddleName" => "B",
            "Notes" => "Here are other details.",
            "FamilyName" => "King",
            "PrimaryPhone" => [
                "FreeFormNumber" => "(555) 555-5555"
            ],
            "CompanyName" => "King Groceries",
            "BillAddr" => [
                "CountrySubDivisionCode" => "CA",
                "City" => "Mountain View",
                "PostalCode" => "94042",
                "Line1" => "123 Main Street",
                "Country" => "USA"
            ],
            "GivenName" => "James"
        ]);
    }
    function updateCustomer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'company_name' => '',
            'no_of_employee' => ''
        ]);

        $quickbooks = app('QuickBooks');
        $data = $quickbooks->getDataService()->update('Customer', [
            "FullyQualifiedName" => "King Groceries",
            "PrimaryEmailAddr" => [
                "Address" => "jdrew@myemail.com"
            ],
            "DisplayName" => "King's Groceries",
            "Suffix" => "Jr",
            "Title" => "Mr",
            "MiddleName" => "B",
            "Notes" => "Here are other details.",
            "FamilyName" => "King",
            "PrimaryPhone" => [
                "FreeFormNumber" => "(555) 555-5555"
            ],
            "CompanyName" => "King Groceries",
            "BillAddr" => [
                "CountrySubDivisionCode" => "CA",
                "City" => "Mountain View",
                "PostalCode" => "94042",
                "Line1" => "123 Main Street",
                "Country" => "USA"
            ],
            "GivenName" => "James"
        ]);
    }
}
