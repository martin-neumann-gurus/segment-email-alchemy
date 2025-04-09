
<?php

return [
    'name' => 'Segment Email Settings',
    'description' => 'Customize email settings per segment',
    'version' => '1.0.0',
    'author' => 'Lovable',
    'routes' => [
        'main' => [
            'mautic_segment_email_settings' => [
                'path' => '/segments/emailsettings/{objectId}',
                'controller' => 'SegmentEmailBundle:SegmentEmail:edit',
                'requirements' => [
                    'objectId' => '\d+',
                ],
            ],
        ],
    ],
    'menu' => [],
    'services' => [
        'events' => [
            'mautic.segmentemail.subscriber.segment' => [
                'class' => \MauticPlugin\SegmentEmailBundle\EventListener\SegmentSubscriber::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                    'router',
                    'translator',
                ],
            ],
            'mautic.segmentemail.subscriber.email' => [
                'class' => \MauticPlugin\SegmentEmailBundle\EventListener\EmailSubscriber::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                    'mautic.helper.token_builder',
                ],
            ],
        ],
        'forms' => [
            'mautic.segmentemail.form.type.segmentemail' => [
                'class' => \MauticPlugin\SegmentEmailBundle\Form\Type\SegmentEmailType::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                ],
            ],
        ],
        'models' => [
            'mautic.segmentemail.model.segmentemail' => [
                'class' => \MauticPlugin\SegmentEmailBundle\Model\SegmentEmailModel::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                ],
            ],
        ],
        'integrations' => [
            'mautic.integration.segmentemail' => [
                'class' => \MauticPlugin\SegmentEmailBundle\Integration\SegmentEmailIntegration::class,
                'arguments' => [],
            ],
        ],
        'other' => [
            'mautic.segmentemail.helper.token' => [
                'class' => \MauticPlugin\SegmentEmailBundle\Helper\TokenHelper::class,
                'arguments' => [
                    'doctrine.orm.entity_manager',
                ],
            ],
        ],
    ],
];
?>
