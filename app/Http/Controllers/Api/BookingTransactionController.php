<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Models\BookingTransactions;
use App\Models\OfficeSpaces;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    public function store(StoreBookingTransactionRequest $request)
    {
        $validatedData=$request->validated();

        $officeSpace=OfficeSpaces::find($validatedData['office_space_id']);

        $validatedData['is_paid']=false;

        $validatedData['booking_trx']=BookingTransactions::generateUniqueTrxId();
        
        $validatedData['duration']=$officeSpace->duration;

        $validatedData['ended_at']=(new \DateTime($validatedData['started_at']))->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction=BookingTransactions::create($validatedData);

    return response()->json([
        'success' => true,
        'message' => 'Booking berhasil dibuat',
        'data' => $bookingTransaction
    ], 201);
        //mengirim notif melalui sms atau whatsapp dengan twillio
    }
}
