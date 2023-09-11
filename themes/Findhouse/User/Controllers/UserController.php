<?php
namespace Themes\Findhouse\User\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Matrix\Exception;
use Modules\Contact\Models\Contact;
use Modules\FrontendController;
use Modules\User\Events\NewVendorRegistered;
use Modules\User\Events\SendMailUserRegistered;
use Modules\User\Models\Newsletter;
use Modules\User\Models\Subscriber;
use Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Modules\Vendor\Models\VendorRequest;
use Validator;
use Modules\Booking\Models\Booking;
use App\Helpers\ReCaptchaEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Booking\Models\Enquiry;
use Themes\Findhouse\Property\Models\Property;
use Modules\Review\Models\Review;
use Modules\User\Models\UserWishList;
use Themes\Findhouse\Agencies\Models\BravoContactObject;
use Illuminate\Support\Facades\DB;

class UserController extends FrontendController
{
    use AuthenticatesUsers;

    protected $enquiryClass;

    public function __construct()
    {
        $this->enquiryClass = Enquiry::class;
        parent::__construct();
    }


    public function dashboard(Request $request)
    {
        $this->checkPermission('dashboard_agent_access');
        $user_id = Auth::id();
        $countProperty = Property::where("create_user", $user_id)->count();
        $countView     = Property::where("create_user", $user_id)->sum('view');
        $countWish     = UserWishList::where("user_id", $user_id)->count();
        $countReview   = Review::join("bravo_properties","bravo_properties.id","bravo_review.object_id")->where("bravo_properties.create_user", $user_id)->where("bravo_review.object_model","'property'")->count();
        $data = [
            'count_property' => $countProperty,
            'page_title'         => __("Agent Dashboard"),
            'count_view'         => $countView,
            'count_review'       => $countReview,
            'count_wish'         => $countWish,
            'breadcrumbs'        => [
                [
                    'name'  => __('Dashboard'),
                    'class' => 'active'
                ]
            ]
        ];
        return view('User::frontend.dashboard', $data);
    }

    public function reloadChart(Request $request)
    {
        $chart = $request->input('chart');
        $user_id = Auth::id();
        switch ($chart) {
            case "earning":
                $from = $request->input('from');
                $to = $request->input('to');
                return $this->sendSuccess([
                    'data' => Booking::getEarningChartDataForVendor(strtotime($from), strtotime($to), $user_id)
                ]);
                break;
        }
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        $data = [
            'dataUser'         => $user,
            'page_title'       => __("Profile"),
            'breadcrumbs'      => [
                [
                    'name'  => __('My Profile'),
                    'class' => 'active'
                ]
            ],
            'is_vendor_access' => $this->hasPermission('dashboard_agent_access')
        ];
        return view('User::frontend.profile', $data);
    }
    public function profile_post(Request $request)
    {
        $user = \auth()->user();
        $request->validate([
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
        ]);
        $user->fill($request->input());
        $user->birthday = date("Y-m-d", strtotime($user->birthday));
        $user->user_social = json_encode($user->user_social);
        $user->save();
        return redirect()->back()->with('success', __('Update successfully'));
    }

    public function changePassword(Request $request)
    {
        if(is_demo_mode()){
            return redirect()->back()->with("error", __("DEMO MODE: You can not change password."));
        }
        $data = [
            'breadcrumbs' => [
                [
                    'name' => __('Setting'),
                    'url'  => route("user.profile.index")
                ],
                [
                    'name'  => __('Change Password'),
                    'class' => 'active'
                ]
            ],
            'page_title'  => __("Change Password"),
        ];
        return view('User::frontend.changePassword', $data);
    }

    public function changePasswordPost(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", __("Your current password does not matches with the password you provided. Please try again."));
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", __("New Password cannot be same as your current password. Please choose a different password."));
        }
        $request->validate([
            'current-password' => 'required',
            'new-password'     => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with('success', __('Password changed successfully !'));
    }

    public function bookingHistory(Request $request)
    {
        $user_id = Auth::id();
        $data = [
            'bookings'    => Booking::getBookingHistory($request->input('status'), $user_id),
            'statues'     => config('booking.statuses'),
            'breadcrumbs' => [
                [
                    'name'  => __('Booking History'),
                    'class' => 'active'
                ]
            ],
            'page_title'  => __("Booking History"),
        ];
        return view('User::frontend.bookingHistory', $data);
    }

    public function userLogin(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required'
        ];
        $messages = [
            'email.required'    => __('Email is required field'),
            'email.email'       => __('Email invalidate'),
            'password.required' => __('Password is required field'),
        ];
        if (ReCaptchaEngine::isEnable() and setting_item("user_enable_login_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                $errors = new MessageBag(['message_error' => __('Please verify the captcha')]);
                return response()->json([
                    'error'    => true,
                    'messages' => $errors
                ], 200);
            }
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors()
            ], 200);
        } else {
            $email = strip_tags($request->input('email'));
            $password = strip_tags($request->input('password'));
            if (Auth::attempt([
                'email'    => $email,
                'password' => $password
            ], $request->has('remember'))) {
                if (in_array(Auth::user()->status, ['blocked'])) {
                    Auth::logout();
                    $errors = new MessageBag(['message_error' => __('Your account has been blocked')]);
                    return response()->json([
                        'error'    => true,
                        'messages' => $errors,
                        'redirect' => false
                    ], 200);
                }
                $url =  $request->input('redirect') ? $request->input('redirect'): url('/');
                return response()->json([
                    'error'    => false,
                    'messages' => false,
                    'redirect' => strip_tags($url)
                ], 200);
            } else {
                $errors = new MessageBag(['message_error' => __('Username or password incorrect')]);
                return response()->json([
                    'error'    => true,
                    'messages' => $errors,
                    'redirect' => false
                ], 200);
            }
        }
    }

    public function userRegister(Request $request)
    {
        $rules = [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name'  => [
                'required',
                'string',
                'max:255'
            ],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'   => [
                'required',
                'string'
            ],
            'term'       => ['required'],
        ];
        $messages = [
            'email.required'      => __('Email is required field'),
            'email.email'         => __('Email invalidate'),
            'password.required'   => __('Password is required field'),
            'first_name.required' => __('The first name is required field'),
            'last_name.required'  => __('The last name is required field'),
            'term.required'       => __('The terms and conditions field is required'),
        ];
        if (ReCaptchaEngine::isEnable() and setting_item("user_enable_register_recaptcha")) {
            $codeCapcha = $request->input('g-recaptcha-response');
            if (!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)) {
                $errors = new MessageBag(['message_error' => __('Please verify the captcha')]);
                return response()->json([
                    'error'    => true,
                    'messages' => $errors
                ], 200);
            }
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors()
            ], 200);
        } else {

            $user = \App\User::create([
                'first_name' => strip_tags($request->input('first_name')),
                'last_name'  => strip_tags($request->input('last_name')),
                'email'      => strip_tags($request->input('email')),
                'password'   => Hash::make($request->input('password')),
                'publish'    => 'publish',
                'phone'    => strip_tags($request->input('phone')),
            ]);
            event(new Registered($user));
            Auth::loginUsingId($user->id);
            try {

                event(new SendMailUserRegistered($user));
            } catch (Exception $exception) {

                Log::warning("SendMailUserRegistered: " . $exception->getMessage());
            }
            $user->assignRole('customer');
            $url =  $request->input('redirect') ? $request->input('redirect'): url('/');

            return response()->json([
                'error'    => false,
                'messages' => false,
                'redirect' => strip_tags($url)
            ], 200);
        }
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255'
        ]);
        $check = Subscriber::withTrashed()->where('email', $request->input('email'))->first();
        if ($check) {
            if ($check->trashed()) {
                $check->restore();
                return $this->sendSuccess([], __('Thank you for subscribing'));
            }
            return $this->sendError(__('You are already subscribed'));
        } else {
            $a = new Subscriber();
            $a->email = $request->input('email');
            $a->first_name = $request->input('first_name');
            $a->last_name = $request->input('last_name');
            $a->save();
            return $this->sendSuccess([], __('Thank you for subscribing'));
        }
    }

    public function upgradeVendor(Request $request){
        $user = Auth::user();
        $vendorRequest = VendorRequest::query()->where("user_id",$user->id)->where("status","pending")->first();
        if(!empty($vendorRequest)){
            return redirect()->back()->with('warning', __('You have just done the become vendor request, please wait for the Admin\'s approved'));
        }
        // check vendor auto approved
        $vendorAutoApproved = setting_item('vendor_auto_approved');
         $dataVendor['role_request'] = setting_item('vendor_role');
        if ($vendorAutoApproved) {
            if ($dataVendor['role_request']) {
                $user->assignRole($dataVendor['role_request']);
            }
            $dataVendor['status'] = 'approved';
            $dataVendor['approved_time'] = now();
        } else {
            $dataVendor['status'] = 'pending';
        }
        $vendorRequestData = $user->vendorRequest()->save(new VendorRequest($dataVendor));
        try {
            event(new NewVendorRegistered($user, $vendorRequestData));
        } catch (Exception $exception) {
            Log::warning("NewVendorRegistered: " . $exception->getMessage());
        }
        return redirect()->back()->with('success', __('Request vendor success!'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect(app_get_locale(false, '/'));
    }

    public function enquiryReport(Request $request){
        $this->checkPermission('enquiry_view');
        $user_id = Auth::id();
        $rows = $this->enquiryClass::where("vendor_id",$user_id)->orderBy('id', 'desc');
        $data = [
            'rows'        => $rows->paginate(5),
            'statues'     => $this->enquiryClass::$enquiryStatus,
            'has_permission_enquiry_update' => $this->hasPermission('enquiry_update'),
            'breadcrumbs' => [
                [
                    'name'  => __('Enquiry Report'),
                    'class' => 'active'
                ],
            ],
            'page_title'  => __("Enquiry Report"),
        ];
        return view('User::frontend.enquiryReport', $data);
    }
    public function enquiryReportBulkEdit($enquiry_id, Request $request)
    {
        $status = $request->input('status');
        if (!empty( $this->hasPermission('enquiry_update') ) and !empty($status) and !empty($enquiry_id)) {
            $query = $this->enquiryClass::where("id", $enquiry_id);
            $query->where("vendor_id", Auth::id());
            $item = $query->first();
            if (!empty($item)) {
                $item->status = $status;
                $item->save();
                return redirect()->back()->with('success', __('Update success'));
            }
            return redirect()->back()->with('error', __('Enquiry not found!'));
        }
        return redirect()->back()->with('error', __('Update fail!'));
    }

    public function showContact(Request $request) {
        // $rows = DB::table('bravo_contact_object as bc')
        // ->select('bc.*', 'bp.title as property_title', 'bac.name as agency_title')
        // ->where('vendor_id', Auth::id());
        // if ($request->input('contact_type') == 'property_contact') {

        //     $rows -> where('bc.object_model','=','property');
        // }
        // if ($request->input('contact_type') == 'agent_contact') {

        //     $rows -> where('bc.object_model','=','agent');
        // }
        // if ($request->input('contact_type') == 'agency_contact') {

        //     $rows -> where('bc.object_model','=','agencies');
        // }
        // $rows = $rows->leftJoin('bravo_properties as bp', function($join)
        //     {
        //         $join->on('bp.id', '=', 'bc.object_id');
        //         $join->on('bc.object_model','=',DB::raw("'property'"));
        //     })
        // ->leftJoin('bravo_agencies as bac', function($join)
        //     {
        //         $join->on('bac.id', '=', 'bc.object_id');
        //         $join->on('bc.object_model','=',DB::raw("'agencies'"));
        //     })
        // ->paginate(20);
        // $data = [
        //     'rows'        => $rows,
        //     'breadcrumbs' => [
        //         [
        //             'name'  => __('Contact'),
        //             'class' => 'active'
        //         ],
        //     ],
        // ];


        // return view('User::frontend.contact', $data);

        $rows = \Modules\User\Models\BravoContactObject::where('vendor_id', Auth::id());
        if(!empty($request->contact_type=='property_contact')){
            $rows->where('object_model','property');
        }
        if(!empty($request->contact_type=='agent_contact')){
            $rows->where('object_model','agent');
        }
        if(!empty($request->contact_type=='agency_contact')){
            $rows->where('object_model','agencies');
        }
        $rows = $rows->with(['property','agencies'])->paginate(20);

        $data = [
            'rows'        => $rows,
            'breadcrumbs' => [
                [
                    'name'  => __('Contact'),
                    'class' => 'active'
                ],
            ],
        ];


        return view('User::frontend.contact_new', $data);
    }
    public function showContactNew(Request $request) {
        $rows = \Modules\User\Models\BravoContactObject::where('vendor_id', Auth::id());
        if(!empty($request->contact_type=='property_contact')){
            $rows->where('object_model','property');
        }
        if(!empty($request->contact_type=='agent_contact')){
            $rows->where('object_model','agent');
        }
        if(!empty($request->contact_type=='agency_contact')){
            $rows->where('object_model','agencies');
        }
        $rows = $rows->with(['property','agencies'])->paginate(20);

        $data = [
            'rows'        => $rows,
            'breadcrumbs' => [
                [
                    'name'  => __('Contact'),
                    'class' => 'active'
                ],
            ],
        ];


        return view('User::frontend.contact_new', $data);
    }
}
