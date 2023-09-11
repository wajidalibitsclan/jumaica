<?php
namespace Themes\Jamrock\Booking\Admin;
use Themes\Jamrock\Booking\Models\Extra;
use Themes\Jamrock\Booking\Models\BookingTranslation;
use Illuminate\Http\Request;
use Modules\AdminController;

class ExtraController extends AdminController {

    protected $bookingClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('extra.admin.index'));
        $this->bookingClass = Extra::class;
    }



    public function index() {
        $listBooking = $this->bookingClass::paginate(20);
        return view('Booking::admin.extra.index', ['rows' => $listBooking]);
    }

    public function create() {
        $row = new $this->bookingClass();
        $row->dropdown = [];
        return view('Booking::admin.extra.detail', ['row' => $row,'translation'=>$row]);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('user_create');
        $row = $this->bookingClass::find($id);
        if (empty($row)) {
            return redirect(route('Booking.admin.extra.index'));
        }
        $translation = $row;//->translateOrOrigin($request->query('lang'));
        // if (isset($row->content)) {
        //     $row->content = json_decode($row->content, true);
        // }

        if(! $translation->dropdown){
            $translation->dropdown = [];
        }

        $data = [
            'row'         => $row,
            'translation'    => $translation,
            'enable_multi_lang' => 1,
            'breadcrumbs' => [
                [
                    'name' => __('Extra'),
                    'url'  => route('extra.admin.index')
                ],
                [
                    'name'  => __('edit'),
                    'url' => route('extra.admin.edit', $id)
                ],
            ],
        ];
        return view('Booking::admin.extra.detail', $data);
    }


    public function store(Request $request, $id) {
        $this->checkPermission('user_create');
        $this->validate($request, [
            'title' => 'required',
        ]);
        if($id>0){
            $row = $this->bookingClass::find($id);
            if (empty($row)) {
                return redirect(route('Booking::admin.extra.index'));
            }
        }else{
            $row = new $this->bookingClass();
        }
        $dataKeys = [
            "title",
            "price",
            'display_order',
            'include',
            'exclude',
            'image_id',
            'video_url',
            'dropdown'
        ];

        $row->fillByAttr($dataKeys,$request->input());
        $row->saveOriginOrTranslation($request->input('lang'),true);

        if($id > 0 ){
            return back()->with('success',  __('extra updated') );
        }else{
            return redirect(route('extra.admin.edit',$row->id))->with('success', __('extra created') );
        }

    }

    public function editBulk(Request $request)
    {
        $this->checkPermission('user_create');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $this->bookingClass::where("id", $id)->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

}
