<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function articles()
    {
        return view('articles');
    }

    public function purchaseOrder()
    {
        return view('purchaseOrder');
    }

    public function receiptNote()
    {
        return view('receiptNote');
    }

    public function invoice()
    {
        return view('invoice');
    }

    public function quotation()
    {
        return view('quotation');
    }

    public function saleOrder()
    {
        return view('saleOrder');
    }

    public function deliveryNote()
    {
        return view('deliveryNote');
    }

    public function AP()
    {
        return view('AP');
    }

    public function AR()
    {
        return view('AR');
    }

    public function financeMaintenance()
    {
        return view('financeMaintenance');
    }

    public function hoursManagement()
    {
        return view('hoursManagement');
    }

    public function employees()
    {
        return view('employees');
    }

    public function managementMaintenance()
    {
        return view('managementMaintenance');
    }

    public function hmReport()
    {
        return view('hmReport');
    }

    public function empReport()
    {
        return view('empReport');
    }
    
    public function quoReport()
    {
        return view('quoReport');
    }

    public function SOReport()
    {
        return view('SOReport');
    }

    public function delNoteReport()
    {
        return view('delNoteReport');
    }

    public function billReport()
    {
        return view('billReport');
    }

    public function POReport()
    {
        return view('POReport');
    }

    public function recNoteReport()
    {
        return view('recNoteReport');
    }

    public function invoiceReport()
    {
        return view('invoiceReport');
    }

    public function articleReport()
    {
        return view('articleReport');
    }

    public function APReport()
    {
        return view('APReport');
    }

    public function ARReport()
    {
        return view('ARReport');
    }

    public function customers()
    {
        return view('customers');
    }

    public function providers()
    {
        return view('providers');
    }
    
    public function provReport()
    {
        return view('provReport');
    }

    public function custReport()
    {
        return view('custReport');
    }
}
