<?php

namespace App\Http\Controllers;

use App\Invoice;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Download an invoice with given id.
     *
     * @param int $id
     * @return response
     */
    public function index($id)
    {
        $invoice = app('db')->select("SELECT * FROM invoices where id = $id");
        return response()->download($invoice[0]->file_path);
    }
}
