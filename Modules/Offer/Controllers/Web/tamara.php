<?php

namespace Modules\Offer\Controllers\Web;
use App\Http\Controllers\Controller;
use Session;

class tamara extends Controller
{
  
    /**
     * call tamara api.
     * 
     * @param int $reference
     * @param float $amount
     * @param string $Productname
     * @param string $UserName
     * @param string $UserEmail
     * @param int $UserPhone
     * @param string $UserEmail
     * @param string $Branche
     * @param string $redirectUrl
     * @param string $FailedUrl
     * @param string $Branche
     *
     * @return Json
     */

    public function callTamara($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl)
    {

        $curl = curl_init();
        $lang = Session::get('locale') ?? 'ar';

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.tamara.co/checkout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "order_reference_id": '.$reference.',
        "order_number": "A'.$reference.'",
        "total_amount": {
            "amount": '.$amount.',
            "currency": "SAR"
        },
        "description": "'.$Productname.'",
        "country_code": "SA",
        "payment_type": "PAY_BY_INSTALMENTS",
        "instalments": null,
        "locale": "'.$lang.'",
        "items": [
            {
            "reference_id": '.$reference.',
            "type": "Digital",
            "name": "'.$Productname.'",
            "sku": "SA-'.$reference.'",
            "image_url": "https://www.example.com/product.jpg",
            "quantity": 1,
            "unit_price": {
                "amount": '.$amount.',
                "currency": "SAR"
            },
            "discount_amount": {
                "amount": "00.00",
                "currency": "SAR"
            },
            "tax_amount": {
                "amount": "00.00",
                "currency": "SAR"
            },
            "total_amount": {
                "amount": '.$amount.',
                "currency": "SAR"
            }
            }
        ],
        "consumer": {
            "first_name": "'.$UserName.'",
            "last_name": "N/A",
            "phone_number": "'.$UserPhone.'",
            "email": "'.$UserEmail.'"
        },
        "billing_address": {
            "first_name": "'.$UserName.'",
            "last_name": "N/A",
            "line1": "'.$Branche.'",
            "line2": "N/A",
            "region": "N/A",
            "postal_code": "N/A",
            "city": "'.$Branche.'",
            "country_code": "SA",
            "phone_number":  "'.$UserPhone.'"
        },
        "shipping_address": {
            "first_name": "'.$UserName.'",
            "last_name": "N/A",
            "line1": "'.$Branche.'",
            "line2": "N/A",
            "region": "N/A",
            "postal_code": "N/A",
            "city": "'.$Branche.'",
            "country_code": "SA",
            "phone_number":  "'.$UserPhone.'"
        },
        "discount": {
            "name": "Christmas 2020",
            "amount": {
            "amount": "00.00",
            "currency": "SAR"
            }
        },
        "tax_amount": {
            "amount": "00.00",
            "currency": "SAR"
        },
        "shipping_amount": {
            "amount": "00.00",
            "currency": "SAR"
        },
        "merchant_url": {
            "success": "'.$returnUrl.'",
            "failure": "'.$FailedUrl.'",
            "cancel": "'.$FailedUrl.'",
            "notification": "'.$returnUrl.'"
        },
        "platform": "Magento",
        "is_mobile": false,
        "risk_assessment": {
            "customer_age": 22,
            "customer_dob": "31-01-2000",
            "customer_gender": "Male",
            "customer_nationality": "SA",
            "is_premium_customer": true,
            "is_existing_customer": true,
            "is_guest_user": true,
            "account_creation_date": "31-01-2019",
            "platform_account_creation_date": "string",
            "date_of_first_transaction": "31-01-2019",
            "is_card_on_file": true,
            "is_COD_customer": true,
            "has_delivered_order": true,
            "is_phone_verified": true,
            "is_fraudulent_customer": true,
            "total_ltv": 501.5,
            "total_order_count": 12,
            "order_amount_last3months": 301.5,
            "order_count_last3months": 2,
            "last_order_date": "31-01-2021",
            "last_order_amount": 301.5,
            "reward_program_enrolled": true,
            "reward_program_points": 300
        },
        "expires_in_minutes": 0,
        "additional_data": {
            "delivery_method": "home delivery",
            "pickup_store": "Store A"
        }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhY2NvdW50SWQiOiJiNjliNzAzYi1lZWVhLTQ3OWItOTUwYS1mMDllNTJjMWZkODUiLCJ0eXBlIjoibWVyY2hhbnQiLCJzYWx0IjoiZWQwODg1NDczNGVhNTBjYzAzNmU0Mjg5M2IwZTJkNWEiLCJpYXQiOjE2Njg5NDk2NTUsImlzcyI6IlRhbWFyYSBQUCJ9.M8GwxX3H3rf-Q2o4Mc1t91CMUb220aOHv5P9c1eYRiciSti_OVGiVfCthgDZObpW7q14H2w3c75q51WufuUzjY08NS5vZmgmZCY9252vV4ooLumFiqS1icYAouERk8QfjCO0yn7JF_Z_s-ZJqi4ED5-zY836bFkQ_y6D7blJfh4AbWJIknihXJ9hfZVlYEFPPft6SwyFU4a-iYigocHl2dZI1mkv7owGvKdrGwYfZ6fUlRmVK0t4sL3aHa35k5MBZCuhGQu4Ty35oWmPvKfQTpijjxaRJWAwuBE4ZSbmVKydosRJe97hOLBfuGc0rF_YqjHr6o8fdq_kxaEuaMRvxg',
            'Content-Type: application/json'
        ),
        ));
       
        $response = curl_exec($curl);
        
        $response = json_decode($response,true);
        
        curl_close($curl);

        return $response ;
    }

    /**
     * call change statusOrderTamara api.
     * 
     * @param string $orderId
     *
     * @return Json
     */

    public function statusOrderTamara($orderId)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.tamara.co/orders/'.$orderId.'/authorise',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhY2NvdW50SWQiOiJiNjliNzAzYi1lZWVhLTQ3OWItOTUwYS1mMDllNTJjMWZkODUiLCJ0eXBlIjoibWVyY2hhbnQiLCJzYWx0IjoiZWQwODg1NDczNGVhNTBjYzAzNmU0Mjg5M2IwZTJkNWEiLCJpYXQiOjE2Njg5NDk2NTUsImlzcyI6IlRhbWFyYSBQUCJ9.M8GwxX3H3rf-Q2o4Mc1t91CMUb220aOHv5P9c1eYRiciSti_OVGiVfCthgDZObpW7q14H2w3c75q51WufuUzjY08NS5vZmgmZCY9252vV4ooLumFiqS1icYAouERk8QfjCO0yn7JF_Z_s-ZJqi4ED5-zY836bFkQ_y6D7blJfh4AbWJIknihXJ9hfZVlYEFPPft6SwyFU4a-iYigocHl2dZI1mkv7owGvKdrGwYfZ6fUlRmVK0t4sL3aHa35k5MBZCuhGQu4Ty35oWmPvKfQTpijjxaRJWAwuBE4ZSbmVKydosRJe97hOLBfuGc0rF_YqjHr6o8fdq_kxaEuaMRvxg',
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response,true);
        curl_close($curl);

    }
}
