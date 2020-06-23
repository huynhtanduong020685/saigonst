<?php

// use Botble\Base\Enums\BaseStatusEnum;
// use Botble\Career\Repositories\Interfaces\CareerInterface;
// use Botble\RealEstate\Enums\ProjectStatusEnum;
// use Botble\RealEstate\Enums\PropertyStatusEnum;
// use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
// use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
// use Botble\Theme\Events\RenderingSiteMapEvent;

require_once __DIR__ . '/../vendor/autoload.php';

register_page_template([
    'default' => 'Default',
]);

register_sidebar([
    'id'          => 'footer_sidebar',
    'name'        => 'Footer sidebar',
    'description' => 'Footer sidebar for Flex Home theme',
]);
add_shortcode('google-map', 'Google map', 'Custom map', function ($shortCode) {
    return Theme::partial('short-codes.google-map', ['address' => $shortCode->content]);
});

add_shortcode('youtube-video', 'Youtube video', 'Add youtube video', function ($shortCode) {
    return Theme::partial('short-codes.video', ['url' => $shortCode->content]);
});

add_shortcode('featured-posts', 'Featured posts', 'Featured posts', function () {
    return Theme::partial('short-codes.featured-posts');
});

add_shortcode('what-new-posts', 'What\'s new posts', 'What\'s new posts', function () {
    return Theme::partial('short-codes.what-new-posts');
});

add_shortcode('best-for-you-posts', 'Best for you posts', 'Best for you posts', function () {
    return Theme::partial('short-codes.best-for-you-posts');
});

add_shortcode('all-galleries', 'All Galleries', 'All Galleries', function () {
    return Theme::partial('short-codes.all-galleries');
});

shortcode()->setAdminConfig('google-map', Theme::partial('short-codes.google-map-admin-config'));
shortcode()->setAdminConfig('youtube-video', Theme::partial('short-codes.youtube-admin-config'));

theme_option()
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© 2020 Botble Technologies. All right reserved.',
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => __('Change copyright'),
                'data-counter' => 250,
            ],
        ],
        'helper'     => __('Copyright on footer of site'),
    ])
    ->setField([
        'id'         => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'googleFonts',
        'label'      => __('Primary font'),
        'attributes' => [
            'name'  => 'primary_font',
            'value' => 'Nunito Sans',
        ],
    ])
    ->setField([
        'id'         => 'about-us',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'textarea',
        'label'      => 'About us',
        'attributes' => [
            'name'    => 'about-us',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'hotline',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Hotline',
        'attributes' => [
            'name'    => 'hotline',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Hotline',
                'data-counter' => 30,
            ],
        ],
    ])
    ->setField([
        'id'         => 'address',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Address',
        'attributes' => [
            'name'    => 'address',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Address',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'email',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'email',
        'label'      => 'Email',
        'attributes' => [
            'name'    => 'email',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Email',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setSection([
        'title'      => __('Social'),
        'desc'       => __('Social links'),
        'id'         => 'opt-text-subsection-social',
        'subsection' => true,
        'icon'       => 'fa fa-share-alt',
    ])
    ->setField([
        'id'         => 'facebook',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Facebook',
        'attributes' => [
            'name'    => 'facebook',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'twitter',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Twitter',
        'attributes' => [
            'name'    => 'twitter',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'youtube',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Youtube',
        'attributes' => [
            'name'    => 'youtube',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ]);

RvMedia::addSize('small', 410, 270);

Event::listen(RenderingSiteMapEvent::class, function () {

    $projects = app(ProjectInterface::class)->advancedGet([
        'condition' => [
            're_projects.status' => ProjectStatusEnum::SELLING,
        ],
        'with'      => ['slugable'],
    ]);

    SiteMapManager::add(route('public.projects'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($projects as $project) {
        SiteMapManager::add($project->url, $project->updated_at, '0.8', 'daily');
    }

    $properties = app(PropertyInterface::class)->advancedGet([
        'condition' => [
            ['re_properties.status', 'IN', [PropertyStatusEnum::RENTING, PropertyStatusEnum::SELLING()]],
        ],
        'with'      => ['slugable'],
    ]);

    SiteMapManager::add(route('public.properties'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($properties as $property) {
        SiteMapManager::add($property->url, $property->updated_at, '0.8', 'daily');
    }

    $careers = app(CareerInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);

    SiteMapManager::add(route('public.careers'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($careers as $career) {
        SiteMapManager::add($career->url, $career->updated_at, '0.6', 'daily');
    }

});



add_action('init', 'change_media_config', 124);

if (!function_exists('change_media_config')) {
    function change_media_config() {
        config([
            'filesystems.default'           => 'public',
            'filesystems.disks.public.root' => public_path('storage'),
        ]);
    }
}
