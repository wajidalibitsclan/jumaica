<?php
namespace Themes\Jamrock\Faq\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Themes\Jamrock\Faq\Models\Faq;
use Themes\Jamrock\Faq\Models\FaqCategory;

class FaqController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $model = Faq::query()->select("bravo_faq.*");
        $model->orderBy('bravo_faq.id', 'desc');

        if (!empty($search = $request->input("s"))) {
            $model->where(function($query) use ($search) {
                $query->where('bravo_faq.title', 'LIKE', '%' . $search . '%');
                $query->orWhere('bravo_faq.content', 'LIKE', '%' . $search . '%');
            });
            $title_page = __('Search results : ":s"', ["s" => $search]);
        }

        if (!empty($category_ids = $request->query('cat_id')) and !empty($category_ids[0])) {
            if (!is_array($category_ids))
                $category_ids = [$category_ids];
            $list_cat = FaqCategory::whereIn('id', $category_ids)->where("status", "publish")->get();
            if (!empty($list_cat)) {
                $where_left_right = [];
                $params = [];
                foreach ($list_cat as $cat) {
                    $where_left_right[] = " ( bravo_faq_category._lft >= ? AND bravo_faq_category._rgt <= ? ) ";
                    $params[] = $cat->_lft;
                    $params[] = $cat->_rgt;
                }
                $sql_where_join = " ( " . implode("OR", $where_left_right) . " )  ";
                $model->join('bravo_faq_category', function ($join) use ($sql_where_join,$params) {
                    $join->on('bravo_faq_category.id', '=', 'bravo_faq.type')->WhereRaw($sql_where_join,$params);
                });
                $title_page = $cat->name;
            }
        }

        $data = [
            'rows'              => $model->with("getAuthor")->with('translations')->paginate(10),
            'faq_category' => FaqCategory::where('status', 'publish')->with(['translations'])->get()->toTree(),
            'title_page' => $title_page ?? __("Faqs"),
            'breadcrumbs'       => [
                [
                    'name'  => __('News'),
                    'url'  => route('news.index'),
                    'class' => 'active'
                ],
            ],
        ];
        return view('Faq::frontend.search', $data);
    }
}
