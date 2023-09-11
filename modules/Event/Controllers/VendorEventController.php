<?php
namespace Modules\Event\Controllers;

use App\Notifications\AdminChannelServices;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventTerm;
use Modules\Event\Models\EventTranslation;
use Modules\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Location\Models\Location;
use Modules\Core\Models\Attributes;
use Modules\Booking\Models\Booking;
use Modules\Location\Models\LocationCategory;
use Modules\User\Models\Plan;

class VendorEventController extends FrontendController
{
    protected $eventClass;
    protected $eventTranslationClass;
    protected $eventTermClass;
    protected $attributesClass;
    protected $locationClass;
    protected $bookingClass;
    /**
     * @var string
     */
    private $locationCategoryClass;

    public function __construct()
    {
        parent::__construct();
        $this->eventClass = Event::class;
        $this->eventTranslationClass = EventTranslation::class;
        $this->eventTermClass = EventTerm::class;
        $this->attributesClass = Attributes::class;
        $this->locationClass = Location::class;
        $this->locationCategoryClass = LocationCategory::class;
        $this->bookingClass = Booking::class;
    }

    public function callAction($method, $parameters)
    {
        if(!Event::isEnable())
        {
            return redirect('/');
        }
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }
    public function indexEvent(Request $request)
    {
        $this->checkPermission('event_view');
        $user_id = Auth::id();
        $list_tour = $this->eventClass::where("create_user", $user_id)->orderBy('id', 'desc');
        $data = [
            'rows' => $list_tour->paginate(5),
            'breadcrumbs'        => [
                [
                    'name' => __('Manage Events'),
                    'url'  => route('event.vendor.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Manage Events"),
        ];
        return view('Event::frontend.vendorEvent.index', $data);
    }

    public function recovery(Request $request)
    {
        $this->checkPermission('event_view');
        $user_id = Auth::id();
        $list_tour = $this->eventClass::onlyTrashed()->where("create_user", $user_id)->orderBy('id', 'desc');
        $data = [
            'rows' => $list_tour->paginate(5),
            'recovery'           => 1,
            'breadcrumbs'        => [
                [
                    'name' => __('Manage Events'),
                    'url'  => route('event.vendor.index')
                ],
                [
                    'name'  => __('Recovery'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Recovery Events"),
        ];
        return view('Event::frontend.vendorEvent.index', $data);
    }

    public function restore($id)
    {
        $this->checkPermission('event_delete');
        $user_id = Auth::id();
        $query = $this->eventClass::onlyTrashed()->where("create_user", $user_id)->where("id", $id)->first();
        if(!empty($query)){
            $query->restore();
        }
        return redirect(route('event.vendor.recovery'))->with('success', __('Restore event success!'));
    }

    public function createEvent(Request $request)
    {
        $this->checkPermission('event_create');
        $row = new $this->eventClass();
        $data = [
            'row'           => $row,
            'translation' => new $this->eventTranslationClass(),
            'event_location' => $this->locationClass::where("status","publish")->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where('status', 'publish')->get(),
            'attributes'    => $this->attributesClass::where('service', 'event')->get(),
            'breadcrumbs'        => [
                [
                    'name' => __('Manage Events'),
                    'url'  => route('event.vendor.index')
                ],
                [
                    'name'  => __('Create'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Create Events"),
        ];
        return view('Event::frontend.vendorEvent.detail', $data);
    }


    public function store( Request $request, $id ){
        if($id>0){
            $this->checkPermission('event_update');
            $row = $this->eventClass::find($id);
            if (empty($row)) {
                return redirect(route('event.vendor.index'));
            }

            if($row->create_user != Auth::id() and !$this->hasPermission('event_manage_others'))
            {
                return redirect(route('event.vendor.index'));
            }
        }else{
            $this->checkPermission('event_create');
            $row = new $this->eventClass();
            $row->status = "publish";
            if(setting_item("event_vendor_create_service_must_approved_by_admin", 0)){
                $row->status = "pending";
            }
        }
        $dataKeys = [
            'title',
            'content',
            'price',
            'is_instant',
            'video',
            'faqs',
            'image_id',
            'banner_image_id',
            'gallery',
            'location_id',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
            'duration',
            'start_time',
            'price',
            'sale_price',
            'ticket_types',
            'enable_extra_price',
            'extra_price',
            'is_featured',
            'default_state',
            'enable_service_fee',
            'service_fee',
            'surrounding',
        ];
        if($this->hasPermission('event_manage_others')){
            $dataKeys[] = 'create_user';
        }

        $row->fillByAttr($dataKeys,$request->input());

        if(!auth()->user()->checkUserPlan() and $row->status == "publish") {
            return redirect(route('user.plan'));
        }

        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            if(!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }

            if($id > 0 ){
                event(new UpdatedServiceEvent($row));

                return back()->with('success',  __('Event updated') );
            }else{
                event(new CreatedServicesEvent($row));
                return redirect(route('event.vendor.edit',['id'=>$row->id]))->with('success', __('Event created') );
            }
        }
    }

    public function saveTerms($row, $request)
    {
        if (empty($request->input('terms'))) {
            $this->eventTermClass::where('target_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->eventTermClass::firstOrCreate([
                    'term_id' => $term_id,
                    'target_id' => $row->id
                ]);
            }
            $this->eventTermClass::where('target_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }

    public function editEvent(Request $request, $id)
    {
        $this->checkPermission('event_update');
        $user_id = Auth::id();
        $row = $this->eventClass::where("create_user", $user_id);
        $row = $row->find($id);
        if (empty($row)) {
            return redirect(route('event.vendor.index'))->with('warning', __('Event not found!'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        $data = [
            'translation'    => $translation,
            'row'           => $row,
            'event_location' => $this->locationClass::where("status","publish")->get()->toTree(),
            'location_category' => $this->locationCategoryClass::where('status', 'publish')->get(),
            'attributes'    => $this->attributesClass::where('service', 'event')->get(),
            "selected_terms" => $row->terms->pluck('term_id'),
            'breadcrumbs'        => [
                [
                    'name' => __('Manage Events'),
                    'url'  => route('event.vendor.index')
                ],
                [
                    'name'  => __('Edit'),
                    'class' => 'active'
                ],
            ],
            'page_title'         => __("Edit Events"),
        ];
        return view('Event::frontend.vendorEvent.detail', $data);
    }

    public function deleteEvent($id)
    {
        $this->checkPermission('event_delete');
        $user_id = Auth::id();
        if(\request()->query('permanently_delete')){
            $query = $this->eventClass::where("create_user", $user_id)->where("id", $id)->withTrahsed()->first();
            if (!empty($query)) {
                $query->forceDelete();
            }
        }else {
            $query = $this->eventClass::where("create_user", $user_id)->where("id", $id)->first();
            if (!empty($query)) {
                $query->delete();
                event(new UpdatedServiceEvent($query));
            }
        }
        return redirect(route('event.vendor.index'))->with('success', __('Delete event success!'));
    }

    public function bulkEditEvent($id , Request $request){
        $this->checkPermission('event_update');
        $action = $request->input('action');
        $user_id = Auth::id();
        $query = $this->eventClass::where("create_user", $user_id)->where("id", $id)->first();
        if (empty($id)) {
            return redirect()->back()->with('error', __('No item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if(empty($query)){
            return redirect()->back()->with('error', __('Not Found'));
        }
        switch ($action){
            case "make-hide":
                $query->status = "draft";
                break;
            case "make-publish":
                $query->status = "publish";
                if(!auth()->user()->checkUserPlan()) {
                    return redirect(route('user.plan'));
                }
                break;
        }
        $query->save();
        event(new UpdatedServiceEvent($query));

        return redirect()->back()->with('success', __('Update success!'));
    }

    public function bookingReportBulkEdit($booking_id , Request $request){
        $status = $request->input('status');
        if (!empty(setting_item("event_allow_vendor_can_change_their_booking_status")) and !empty($status) and !empty($booking_id)) {
            $query = $this->bookingClass::where("id", $booking_id);
            $query->where("vendor_id", Auth::id());
            $item = $query->first();
            if(!empty($item)){
                $item->status = $status;
                $item->save();

                if($status == Booking::CANCELLED) $item->tryRefundToWallet();

                event(new BookingUpdatedEvent($item));
                return redirect()->back()->with('success', __('Update success'));
            }
            return redirect()->back()->with('error', __('Booking not found!'));
        }
        return redirect()->back()->with('error', __('Update fail!'));
    }
}
