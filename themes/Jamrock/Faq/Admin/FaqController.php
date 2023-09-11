<?php
namespace Themes\Jamrock\Faq\Admin;
use Themes\Jamrock\Faq\Models\FaqCategory;
use Themes\Jamrock\Faq\Models\FaqTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Themes\Jamrock\Faq\Models\Faq;
use Modules\AdminController;

class FaqController extends AdminController {

    protected $faqClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('faq.admin.index'));
        $this->faqClass = Faq::class;
    }

    public function index() {
        $listFaq = $this->faqClass::paginate(20);
        return view('Faq::admin.index', ['rows' => $listFaq]);
    }

    public function create() {
        $row = new $this->faqClass();
        return view('Faq::admin.detail', ['row' => $row,'faq_category' => FaqCategory::where('status', 'publish')->get()->toTree(),'translation'=>new FaqTranslation()]);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('user_create');
        $row = $this->faqClass::find($id);
        if (empty($row)) {
            return redirect(route('Faq.Admin.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        $data = [
            'row'         => $row,
            'translation'    => $translation,
            'enable_multi_lang' => 1,
            'faq_category' => FaqCategory::where('status', 'publish')->get()->toTree(),
            'breadcrumbs' => [
                [
                    'name' => __('Faq'),
                    'url'  => route('faq.admin.index')
                ],
                [
                    'name'  => __('edit'),
                    'url' => route('faq.admin.edit', $id)
                ],
            ],
        ];
        return view('Faq::admin.detail', $data);
    }


    public function store(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required',
            'type' => 'required'
        ]);
        if($id>0){
            $row = $this->faqClass::find($id);
            if (empty($row)) {
                return redirect(route('Faq::Admin.index'));
            }
        }else{
            $row = new $this->faqClass();
        }
        $dataKeys = [
            "title",
            "type",
            "content",
        ];
        $row->fillByAttr($dataKeys,$request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'),true);
        if($id > 0 ){
            return back()->with('success',  __('Faq updated') );
        }else{
            return redirect(route('faq.admin.edit',$row->id))->with('success', __('Faq created') );
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
                $query = $this->faqClass::where("id", $id)->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

}
