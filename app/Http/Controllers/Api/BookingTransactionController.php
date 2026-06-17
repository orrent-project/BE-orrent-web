<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTransactionRequest;
use App\Models\BookingTransactions;
use App\Http\Resources\Api\BookingTransactionResource;
use App\Http\Resources\Api\ViewBookingResource;
use App\Models\OfficeSpaces;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class BookingTransactionController extends Controller
{

    public function booking_details(Request $request){
        $request->validate([
            'phone_number'=>'required|string',
            'booking_trx_id'=>'required|string',
        ]);

        $booking=BookingTransactions::where('phone_number',$request->phone_number)
        ->where('booking_trx',$request->booking_trx_id)
        ->with(['officeSpace','officeSpace.city'])
        ->first();

        if(!$booking){
            return response()->json(['message'=>'Booking not found'],404);
        }
        return new ViewBookingResource($booking);
    }
    public function store(StoreBookingTransactionRequest $request)
    {
        $validatedData=$request->validated();

        $officeSpace=OfficeSpaces::find($validatedData['office_space_id']);

        $validatedData['is_paid']=false;

        $validatedData['booking_trx']=BookingTransactions::generateUniqueTrxId();
        
        $validatedData['duration']=$officeSpace->duration;

        $validatedData['ended_at']=(new \DateTime($validatedData['started_at']))->modify("+{$officeSpace->duration} days")->format('Y-m-d');

        $bookingTransaction=BookingTransactions::create($validatedData);

        $sid=getenv("TWILIO_ACCOUNT_SID");
        $token=getenv("TWILIO_AUTH_TOKEN");
        $twilio=new Client($sid,$token);

        $messageBody="Hi {$bookingTransaction->name}, Terima kasih telah booking kantor di FirstOffice.\n\n";
        $messageBody .="Pesan kantor {$bookingTransaction->officeSpace->name} Anda sedang kami proses dengan Booking TRXID: {$bookingTransaction->booking_trx_id}.\n\n";
        $messageBody .="Kami akan menginformasikan kembali status pemesanan Anda secepat mungkin";

        $message=$twilio->messages->create(
            "+{$bookingTransaction}->phone_number",
            [
                'from' => getenv("TWILIO_PHONE_NUMBER"),
                'body' => $messageBody
            ]
        );

        $bookingTransaction->load('officeSpace');
        return new BookingTransactionResource($bookingTransaction);
    // return response()->json([
    //     'success' => true,
    //     'message' => 'Booking berhasil dibuat',
    //     'data' => $bookingTransaction
    // ], 201);
        //mengirim notif melalui sms atau whatsapp dengan twillio
    }
}
