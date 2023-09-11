<?php

namespace Themes\Jamrock\Booking\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Booking\Controllers\BookingController;
use Themes\Jamrock\Booking\Models\Combination;
use Themes\Jamrock\Booking\Models\Dropdown;
use Themes\Jamrock\Booking\Models\Options;

class CombinationController extends AdminController
{

    protected $bookingClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('extra.admin.index'));
        $this->bookingClass = Combination::class;
    }

    public function index(){

        $listBooking = $this->bookingClass::paginate(20);
        return view('Booking::admin.combination.index', ['rows' => $listBooking]);


    }

    public function create() {
        $row = new $this->bookingClass();
        $row->option = [];

        $dropdown = Dropdown::all();

        return view('Booking::admin.combination.detail', ['row' => $row,'translation'=>$row, 'dropdown' => $dropdown]);
    }

    public function getOptions(Request  $request){


        $options = Options::where('dropdown_id', $request->id)->get();

        return response()->json($options, 200);

    }


    public function store(Request $request, $id) {
        $this->validate($request, [
            'option' => 'required',
            'price' => 'required',
        ]);

        if($id>0){
            $row = $this->bookingClass::find($id);
            if (empty($row)) {
                return redirect()->back();
            }
        }else{
            $row = new $this->bookingClass();
        }

        $result = array_filter($request->option, fn ($value) => !is_null($value));
        $request->merge(['option' => array_values($result)]);


        $dataKeys = [
            "option",
            "price"
        ];

        $row->fillByAttr($dataKeys,$request->input());

        $row->saveOriginOrTranslation($request->input('lang'),true);

        if($id > 0 ){
            return back()->with('success',  __('Combination updated') );
        }else{
            return redirect(route('combination.admin.edit',$row->id))->with('success', __('Combination created') );
        }

    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('user_create');
        $row = $this->bookingClass::find($id);
        if (empty($row)) {
            return redirect(route('Booking.admin.dropdown.index'));
        }
        $translation = $row;//->translateOrOrigin($request->query('lang'));
        // if (isset($row->content)) {
        //     $row->content = json_decode($row->content, true);
        // }
        $data = [
            'row'         => $row,
            'translation'    => $translation,
            'dropdown'    => Dropdown::all(),
            'options'    => Options::where('dropdown_id', $translation->dropdown_id)->get(),
            'enable_multi_lang' => 1,
            'breadcrumbs' => [
                [
                    'name' => __('Extra'),
                    'url'  => route('extra.admin.index')
                ],
                [
                    'name' => __('Combinations'),
                    'url'  => route('combination.admin.index')
                ],
                [
                    'name'  => __('edit'),
                    'url' => route('dropdown.admin.edit', $id)
                ],
            ],
        ];

        return view('Booking::admin.combination.detail', $data);
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
