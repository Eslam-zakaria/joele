<?php

namespace Modules\Offer\Controllers\Web;

use App\Constants\BookingStatuses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Modules\Booking\Models\Booking;
use Modules\Offer\Controllers\Web\payFort;
use Modules\Offer\Controllers\Web\tabby;
use Modules\Offer\Controllers\Web\tamara;
use Modules\Offer\Repositories\OffersRepository;
use Modules\Branch\Repositories\BranchesRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Booking\Repositories\BookingsRepository;
use Modules\Booking\Http\Requests\BookingStoreRequest;
use Session;

class OfferController extends Controller
{
    private $viewsPath = 'Offer.Resources.views.';

     /**
     * OfferController constructor.
     *
     * @param OffersRepository $offersRepository
     * @param BranchesRepository $branchesRepository
     * @param CategoriesRepository $categoriesRepository
     * @param BookingsRepository $bookingsRepository
     */
    public function __construct(OffersRepository $offersRepository, BranchesRepository $branchesRepository, CategoriesRepository $categoriesRepository , BookingsRepository $bookingsRepository)
    {
        $this->offersRepository = $offersRepository;
        $this->branchesRepository = $branchesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->bookingsRepository = $bookingsRepository;
    }

    public function index()
    {
        $branches = $this->branchesRepository->offersPage();

        return view($this->viewsPath . 'web.index', compact('branches'));
    }

    public function lists($slug,Request $request)
    {
        $branche = $this->branchesRepository->showOffersPage($slug);

        if( !$branche )
            return abort(404);

        //get array of offer_id from branch_offer
        $brancheOffer = DB::table('branch_offer')->where('branch_id',$branche->id)->pluck('offer_id')->toArray();
        $offers = $this->offersRepository->getOffers($brancheOffer,$request->category);

        $categories = $this->categoriesRepository->list('offers',['translation']);

        return view($this->viewsPath . 'web.lists', compact('branche','categories','request','offers'));
    }

    public function bookoffer($slug,$offerId)
    {
        if(!request()->get('step_num')){
            request()->merge([
                'step_num' => 1,
            ]);
        }

        $branche = $this->branchesRepository->showOffersPage($slug);

        $offer   = $this->offersRepository->offerDetails($offerId);

        $ApiKey  = 'pk_test_6f15d3c9-d7c7-414f-83c2-f62aafe67adc';

        return view($this->viewsPath . 'web.book', compact('branche','offer', 'ApiKey'));
    }

    public function checkTabby(BookingStoreRequest $request)
    {
        $offer = $this->offersRepository->find($request->offer_id);

        $branche = $this->branchesRepository->find($request->branch_id);

        if(Session::get('locale') == 'en'){
            $FailedUrl = route('web.bookings.failedTabbyInstallment');
            $returnUrl = route('web.bookings.installment.thanks');
        } else {
            $FailedUrl = route('web.bookings.failedTabbyInstallment');
            $returnUrl = route('web.bookings.installment.thanks');
        }
        $reference     = $this->generateUniqueCode();
        $amount        = (float)$offer->price;
        $Productname   = $offer->name;
        $UserName      = $request->name;
        $UserEmail     = $request->email;
        $UserPhone     = $request->phone;
        $Branche       = $branche->name;

        return $this->CheckTabbyCall($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl,$branche->slug,$offer->id);

    }
    public function store(BookingStoreRequest $request)
    {
        // dd($request->all());

        $offer = $this->offersRepository->find($request->offer_id);

        if( ! $booking = $this->bookingsRepository->create( array_merge($request->validated(), ['order_reference' => $this->generateUniqueCode(), 'type' => 2 ,'price' =>$offer->price])) )
            return redirect()->back()->with('error', __('system.All required data must be entered'))->withInput();

        if($booking->payment_type == "Pay online" || $booking->type_installment == "payFort Installment") {

            $installment = ($booking->type_installment == "payFort Installment") ? true : false ;

            return redirect()->route('web.bookings.payment', app()->getLocale() == 'en' ? ['referal_code' => $booking->order_reference, 'installment' =>$installment,'lang' => Session::get('locale')] : ['referal_code' => $booking->order_reference , 'installment' =>$installment]);

        } elseif($booking->payment_type == "Pay Installment") {

            if($booking->type_installment == "Tamara"){

                if(Session::get('locale') == 'en'){
                    $FailedUrl = route('web.bookings.failedInstallment');
                    $returnUrl = route('web.bookings.installment.thanks');
                } else {
                    $FailedUrl = route('web.bookings.failedInstallment');
                    $returnUrl = route('web.bookings.installment.thanks');
                }
                $reference     = $booking->order_reference;
                $amount        = (float)$booking->price;
                $Productname   = $booking->offer->name;
                $UserName      = $booking->name;
                $UserEmail     = $booking->email;
                $UserPhone     = $booking->phone;
                $Branche       = $booking->branch->name;
                return $this->CheckOutTamara($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl);

            } else {

                if(Session::get('locale') == 'en'){
                    $FailedUrl = route('web.bookings.failedTabbyInstallment');
                    $returnUrl = route('web.bookings.installment.thanks');
                } else {
                    $FailedUrl = route('web.bookings.failedTabbyInstallment');
                    $returnUrl = route('web.bookings.installment.thanks');
                }
                $reference     = $booking->order_reference;
                $amount        = (float)$booking->price;
                $Productname   = $booking->offer->name;
                $UserName      = $booking->name;
                $UserEmail     = $booking->email;
                $UserPhone     = $booking->phone;
                $Branche       = $booking->branch->name;
                return $this->CheckOutTabby($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl);

            }

        } else {

          return redirect()->route('web.offers.index')->with('success', __('system.Your booking has been sent successfully'));

        }
    }

    /**
     * Write referral code on Method
     *
     * @return int
     *
     * @throws \Exception
     */
    public function generateUniqueCode()
    {
        do {

            $referal_code = random_int(100000, 999999);

        } while (Booking::where("order_reference", "=", $referal_code)->first());

        return $referal_code;
    }

    public function payment($code,$installment = null)
    {
        // get book details
        $booking = Booking::where('order_reference', "=", $code)->first();

        // remove any space in offer name
        $replace = ['(' , ')' ,'+'];
        $offerName = str_replace($replace, ' ', $booking->offer->name);

        // call payment class
        $payment = new payFort();
        $requestParams = $payment->paymentrequestParams($booking, $booking->price, $offerName, $installment,route('web.bookings.thanks'));

        // redirect payfort url
        $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';

        // $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';


        return view('Offer.Resources.views.web.payment', ['redirectUrl' => $redirectUrl ,'requestParams' => $requestParams]);
    }

    //==============Installment Tamara================//
    public function CheckOutTamara($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$redirectUrl,$FailedUrl)
    {

        // call tamara class
        $callTamara       = new tamara();
        $datacheckOut     = $callTamara->callTamara($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$redirectUrl,$FailedUrl);
        $urlcheckOut      = $datacheckOut['checkout_url'];

        // update order_reference in Table offer_booking
        $OrderUpdated     = Booking::where('order_reference', "=", $reference)->first();

        if($OrderUpdated){

            $OrderUpdated->order_reference = $datacheckOut['order_id'];
            $OrderUpdated->save();
        }

        return Redirect::to($urlcheckOut);

    }

    //==============Installment Tabby================//
    public function CheckTabbyCall($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl,$branchSlug,$offerId){

        $callTabby        = new tabby();
        $datacheckOut     = $callTabby->callTabby($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl);

        $urlcheckOut      = $datacheckOut['configuration']['available_products']['installments'][0]['web_url'] ?? '';

        if($urlcheckOut){

            return redirect()->route('web.offers.book',['slug'=> $branchSlug , 'offerId'=> $offerId,'tabby_status'=>true ,'step_num'=> 2])->withInput(request()->all());

        } else {

            return redirect()->route('web.offers.book',['slug'=> $branchSlug , 'offerId'=> $offerId,'tabby_status'=>false ,'step_num'=> 2])->withInput(request()->all());
        }
    }

    public function CheckOutTabby($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl){

        // call tabby class
        $callTabby        = new tabby();
        $datacheckOut     = $callTabby->callTabby($reference,$amount,$Productname,$UserName,$UserEmail,$UserPhone,$Branche,$returnUrl,$FailedUrl);
        $OrderId          = $datacheckOut['payment']['id'];

        if($datacheckOut['status'] == 'created'){

               $OrderUpdated = Booking::where('order_reference', "=", $reference)->first();
            if($OrderUpdated){

                $OrderUpdated->order_reference = $OrderId;
                $OrderUpdated->save();
            }

            $urlcheckOut = $datacheckOut['configuration']['available_products']['installments'][0]['web_url'];

            return Redirect::to($urlcheckOut);

        } else {

               $OrderUpdated = Booking::where('order_reference', "=", $reference)->first();
            if($OrderUpdated){

                $OrderUpdated->order_reference = $OrderId;
                $OrderUpdated->save();
            }

            $dataOffer = Booking::orderBy('id','desc')->where('order_reference', "=", $OrderId)->first();
            $dataOffer->status = BookingStatuses::NOT_CONFIRMED;
            $dataOffer->note  = ' فشل فى عملية التقسيط ';
            $dataOffer->save();

            return redirect()->route('web.offers.installment', ['payment_id' => $OrderId]);
        }
    }

    //============CallRetrievePaymentTabby============
    public function CallRetrievePaymentTabby($PaymentID)
    {
        // call tabby class
        $callTabby   = new tabby();
        $Amount      = $callTabby->callRetrieveTabby($PaymentID);

        return $this->CallCapturePaymentTabby($PaymentID,$Amount);

    }
    //============CallCapturePaymentTabby============
    public function CallCapturePaymentTabby($PaymentID,$Amount)
    {
        // call tabby class
        $callTabby     = new tabby();
        $responseData  = $callTabby->callCaptureTabby($PaymentID,$Amount);

        return view($this->viewsPath . 'web.thanksinstallment');

    }

     //============ChangeStatusOrderTamara============
     public function ChangeStatusOrderTamara($orderId){

        // call tamara class & call function statusOrderTamara
        $callTamara       = new tamara();
        $changeStatus     = $callTamara->statusOrderTamara($orderId);

        return view($this->viewsPath . 'web.thanksinstallment');
    }

    //=============ReturnInstallment==============//
    public function failedInstallment(Request $request)
    {
        if($request->orderId){ //Tamara

            $dataOffer = Booking::orderBy('id','desc')->where('order_reference', "=", $request->orderId)->first();
            $dataOffer->status = BookingStatuses::NOT_CONFIRMED;
            $dataOffer->note = ' فشل فى عملية التقسيط '.'-'.$request->paymentStatus;
            $dataOffer->save();

        } else { //Tabby

            $dataOffer = Booking::orderBy('id','desc')->where('order_reference', "=", $request->payment_id)->first();
            $dataOffer->status = BookingStatuses::NOT_CONFIRMED;
            $dataOffer->note = ' فشل فى عملية التقسيط ';
            $dataOffer->save();


        }

        return view($this->viewsPath . 'web.failedinstallment');
    }

    public function failedTabbyInstallment(Request $request)
    {
        if($request->orderId){ //Tamara

            $dataOffer = Booking::orderBy('id','desc')->where('order_reference', "=", $request->orderId)->first();
            $dataOffer->status = BookingStatuses::NOT_CONFIRMED;
            $dataOffer->note = ' فشل فى عملية التقسيط '.'-'.$request->paymentStatus;
            $dataOffer->save();

        } else { //Tabby

            $dataOffer = Booking::orderBy('id','desc')->where('order_reference', "=", $request->payment_id)->first();
            $dataOffer->status = BookingStatuses::NOT_CONFIRMED;
            $dataOffer->note = ' فشل فى عملية التقسيط ';
            $dataOffer->save();

        }

        return view($this->viewsPath . 'web.failedTabbyInstallment');
    }

    public function thanksInstallment(Request $request)
    {

        if($request->payment_id){ //Tabby

            $dataOffer = Booking::where('order_reference',$request->payment_id)->first();

            $dataOffer->status = BookingStatuses::CONFIRMED;
            $dataOffer->note  = 'عملية ناجحة';
            $dataOffer->save();


            return $this->CallRetrievePaymentTabby($request->payment_id);
        } else { //Tamara

            $dataOffer = Booking::where('order_reference',$request->orderId)->first();

            $dataOffer->status = BookingStatuses::CONFIRMED;
            $dataOffer->note  = 'عملية ناجحة';
            $dataOffer->save();

            return $this->ChangeStatusOrderTamara($request->orderId);
        }
    }

    //=============ReturnBook==============//
    public function thanks(Request $request)
    {
        if($request->merchant_reference) {

            $booking = Booking::where('order_reference', "=", $request->merchant_reference)->first();

            if($request->response_message == "Success" || $request->response_message == "عملية ناجحة" || $request->status == "14"){

                $booking->status = BookingStatuses::CONFIRMED;
                $booking->note  = $request->response_message ?? 'عملية ناجحة';
                $booking->save();

            } else {

                $booking->status = BookingStatuses::NOT_CONFIRMED;
                $booking->note  = $request->response_message ?? 'عملية فاشلة';
                $booking->save();
            }
        }

        return view('Offer.Resources.views.web.thanks');
    }
}
