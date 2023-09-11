<?php

    namespace Themes\Findhouse\User\Listeners;

    use Illuminate\Support\Facades\Mail;
    use Modules\User\Emails\RegisteredEmail;
    use Modules\User\Emails\VendorRegisteredEmail;
    use Modules\User\Events\NewVendorRegistered;
    use Modules\User\Events\SendMailUserRegistered;
    use Modules\User\Models\User;

    class SendVendorRegisterdEmail
    {
        /**
         * Create the event listener.
         *
         * @return void
         */
        public $user;
        const CODE = [
            'first_name'    => '[first_name]',
            'last_name'     => '[last_name]',
            'name'          => '[name]',
            'email'         => '[email]',
            'created_at'    => '[created_at]',
            'link_approved' => '[link_approved]'
        ];

        public function __construct(User $user)
        {
            $this->user = $user;
            //
        }

        /**
         * Handle the event.
         *
         * @param NewVendorRegistered $event
         * @return void
         */
        public function handle(NewVendorRegistered $event)
        {

            if($event->user->locale){
                $old = app()->getLocale();
                app()->setLocale($event->user->locale);
            }

            if (!empty(setting_item('enable_mail_vendor_registered'))) {
                $body = $this->replaceContentEmail($event, setting_item_with_lang('vendor_content_email_registered',app()->getLocale()));
                Mail::to($event->user->email)->send(new RegisteredEmail($event->user, $body, 'customer'));
            }

            if(!empty($old)){
                app()->setLocale($old);
            }

            if (!empty(setting_item('admin_email') and !empty(setting_item('admin_enable_mail_vendor_registered'))) and setting_item_with_lang('admin_content_email_vendor_registered',app()->getLocale())) {
                $body = $this->replaceContentEmail($event, setting_item_with_lang('admin_content_email_vendor_registered',app()->getLocale()));
                Mail::to(setting_item('admin_email'))->send(new VendorRegisteredEmail($event->user, $body, 'admin'));
            }

        }

        public function replaceContentEmail($event, $content)
        {
            if (!empty($content)) {
                foreach (self::CODE as $item => $value) {
                    if($item == "link_approved"){
                        $content = str_replace($value, "<a href='".url('admin/module/user/userUpgradeRequest')."'>".url('admin/module/user/userUpgradeRequest')."</a>", $content);
                    } else {
                        $content = str_replace($value, @$event->user->$item, $content);
                    }
                }
            }
            return $content;
        }
    }
