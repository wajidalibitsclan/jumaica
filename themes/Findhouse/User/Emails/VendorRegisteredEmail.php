<?php

namespace Themes\Findhouse\User\Emails;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Events\VendorApproved;

class VendorRegisteredEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    const CODE = [
        'buttonReset' => '[button_reset_password]',
    ];
    public $user;
    public $content;
    public $to_address;

    public function __construct(User $user, $content, $to_address)
    {
        $this->user = $user;
        $this->content = $content;
        $this->to_address = $to_address;
    }

    public function build()
    {
        $subject = setting_item_with_lang('vendor_subject_email_registered','',__('New Vendor Registration'));
        if($this->to_address == 'admin'){
            $subject = setting_item_with_lang('admin_subject_email_vendor_registered','',$subject);
        }
        return $this->subject($subject)->view('User::emails.vendor-registered')->with([
            'user'    => $this->user,
            'content' => $this->content,
            'to'      => $this->to_address,
        ]);
    }
}
