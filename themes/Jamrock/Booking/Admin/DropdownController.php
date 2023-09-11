<?php

namespace Themes\Jamrock\Booking\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Booking\Controllers\BookingController;
use Themes\Jamrock\Booking\Models\Dropdown;
use Themes\Jamrock\Booking\Models\Extra;

class DropdownController extends AdminController
{

    protected $bookingClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('extra.admin.index'));
        $this->bookingClass = Dropdown::class;
    }

    public function index(){

        $dropdown = Dropdown::all();
        return view('Booking::admin.dropdown.index', ['rows' => $dropdown]);
    }

    public function create() {
        $row = new $this->bookingClass();
        return view('Booking::admin.dropdown.detail', ['row' => $row,'translation'=>$row]);
    }


    public function store(Request $request, $id) {

        $this->validate($request, [
            'title' => 'required',
        ]);
        if($id>0){
            $row = $this->bookingClass::find($id);
            if (empty($row)) {
                return redirect()->back();
            }
        }else{
            $row = new $this->bookingClass();
        }

        $dataKeys = [
            "title"
        ];

        $row->fillByAttr($dataKeys,$request->input());
        $row->saveOriginOrTranslation($request->input('lang'),true);

        if($id > 0 ){
            return back()->with('success',  __('Dropdown updated') );
        }else{
            return redirect(route('dropdown.admin.edit',$row->id))->with('success', __('Dropdown created') );
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
            'enable_multi_lang' => 1,
            'breadcrumbs' => [
                [
                    'name' => __('Extra'),
                    'url'  => route('extra.admin.index')
                ],
                [
                    'name' => __('Dropdown'),
                    'url'  => route('dropdown.admin.index')
                ],
                [
                    'name'  => __('edit'),
                    'url' => route('dropdown.admin.edit', $id)
                ],
            ],
        ];
        return view('Booking::admin.dropdown.detail', $data);
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
