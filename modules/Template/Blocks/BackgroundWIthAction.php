<?php
namespace Modules\Template\Blocks;
use Illuminate\Support\Facades\View;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class BackgroundWIthAction extends BaseBlock
{
    public $options = [];

    public function getName()
    {
        return 'Background With Action';
    }

    public function getOptions(){
        return [
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title')
                ],
                [
                    'id'    => 'bg_image',
                    'type'  => 'uploader',
                    'label' => __('Background Image Uploader')
                ],
                [
                    'id'          => 'list_slider',
                    'type'        => 'listItem',
                    'label'       => __('Add Template Buttons'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'        => 'link',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Link')
                        ],
                        [
                            'id'    => 'icon',
                            'type'  => 'input',
                            'inputType' => 'text',
                            'label' => __('Icon Code')
                        ]
                    ]
                ]
            ],
            'category'=>__("Other Block")
        ];
    }

    public function content($model = [])
    {
        $model['bg_image'] = FileHelper::url($model['bg_image'] ?? "", 'full') ?? "";
        return $this->view('Template::frontend.blocks.background-with-action', $model);
    }

    public function contentAPI($model = []){
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
