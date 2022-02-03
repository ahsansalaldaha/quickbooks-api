<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooks;
use QuickBooksOnline\API\Facades\Customer;

class CustomerAPIController extends Controller
{

    public function index(Request $request)
    {
        $quickbooks = app('QuickBooks');
        $data = $quickbooks->getDataService()->query("SELECT * FROM Customer ");
        return response()->json($data);
    }

    public function show($id)
    {
        $quickbooks = app('QuickBooks');
        $data = $quickbooks->getDataService()->query("SELECT * FROM Customer WHERE Id = '{$id}'");
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'email' => 'required|email',
            // 'phone' => 'required',
            // 'company_name' => '',
            // 'no_of_employee' => ''
        ]);

        $quickbooks = app('QuickBooks');
        $customer = Customer::create([
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
        $data = $quickbooks->getDataService()->Add($customer);
        return response()->json($data);
    }


    function update(Request $request)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'email' => 'required|email',
            // 'phone' => 'required',
            // 'company_name' => '',
            // 'no_of_employee' => ''
        ]);

        $quickbooks = app('QuickBooks');
        $customer = Customer::create([
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
        $data = $quickbooks->getDataService()->Update($customer);
        return response()->json($data);
    }

    function delete(Request $request)
    {
        $this->validate($request, [
            // 'name' => 'required',
            // 'email' => 'required|email',
            // 'phone' => 'required',
            // 'company_name' => '',
            // 'no_of_employee' => ''
        ]);

        $quickbooks = app('QuickBooks');
        $customer = Customer::create([
            "GivenName" => "James"
        ]);
        $data = $quickbooks->getDataService()->Delete($customer);
        return response()->json($data);
    }
}
