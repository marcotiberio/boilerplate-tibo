<?php

namespace Flynt\Components\BlockTable;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockTable',
        'label' => __('Block: Table', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Block Title', 'flynt'),
                'name' => 'blockTitle',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Columns', 'flynt'),
                'name' => 'columns',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 2,
                'max' => 6,
                'button_label' => __('Add Column', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Column Title', 'flynt'),
                        'name' => 'columnTitle',
                        'type' => 'text',
                        'required' => 1,
                    ],
                ],
            ],
            [
                'label' => __('Rows', 'flynt'),
                'name' => 'rows',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Row', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Cells', 'flynt'),
                        'name' => 'cells',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'min' => 1,
                        'button_label' => __('Add Cell', 'flynt'),
                        'sub_fields' => [
                            [
                                'label' => __('Content', 'flynt'),
                                'name' => 'cellContent',
                                'type' => 'textarea',
                                'rows' => 3,
                                'required' => 0,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Top Border', 'flynt'),
                        'name' => 'topBorder',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                    ],
                ],
            ],
        ],
    ];
}
