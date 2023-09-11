<?php
namespace Themes\Jamrock\Template;
class TemplateHelper{
    public static function getSocialLink($type,$link){
        $link = strip_tags($link);
        switch ($type){
            case "email":
                return "mailto:".$link;
                break;
            case "phone_1":
                return "https://wa.me/".static::handleWhatsappPhone($link);
                break;
            case "phone_2":
                return "tel:".static::handleWhatsappPhone($link);
                break;
            case "message_2":
                return "sms:".static::handleWhatsappPhone($link);
                break;
            case "message_1":
                return "https://m.me/".($link);
                break;
            break;
            case "skype":
                return "skype:".$link."?chat:";
            break;
        }
    }

    public static function handleWhatsappPhone($phone){
        $phone = preg_replace("/[^0-9]/", "", $phone );
        return str_replace([' ','.','(',')'],['','','',''],trim($phone));
    }
}
