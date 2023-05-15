<?php

namespace Modules\Offer\Controllers\Web;

use App\Http\Controllers\Controller;
use Session;

class payFort extends Controller
{
    /**
     * request Paramters to payFort.
     *
     * @param $booking
     * @param $price
     * @param $OfferName
     * @param $returnUrl
     *
     * @return array
     */
    public function paymentrequestParams($booking, $price, $OfferName, $installment,$returnUrl)
    {
        if($installment == true){

            return [
                'installments' => 'STANDALONE',
                'command' => 'PURCHASE',
                'access_code' => env('PAYFORT_ACCESS_CODE'),
                'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER'),
                'merchant_reference' => $booking->order_reference,
                'amount' => $price * 100,
                'currency' => env('PAYFORT_CURRENCY'),
                'language' => Session::get('locale') ?? 'ar',
                'customer_email' => $booking->email ?? 'test@test.com',
                'signature' => $this->generatesignatureCode($booking->order_reference,$price * 100, $booking->email ?? 'test@test.com', $OfferName , $installment),
                'order_description' => $OfferName,
                'return_url' => $returnUrl,
            ];

        } else {

            return [
                'command' => 'PURCHASE',
                'access_code' => env('PAYFORT_ACCESS_CODE'),
                'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER'),
                'merchant_reference' => $booking->order_reference,
                'amount' => $price * 100,
                'currency' => env('PAYFORT_CURRENCY'),
                'language' => Session::get('locale') ?? 'ar',
                'customer_email' => $booking->email ?? 'test@test.com',
                'signature' => $this->generatesignatureCode($booking->order_reference,$price * 100, $booking->email ?? 'test@test.com', $OfferName , $installment),
                'order_description' => $OfferName,
                'return_url' => $returnUrl,
            ];
        }
        
    }
     /**
     * generate signatureCode to payFort.
     *
     * @param int $reference
     * @param float $price
     * @param string $email
     * @param string $name
     *
     * @return string
     */
    public function generatesignatureCode($reference, $price, $email, $name, $installment)
    {
        $shaString  = '';
        // array request
        if($installment == true){
            $arrData    = array(
            'installments'        => 'STANDALONE',
            'command'             => 'PURCHASE',
            'access_code'         => env('PAYFORT_ACCESS_CODE'),
            'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER'),
            'merchant_reference'  => $reference,
            'amount'              => $price,
            'currency'            => env('PAYFORT_CURRENCY'),
            'language'            => Session::get('locale') ?? 'ar',
            'customer_email'      => $email,
            'order_description'   => $name,
            'return_url'          => route('web.bookings.thanks'),
            );

        } else {
            $arrData    = array(
            'command'             => 'PURCHASE',
            'access_code'         => env('PAYFORT_ACCESS_CODE'),
            'merchant_identifier' => env('PAYFORT_MERCHANT_IDENTIFIER'),
            'merchant_reference'  => $reference,
            'amount'              => $price,
            'currency'            => env('PAYFORT_CURRENCY'),
            'language'            => Session::get('locale') ?? 'ar',
            'customer_email'      => $email,
            'order_description'   => $name,
            'return_url'          => route('web.bookings.thanks'),
            );
        }
        // sort an array by key
        ksort($arrData);
        foreach ($arrData as $key => $value) {
            $shaString .= "$key=$value";
        }

        // make sure to fill your sha request pass phrase
        $shaString = env('PAYFORT_SHA_REQUEST_PHRASE') . $shaString . env('PAYFORT_SHA_REQUEST_PHRASE');
        $signature = hash('SHA256', $shaString);

        return $signature;
    }
}
