<?php
namespace Themes\Jamrock\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class AboutContact extends BaseBlock
{
    public function getOptions(){
        return [
            'settings' => [
                [
                    'id'        => 'header_image',
                    'type'  => 'uploader',
                    'label'     => __('Header image')
                ],
                [
                    'id'          => 'message_us',
                    'type'        => 'listItem',
                    'label'       => __('Message Us'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'            => 'icon',
                            'type'          => 'select',
                            'inputType' => 'select',
                            'label'         => __('Select icon'),
                            'default' => 'email',
                            'values'        => [
                                [
                                    'id'   => 'email',
                                    'name' => __("Email")
                                ],
                                [
                                    'id'   => 'phone_1',
                                    'name' => __("Phone 1")
                                ],
                                [
                                    'id'   => 'phone_2',
                                    'name' => __("Phone 2")
                                ],
                                [
                                    'id'   => 'skype',
                                    'name' => __("Skype")
                                ],
                                [
                                    'id'   => 'message',
                                    'name' => __("Message")
                                ],
                                [
                                    'id'   => 'message_2',
                                    'name' => __("Message 2")
                                ]
                            ]
                        ],
                        [
                            'id'        => 'text',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Text')
                        ],
                    ]
                ],
                [
                    'id'          => 'call_us',
                    'type'        => 'listItem',
                    'label'       => __('Call Us'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'            => 'icon',
                            'type'          => 'select',
                            'inputType' => 'select',
                            'label'         => __('Select icon'),
                            'default' => 'email',
                            'values'        => [
                                [
                                    'id'   => 'email',
                                    'name' => __("Email")
                                ],
                                [
                                    'id'   => 'phone_1',
                                    'name' => __("Phone 1")
                                ],
                                [
                                    'id'   => 'phone_2',
                                    'name' => __("Phone 2")
                                ],
                                [
                                    'id'   => 'skype',
                                    'name' => __("Skype")
                                ],
                                [
                                    'id'   => 'message',
                                    'name' => __("Message")
                                ],
                                [
                                    'id'   => 'message_2',
                                    'name' => __("Message 2")
                                ]
                            ]
                        ],
                        [
                            'id'        => 'text',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Text')
                        ],
                    ]
                ],
                [
                    'id'        => 'link_service_car',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Url Taxi')
                ],
                [
                    'id'        => 'link_service_tour',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Url Tour')
                ],
                [
                    'id'        => 'link_service_event',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Url Event')
                ],
                [
                    'id'        => 'link_service_faqs',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Url Faqs')
                ],
            ],
            'category'=>__("Other Block")
        ];
    }

    public function getName()
    {
        return __('About Contact');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.about-contact.index', $model);
    }
}
