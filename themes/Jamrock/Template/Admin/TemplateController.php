<?php
namespace Themes\Jamrock\Template\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\AdminController;
use Modules\Template\Models\Template;
use Modules\Template\Models\TemplateTranslation;

class TemplateController extends AdminController
{
    /**
     * @var Template
     */
    protected $templateClass;
    protected $templateTranslationClass;
    public function __construct()
    {
        parent::__construct();
        $this->templateClass = Template::class;
        $this->templateTranslationClass = TemplateTranslation::class;
    }
    public function bulkEdit(Request $request)
    {
        if(is_demo_mode()){
            return redirect()->back()->with('danger',__("DEMO MODE: Disable update"));
        }
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        switch ($action){
            case "clone":
                foreach ($ids as $id) {
                    $query = $this->templateClass::where("id", $id);
                    $row  = $query->first();
                    if(!empty($query)){
                        $new = $row->replicate();
                        $new->title.='  copy';
                        $new->save();

                        foreach(TemplateTranslation::query()->where('origin_id',$row->id)->get() as $tran){
                            $a = $tran->replicate();
                            $a->origin_id = $new->id;
                            $a->save();
                        }
                    }
                }
                return redirect()->back()->with('success', __('Clone success!'));
                break;
            case "delete":
                foreach ($ids as $id) {
                    $query = $this->templateClass::where("id", $id);
                    $this->checkPermission('template_delete');
                    $query->first();
                    if(!empty($query)){
                        $query->delete();
                    }
                }
                return redirect()->back()->with('success', __('Deleted success!'));
                break;
            default:
                // Change status
                foreach ($ids as $id) {
                    $query = $this->templateClass::where("id", $id);
                    $this->checkPermission('template_update');
                    $query->update(['status' => $action]);
                }
                return redirect()->back()->with('success', __('Update success!'));
                break;
        }
    }
}
