<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QuickBooksOnline\API\Facades\Payment;
use Illuminate\Support\Facades\Log;

class PaymentAPIController extends Controller
{

    public function __construct()
    {
        $this->qb = app('QuickBooks');
        $this->qbDataService = $this->qb->getDataService();
    }
    public function index()
    {
        $data = $this->qbDataService->query("SELECT * FROM Payment ");
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    public function show($id)
    {
        $data = $this->qbDataService->query("SELECT * FROM Payment WHERE Id = '{$id}'");

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'TotalAmt' => 'required',
            'Line.*.Amount' => 'required',
            'Line.*.LinkedTxn' => 'required',
            'Line.*.LinkedTxn.*.TxnId' => 'required',
            'Line.*.LinkedTxn.*.TxnType' => 'required',
            'CustomerRef' => 'required',
            'CustomerRef.value' => 'required'
        ]);

        $payment = Payment::create($request->toArray());
        $data = $this->qbDataService->Add($payment);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }


    function update(Request $request, $id)
    {
        $this->validate($request, [
            'TotalAmt' => 'required',
            'Line.*.Amount' => 'required',
            'Line.*.LinkedTxn' => 'required',
            'Line.*.LinkedTxn.*.TxnId' => 'required',
            'Line.*.LinkedTxn.*.TxnType' => 'required',
            'CustomerRef' => 'required',
            'CustomerRef.value' => 'required'
        ]);
        $payment = $this->qbDataService->FindbyId('payment', $id);
        $paymentProperties = Payment::update($payment, $request->toArray());
        $data = $this->qbDataService->Update($paymentProperties);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }

    function delete($id)
    {
        $payment = $this->qbDataService->FindbyId('payment', $id);
        $data = $this->qbDataService->Delete($payment);
        return $this->qb->handleResponse($this->qbDataService, $data);
    }
}
