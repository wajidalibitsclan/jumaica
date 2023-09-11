<?php

namespace Themes\Findhouse\Contact\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Contact\Models\Contact;

class ContactController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('contact.admin.index'));
    }

    public function index(Request $request)
    {
        $this->checkPermission('contact_manage');

        $s = $request->query('s');
        $datapage = New Contact();
        if ($s) {
            $datapage->where(function ($query) use ($s){
                $query->where('name', 'LIKE', '%' . $s . '%')
                    ->orWhere('email','LIKE', '%' . $s . '%')
                    ->orWhere('message','LIKE', '%' . $s . '%')
                ;
            });
        }
        $data = [
            'rows'        => $datapage->paginate(20),
            'breadcrumbs' => [
                [
                    'name' => __('Contact Submissions'),
                    'url'  => route('contact.admin.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Contact::admin.index', $data);
    }
}
