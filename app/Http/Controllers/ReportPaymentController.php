<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportPaymentController extends Controller
{
    public function getPaymentReport()
    {
        return view('report.payment_report');
    }
}
