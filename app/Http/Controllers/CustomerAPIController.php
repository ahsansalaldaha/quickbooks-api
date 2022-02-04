<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Customer;
use Illuminate\Support\Facades\Log;

class CustomerAPIController extends Controller
{

    public function __construct()
    {
        $this->qb = app('QuickBooks');
        $this->qbDataService = $this->qb->getDataService();
    }
    public function index()
    {
        $data = $this->qbDataService->query("SELECT * FROM Customer ");
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    public function show($id)
    {
        $data = $this->qbDataService->query("SELECT * FROM Customer WHERE Id = '{$id}'");

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'DisplayName' => 'required',
            'Notes' => 'required',
            'BillAddr' => 'required',
            'BillAddr.CountrySubDivisionCode' => 'required',
            'BillAddr.City' => 'required',
            'BillAddr.PostalCode' => 'required',
            'BillAddr.Line1' => 'required',
            'BillAddr.Country' => 'required',
            'PrimaryPhone' => 'required',
            'PrimaryPhone.FreeFormNumber' => 'required',
            'PrimaryEmailAddr' => 'required',
            'PrimaryEmailAddr.Address' => 'required|email'
        ]);

        $customer = Customer::create($request->toArray());
        $data = $this->qbDataService->Add($customer);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }


    function update(Request $request, $id)
    {
        $this->validate($request, [
            'DisplayName' => '',
            'Notes' => '',
            'BillAddr' => '',
            'BillAddr.CountrySubDivisionCode' => '',
            'BillAddr.City' => '',
            'BillAddr.PostalCode' => '',
            'BillAddr.Line1' => '',
            'BillAddr.Country' => '',
            'PrimaryPhone' => '',
            'PrimaryPhone.FreeFormNumber' => '',
            'PrimaryEmailAddr' => '',
            'PrimaryEmailAddr.Address' => 'email'
        ]);
        $customer = $this->qbDataService->FindbyId('customer', $id);
        $customerProperties = Customer::update($customer, $request->toArray());
        $data = $this->qbDataService->Update($customerProperties);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    function delete($id)
    {
        $customer = $this->qbDataService->FindbyId('customer', $id);
        $customerProperties = Customer::update($customer, [
            "Active" => false
        ]);
        $data = $this->qbDataService->Update($customerProperties);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }
}
