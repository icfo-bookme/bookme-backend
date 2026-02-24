<?php

namespace App\Http\Controllers;

use App\Models\BookingOrder;

use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download($orderId)
    { 
      
        $order = BookingOrder::with(['bookingDetails.room.hotel'])
                ->where('orderno', $orderId)
                ->first();

        $pdf = Pdf::loadView('invoice.pdf', ['order' => $order]);

        return $pdf->download("invoice-$orderId.pdf");
    }
}
