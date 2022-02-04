<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Invoice;
use Illuminate\Support\Facades\Log;

class InvoiceAPIController extends Controller
{

    public function __construct()
    {
        $this->qb = app('QuickBooks');
        $this->qbDataService = $this->qb->getDataService();
    }
    public function index()
    {
        $data = $this->qbDataService->query("SELECT * FROM Invoice ");
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    public function show($id)
    {
        $data = $this->qbDataService->query("SELECT * FROM Invoice WHERE Id = '{$id}'");

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'Line' => 'required',
            'Line.*.Amount' => 'required',
            'Line.*.DetailType' => 'required',
            'Line.*.SalesItemLineDetail' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef.value' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef.name' => 'required',
            'CustomerRef' => 'required',
            'CustomerRef.value' => 'required'
        ]);

        $invoice = Invoice::create($request->toArray());
        $data = $this->qbDataService->Add($invoice);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }


    function update(Request $request, $id)
    {
        $this->validate($request, [
            'Line' => 'required',
            'Line.*.Amount' => 'required',
            'Line.*.Id' => 'required',
            'Line.*.DetailType' => 'required',
            'Line.*.SalesItemLineDetail' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef.value' => 'required',
            'Line.*.SalesItemLineDetail.ItemRef.name' => 'required',
            'CustomerRef' => 'required',
            'CustomerRef.value' => 'required'
        ]);
        $invoice = $this->qbDataService->FindbyId('invoice', $id);
        $invoiceProperties = Invoice::update($invoice, $request->toArray());
        $data = $this->qbDataService->Update($invoiceProperties);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    function delete($id)
    {
        $invoice = $this->qbDataService->FindbyId('invoice', $id);
        $data = $this->qbDataService->Delete($invoice);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }
}
