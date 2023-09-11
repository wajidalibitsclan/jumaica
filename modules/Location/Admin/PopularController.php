<?php
namespace Modules\Location\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Location\Models\PopularLocation;

class PopularController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('location.admin.popular.index'));
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->checkPermission('location_view');
        $listPopularLocation = PopularLocation::query() ;
        if (!empty($search = $request->query('s'))) {
            $listPopularLocation->where('name', 'LIKE', '%' . $search . '%');
        }
        $listPopularLocation->orderBy('created_at', 'asc');

        $data = [
            'rows'        => $listPopularLocation->get(),
            'row'         => new PopularLocation(),
            'breadcrumbs' => [
                [
                    'name' => __('Location'),
                    'url'  => route('location.admin.popular.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'translation'=>new PopularLocation()
        ];
        return view('Location::admin.popular.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('location_update');
        $row = PopularLocation::find($id);
        $translation = $row;
        if (empty($row)) {
            return redirect(route('location.admin.popular.index'));
        }
        $data = [
            'translation' => $translation,
            'enable_multi_lang'=>true,
            'row'         => $row,
            'parents'     => PopularLocation::get(),
            'breadcrumbs' => [
                [
                    'name' => __('Popular Locations'),
                    'url'  => route('location.admin.popular.index')
                ],
                [
                    'name'  => __('Edit'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Location::admin.popular.detail', $data);
    }

    public function store( Request $request, $id ){
        $this->checkPermission('location_update');

        if($id>0){
            $row = PopularLocation::find($id);
            if (empty($row)) {
                return redirect(route('location.admin.popular.index'));
            }
        }else{
            $row = new PopularLocation();
            $row->status = "publish";
        }

        $row->fill($request->input());
        if($request->input('slug')){
            $row->slug = $request->input('slug');
        }
        if($request->input('type')){

            $row->type = $request->input('type');
        }
        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            if($id > 0 ){
                return back()->with('success',  __('Location updated') );
            }else{
                return redirect(route('location.admin.popular.index'))->with('success', __('Location created') );
            }
        }
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            if(is_array($selected))
            {
                $items = PopularLocation::select('id', 'name as text')->whereIn('id',$selected)->take(50)->get();
                return response()->json([
                    'items'=>$items
                ]);
            }else{
                $item = PopularLocation::find($selected);
            }
            if(empty($item)){
                return response()->json([
                    'text'=>''
                ]);
            }else{
                return response()->json([
                    'text'=>$item->name
                ]);
            }
        }

        $q = $request->query('q');
        $query = PopularLocation::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __("Select at least 1 item!"));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = PopularLocation::where("id", $id);
                if (!$this->hasPermission('location_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('location_delete');
                }
                $query->first();
                if(!empty($query)){
                    //Sync child location
                    $list_childs = PopularLocation::where("parent_id", $id)->get();
                    if(!empty($list_childs)){
                        foreach ($list_childs as $child){
                            $child->parent_id = null;
                            $child->save();
                        }
                    }
                    //Del parent location
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = PopularLocation::where("id", $id);
                if (!$this->hasPermission('location_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('location_update');
                }
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }
}
