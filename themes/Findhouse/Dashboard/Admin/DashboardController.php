<?php
namespace Themes\Findhouse\Dashboard\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Booking\Models\Booking;
use Themes\Findhouse\Property\Models\Property;
use Modules\Review\Models\Review;
use Modules\User\Models\UserWishList;

class DashboardController extends AdminController
{
    public function index()
    {
        $f = strtotime('monday this week');
        $data = [
            'top_cards'          => $this->getTopCardsReport(),
        ];
        return view('Dashboard::index', $data);
    }

    public static function getTopCardsReport()
    {
        $total_properties = Property::count();
        $total_views     = Property::sum('view');
        $total_favorites     = UserWishList::count();
        $total_reviews   = Review::join("bravo_properties","bravo_properties.id","bravo_review.object_id")->where("bravo_review.object_model","'property'")->count();
        $res = [];
        $total_service = 0;
        $services = get_bookable_services();
        if(!empty($services))
        {
            foreach ($services as $service){
                $total_service += $service::where('status', 'publish')->count('id');
            }
        }
        $res[] = [
            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Properties"),
            'amount' => $total_properties,
            'desc'   => __("All Properties"),
            'class'  => 'purple',
            'icon'   => 'icon ion-ios-cart'
        ];
        $res[] = [
            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Views"),
            'amount' => $total_views,
            'desc'   => __("Total Views"),
            'class'  => 'pink',
            'icon'   => 'icon ion-ios-eye'
        ];
        $res[] = [

            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Reviews"),
            'amount' => $total_reviews,
            'desc'   => __("Total Visitor Reviews"),
            'class'  => 'info',
            'icon'   => 'icon ion-ios-document'
        ];
        $res[] = [

            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Favorites"),
            'amount' => $total_favorites,
            'desc'   => __("Total Favorites"),
            'class'  => 'success',
            'icon'   => 'icon ion-ios-heart'
        ];
        return $res;
    }

    public function reloadChart(Request $request)
    {
        $chart = $request->input('chart');
        switch ($chart) {
            case "earning":
                $from = $request->input('from');
                $to = $request->input('to');
                return $this->sendSuccess([
                    'data' => Booking::getDashboardChartData(strtotime($from), strtotime($to))
                ]);
                break;
        }
    }
}
