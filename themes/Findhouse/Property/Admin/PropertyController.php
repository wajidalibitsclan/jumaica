<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2019
 * Time: 1:56 PM
 */
namespace Themes\Findhouse\Property\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Core\Models\Attributes;
use Modules\Location\Models\Location;
use Themes\Findhouse\Property\Models\Property;
use Themes\Findhouse\Property\Models\PropertyTerm;
use Themes\Findhouse\Property\Models\PropertyTranslation;
use Themes\Findhouse\Property\Models\PropertyCategory;
use Illuminate\Support\Facades\DB;


class PropertyController extends AdminController
{
    protected $property;
    protected $property_translation;
    protected $property_term;
    protected $attributes;
    protected $location;
    protected $propertyCategoryClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/property');
        $this->property = Property::class;
        $this->property_translation = PropertyTranslation::class;
        $this->property_term = PropertyTerm::class;
        $this->attributes = Attributes::class;
        $this->location = Location::class;
        $this->propertyCategoryClass = PropertyCategory::class;
    }

    public function callAction($method, $parameters)
    {
        if(!Property::isEnable())
        {
            return redirect('/');
        }
        return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
    }

    public function index(Request $request)
    {
        $this->checkPermission('property_view');
        $query = $this->property::query() ;
        $query->orderBy('id', 'desc');
        if (!empty($property_name = $request->input('s'))) {
            $query->where('title', 'LIKE', '%' . $property_name . '%');
            $query->orderBy('title', 'asc');
        }

        if ($this->hasPermission('property_manage_others')) {
            if (!empty($author = $request->input('vendor_id'))) {
                $query->where('create_user', $author);
            }
        } else {
            $query->where('create_user', Auth::id());
        }
        $data = [
            'rows'               => $query->with(['author'])->paginate(20),
            'property_categories'    => $this->propertyCategoryClass::where('status', 'publish')->get()->toTree(),
            'attributes' => $this->attributes::where('service', 'property')->with(['terms','translations'])->get(),
            'property_manage_others' => $this->hasPermission('property_manage_others'),
            'breadcrumbs'        => [
                [
                    'name' => __('Properties'),
                    'url'  => 'admin/module/property'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Property Management")
        ];
        return view('Property::admin.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('property_create');
        $row = new $this->property();
        $row->fill([
            'status' => 'publish'
        ]);
        $data = [
            'row'            => $row,
            'property_category'    => $this->propertyCategoryClass::where('status', 'publish')->get()->toTree(),
            'attributes' => $this->attributes::where('service', 'property')->with(['terms','translations'])->get(),
            'property_location' => $this->location::where('status', 'publish')->get()->toTree(),
            'translation'    => new $this->property_translation(),
            'breadcrumbs'    => [
                [
                    'name' => __('Properties'),
                    'url'  => 'admin/module/property'
                ],
                [
                    'name'  => __('Add Property'),
                    'class' => 'active'
                ],
            ],
            'page_title'     => __("Add new Property")
        ];
        return view('Property::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('property_update');
        $row = $this->property::find($id);
        if (empty($row)) {
            return redirect(route('property.admin.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (!$this->hasPermission('property_manage_others')) {
            if ($row->create_user != Auth::id()) {
                return redirect(route('property.admin.index'));
            }
        }
        $data = [
            'row'            => $row,
            'property_category'    => $this->propertyCategoryClass::where('status', 'publish')->get()->toTree(),
            'translation'    => $translation,
            "selected_terms" => $row->terms->pluck('term_id'),
            'attributes'     => $this->attributes::where('service', 'property')->get(),
            'property_location'  => $this->location::where('status', 'publish')->get()->toTree(),
            'enable_multi_lang'=>true,
            'breadcrumbs'    => [
                [
                    'name' => __('Properties'),
                    'url'  => 'admin/module/property'
                ],
                [
                    'name'  => __('Edit Property'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Edit: :name",['name'=>$row->title])
        ];
        return view('Property::admin.detail', $data);
    }

    public function store( Request $request, $id ){

        if($id>0){
            $this->checkPermission('property_update');
            $row = $this->property::find($id);
            if (empty($row)) {
                return redirect(route('property.admin.index'));
            }

            if($row->create_user != Auth::id() and !$this->hasPermission('property_manage_others'))
            {
                return redirect(route('property.admin.index'));
            }
        }else{
            $this->checkPermission('property_create');
            $row = new $this->property();
            $row->status = "publish";
        }
        $dataKeys = [
            'title',
            'content',
            'price',
            'is_instant',
            'status',
            'video',
            'faqs',
            'image_id',
            'banner_image_id',
            'gallery',
            'bed',
            'bathroom',
            'square',
            'garages',
            'year_built',
            'area',
            'area_unit',
            'location_id',
            'address',
            'map_lat',
            'map_lng',
            'map_zoom',
            'price',
            'sale_price',
            'max_guests',
            'enable_extra_price',
            'extra_price',
            'is_featured',
            'default_state',
            'category_id',
            'property_type',
            'deposit',
            'pool_size',
            'additional_zoom',
            'remodal_year',
            'amenities',
            'equipment',
            'is_sold',
        ];
        if($this->hasPermission('property_manage_others')){
            $dataKeys[] = 'create_user';
        }

        $row->fillByAttr($dataKeys,$request->input());
        if($request->input('slug')){
            $row->slug = $request->input('slug');
        }
	    //$row->ical_import_url  = $request->ical_import_url;

        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            if(!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }

            if($id > 0 ){
                return back()->with('success',  __('Property updated') );
            }else{
                return redirect(route('property.admin.edit',$row->id))->with('success', __('Property created') );
            }
        }
    }

    public function saveTerms($row, $request)
    {
        $this->checkPermission('property_manage_attributes');
        if (empty($request->input('terms'))) {
            $this->property_term::where('target_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->property_term::firstOrCreate([
                    'term_id' => $term_id,
                    'target_id' => $row->id
                ]);
            }
            $this->property_term::where('target_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }


    public function showContact(Request $request) {
        $rows = DB::table('bravo_contact_object')->where('object_model', '=', 'property')->paginate(20);
        if (count($rows) > 0) {
            foreach($rows as $row) {
                $row->nameProperty = $this->property::where('id', $row->object_id)->first()->title;
                $row->nameVendor = DB::table('users')->select(DB::raw('CONCAT(first_name, " ", last_name) AS name'))->where('id', $row->vendor_id)->first()->name;
            }
        }
        $data = [
            'rows'        => $rows,
            'breadcrumbs' => [
                [
                    'name' => __('Property'),
                    'url'  => '/admin/module/property',
                ],
                [
                    'name'  => __('Contact'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Contact property"),
        ];
        return view('Property::admin.contact', $data);
    }

    public function bulkEdit(Request $request)
    {

        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }

        switch ($action){
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->property::where("id", $id);
                    if (!$this->hasPermission('property_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('property_delete');
                    }
                    $query->first();
                    if(!empty($query)){
                        $query->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            case "clone":
                $this->checkPermission('property_create');
                foreach ($ids as $id) {
                    (new $this->property())->saveCloneByID($id);
                }
                return redirect()->back()->with('success', __('Clone success!'));
                break;
            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->property::where("id", $id);
                    if (!$this->hasPermission('property_manage_others')) {
                        $query->where("create_user", Auth::id());
                        $this->checkPermission('property_update');
                    }
                    $query->update(['status' => $action]);
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }


    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            if(is_array($selected))
            {
                $items = Property::select('id', 'title as text')->whereIn('id',$selected)->take(50)->get();
                return response()->json([
                    'items'=>$items
                ]);
            }else{
                $item = Property::find($selected);
            }
            if(empty($item)){
                return response()->json([
                    'text'=>''
                ]);
            }else{
                return response()->json([
                    'text'=>$item->title
                ]);
            }
        }

        $q = $request->query('q');
        $query = Property::select('id', 'title as text')->where("status","publish");
        if ($q) {
            $query->where('title', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}