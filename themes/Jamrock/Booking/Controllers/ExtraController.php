<?php

namespace Themes\Jamrock\Booking\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Booking\Controllers\BookingController;
use Modules\FrontendController;
use Themes\Jamrock\Booking\Models\Booking;
use Themes\Jamrock\Booking\Models\BookingExtra;
use Themes\Jamrock\Booking\Models\Combination;
use Themes\Jamrock\Booking\Models\Extra;

class ExtraController extends BookingController
{

    public function index(Request $request,$code){
        $res = $this->validateCheckout($code);
        if($res !== true) return $res;

        $booking = $this->bookingInst;

        if ( !in_array($booking->status , ['draft','unpaid'])) {
            return redirect('/');
        }

        $is_api = request()->segment(1) == 'api';

        $data = [
            'page_title' => __('Select Extra'),
            'booking'    => $booking,
            'service'    => $booking->service,
            'user'       => Auth::user(),
            'is_api'    =>  $is_api,
            'rows'=>Extra::query()->paginate(50)
        ];
        return view('Booking::frontend.extra', $data);
    }

    public function saveExtra(Request  $request){
        $res = $this->validateCheckout($request->booking_id);
        $booking = $this->bookingInst;

        $combination = Combination::all();
        $price = 0;
        foreach ($combination as $item){
            $diff = array_diff($item->option, $request->items);
            if(!$diff){
                $price = $item->price;
                break;
            }

        }

        BookingExtra::create([
            'booking_id'=>$booking->id,
            'extra_id'=>$request->extra_id,
            'number'=>$request->number,
            'options'=>$request->items,
            'price'=>($price * $request->number)
        ]);

        return true;

    }

    public function store($code){
        $res = $this->validateCheckout($code);

        if($res !== true) return $res;

        $booking = $this->bookingInst;

        if ( !in_array($booking->status , ['draft','unpaid'])) {
            return redirect('/');
        }

        $extra = \request()->input('extra',[]);

        BookingExtra::query()->where('booking_id',$booking->id)->delete();

        $t = 0;
        foreach ($extra as $id=>$number){
            if($number < 1) continue;

            $row = Extra::find($id);
            if($row){

                BookingExtra::create([
                    'booking_id'=>$booking->id,
                    'extra_id'=>$id,
                    'number'=>$number,
                    'price'=>$row->price
                ]);
                $t+= $number * $row->price;
            }
        }
        $booking->total = $booking->getMeta('tmp_total') + $t;
        $booking->save();

        return redirect($booking->getCheckoutUrl());
    }

    public function test(){
        User::query()->update([
            'stripe_customer_id'=>null
        ]);
    }


    public function remove($id){
        $extra =   BookingExtra::find($id);
        if($extra){
            $price = $extra->price;
            $booking = Booking::find($extra->booking_id);
            if($booking){
                $booking->total = ($booking->total - $price);
                $booking->save();
            }
            $extra->delete();
        }
        return 'success';
    }

    public function getCombination(Request $request){
        $combination = Combination::all();
        $price = 0;
        foreach ($combination as $item){

            $diff = array_diff($item->option, $request->items);
            if(!$diff){
                $price = $item->price;
                break;
            }

        }
        return $price;
    }
}
