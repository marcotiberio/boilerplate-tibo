<?php

namespace Flynt\Components\BlockDonationForm;

function getACFLayout()
{
    return [
        'name' => 'BlockDonationForm',
        'label' => __('Block: Form Donation (FundraisingBox)', 'flynt'),
        'sub_fields' => [
            // ---------------------------------------------------------------
            // Content
            // ---------------------------------------------------------------
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Title Size', 'flynt'),
                'instructions' => __('Visual size of the headline.', 'flynt'),
                'name' => 'titleSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
                'name' => 'titleTag',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Intro', 'flynt'),
                'instructions' => __('Optional intro text shown next to / above the form.', 'flynt'),
                'name' => 'intro',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Checklist', 'flynt'),
                'instructions' => __('Optional bullet points shown with a check icon (used in the "Media + Form" layout).', 'flynt'),
                'name' => 'bullets',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __('Add item', 'flynt'),
                'required' => 0,
                'sub_fields' => [
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'text',
                    ],
                ],
            ],

            // ---------------------------------------------------------------
            // FundraisingBox
            // ---------------------------------------------------------------
            [
                'label' => __('FundraisingBox', 'flynt'),
                'name' => 'fundraisingBoxTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Form hash (ID)', 'flynt'),
                'instructions' => __('Paste only the form hash from FundraisingBox. Find it under Forms → select form → Embed code, e.g. in <code>src="https://secure.fundraisingbox.com/app/paymentJS?hash=<strong>7erkely9zrzg1b9a</strong>"</code> you only need <code>7erkely9zrzg1b9a</code>.', 'flynt'),
                'name' => 'formHash',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Full embed code (advanced)', 'flynt'),
                'instructions' => __('Optional. If FundraisingBox gives you a different snippet, paste it here <strong>exactly</strong> as provided. When set, this overrides the form hash above.', 'flynt'),
                'name' => 'embedCode',
                'type' => 'textarea',
                'rows' => 4,
                'new_lines' => '',
                'required' => 0,
            ],
            [
                'label' => __('Prepopulation (optional)', 'flynt'),
                'name' => 'prepopulation',
                'type' => 'group',
                'layout' => 'row',
                'instructions' => __('Pre-fill the form. Leave empty to let donors choose. Only applies when using the form hash above (not the full embed code).', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Amount (€)', 'flynt'),
                        'name' => 'amount',
                        'type' => 'number',
                        'min' => 0,
                        'required' => 0,
                        'wrapper' => ['width' => 34],
                    ],
                    [
                        'label' => __('Interval', 'flynt'),
                        'name' => 'interval',
                        'type' => 'select',
                        'allow_null' => 1,
                        'choices' => [
                            '0' => __('One-time', 'flynt'),
                            '1' => __('Monthly', 'flynt'),
                            '3' => __('Quarterly', 'flynt'),
                            '6' => __('Semi-annually', 'flynt'),
                            '12' => __('Annually', 'flynt'),
                        ],
                        'required' => 0,
                        'wrapper' => ['width' => 33],
                    ],
                    [
                        'label' => __('Item ID', 'flynt'),
                        'instructions' => __('FundraisingBox <code>fb_item_id</code> (e.g. a specific project or sponsorship).', 'flynt'),
                        'name' => 'itemId',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 33],
                    ],
                ],
            ],
            [
                'label' => __('Fallback height (px)', 'flynt'),
                'instructions' => __('Reserved min-height for the form area to avoid layout shift while it loads. Default 640.', 'flynt'),
                'name' => 'formHeight',
                'type' => 'number',
                'default_value' => 640,
                'min' => 0,
                'required' => 0,
            ],

            // ---------------------------------------------------------------
            // Media (used in the "Media + Form" layout — e.g. sponsorship)
            // ---------------------------------------------------------------
            [
                'label' => __('Media card', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('Shown beside the form in the "Media + Form" layout. Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            [
                'label' => __('Media title', 'flynt'),
                'instructions' => __('Name / label overlaid on the image (e.g. the animal name).', 'flynt'),
                'name' => 'mediaTitle',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Media details', 'flynt'),
                'instructions' => __('Rows of label / value shown on the media card (e.g. Species, Age).', 'flynt'),
                'name' => 'mediaMeta',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __('Add row', 'flynt'),
                'required' => 0,
                'sub_fields' => [
                    [
                        'label' => __('Label', 'flynt'),
                        'name' => 'label',
                        'type' => 'text',
                        'wrapper' => ['width' => 40],
                    ],
                    [
                        'label' => __('Value', 'flynt'),
                        'name' => 'value',
                        'type' => 'text',
                        'wrapper' => ['width' => 60],
                    ],
                ],
            ],
            [
                'label' => __('Media description', 'flynt'),
                'name' => 'mediaDescription',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'required' => 0,
            ],

            // ---------------------------------------------------------------
            // Info block (used in the "Text + Form" layout — e.g. bank details)
            // ---------------------------------------------------------------
            [
                'label' => __('Info block', 'flynt'),
                'name' => 'infoTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'info',
                'type' => 'group',
                'layout' => 'block',
                'instructions' => __('Optional block below the form (e.g. bank transfer details). Shown in the "Text + Form" layout.', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                    ],
                    [
                        'label' => __('Description', 'flynt'),
                        'name' => 'description',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'required' => 0,
                    ],
                    [
                        'label' => __('Details', 'flynt'),
                        'instructions' => __('Rows of label / value (e.g. Account holder, IBAN, BIC, Reference).', 'flynt'),
                        'name' => 'details',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => __('Add row', 'flynt'),
                        'required' => 0,
                        'sub_fields' => [
                            [
                                'label' => __('Label', 'flynt'),
                                'name' => 'label',
                                'type' => 'text',
                                'wrapper' => ['width' => 40],
                            ],
                            [
                                'label' => __('Value', 'flynt'),
                                'name' => 'value',
                                'type' => 'text',
                                'wrapper' => ['width' => 60],
                            ],
                        ],
                    ],
                ],
            ],

            // ---------------------------------------------------------------
            // Options
            // ---------------------------------------------------------------
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
                        'label' => __('Layout', 'flynt'),
                        'name' => 'layout',
                        'type' => 'select',
                        'default_value' => 'text',
                        'choices' => [
                            'text' => __('Text + Form (with info block)', 'flynt'),
                            'media' => __('Media + Form (e.g. sponsorship)', 'flynt'),
                        ],
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Theme', 'flynt'),
                        'name' => 'theme',
                        'type' => 'select',
                        'default_value' => 'offWhite',
                        'choices' => [
                            'offWhite' => __('Off White', 'flynt'),
                            'beige' => __('Beige', 'flynt'),
                            'moss' => __('Moss', 'flynt'),
                            'dark-green' => __('Dark Green', 'flynt'),
                        ],
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
        ],
    ];
}
