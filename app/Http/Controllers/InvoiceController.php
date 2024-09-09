<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Counter;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function getAllInvoice()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices
        ]);
    }

    public function getSearchInvoice(Request $request)
    {
        $search = $request->get('s');

        if ($search != null) {
            $invoices = Invoice::with('customer')
                ->where('id', 'LIKE', '%' . $search . '%')
                ->orWhereHas('customer', function($query) use ($search) {
                    $query->where('first_name', 'LIKE', '%' . $search . '%')
                          ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        
                })
                ->get();

            return response()->json([
                'invoices' => $invoices
            ], 200);
        } else {
            return $this->getAllInvoice();
        }
    }

    public function createInvoice(Request $request)
    {
        $counters = Counters::where('key', 'invoices')->first();
        $invoice = Invoice::orderBy('id', 'DESC')->first();

        $invoiceId = $invoice ? $invoice->id + 1 : 1;
        $countersValue = $counters->value + $invoiceId;

        $formData = [
            'number' => $counters->prefix . $countersValue,
            'customer_id' => null,
            'customer' => null,
            'date' => now()->format('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'term_and_conditions' => 'Default Term and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1,
                ]
            ]
        ];

        return response()->json($formData);
    }
}
