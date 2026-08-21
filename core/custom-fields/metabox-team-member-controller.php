<?php

namespace T888Core;

class MetaboxTeamMemberController
{
    public static function init()
    {
        add_filter('rwmb_meta_boxes', [__CLASS__, 'register']);
    }

    public static function register($meta_boxes)
    {
        $meta_boxes[] = [
            'title'      => __('Member Information', 'nebon'),
            'id'         => 'team-member-information',
            'post_types' => ['team_member'],
            'fields'     => [
                [
                    'name' => __('Greeting', 'nebon'),
                    'id'   => 'team_greeting',
                    'type' => 'text',
                    'std'  => __('Hello i’m', 'nebon'),
                ],
                [
                    'name' => __('Position', 'nebon'),
                    'id'   => 'team_position',
                    'type' => 'text',
                ],
                [
                    'name' => __('Department', 'nebon'),
                    'id'   => 'team_department',
                    'type' => 'text',
                ],
                [
                    'name' => __('Experience', 'nebon'),
                    'id'   => 'team_experience',
                    'type' => 'text',
                ],
                [
                    'name' => __('Email', 'nebon'),
                    'id'   => 'team_email',
                    'type' => 'email',
                ],
                [
                    'name' => __('Phone', 'nebon'),
                    'id'   => 'team_phone',
                    'type' => 'text',
                ],
                [
                    'name' => __('Facebook URL', 'nebon'),
                    'id'   => 'team_facebook',
                    'type' => 'url',
                ],
                [
                    'name' => __('X (Twitter) URL', 'nebon'),
                    'id'   => 'team_twitter',
                    'type' => 'url',
                ],
                [
                    'name' => __('LinkedIn URL', 'nebon'),
                    'id'   => 'team_linkedin',
                    'type' => 'url',
                ],
                [
                    'name' => __('Instagram URL', 'nebon'),
                    'id'   => 'team_instagram',
                    'type' => 'url',
                ],
                [
                    'type' => 'heading',
                    'name' => __('Contact Form', 'nebon'),
                ],
                [
                    'name' => __('Contact Title', 'nebon'),
                    'id'   => 'team_contact_title',
                    'type' => 'text',
                    'std'  => __("Let’s Get in Touch", 'nebon'),
                ],
                [
                    'name' => __('Contact Description', 'nebon'),
                    'id'   => 'team_contact_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'std'  => __('The point of using Lorem Ipsum is that it has more-or-less normal', 'nebon'),
                ],
                [
                    'name' => __('Contact Form 7 Shortcode', 'nebon'),
                    'id'   => 'team_contact_form_shortcode',
                    'type' => 'text',
                    'desc' => __('Example: [contact-form-7 id="456" title="Get In Touch"]', 'nebon'),
                ],
                [
                    'type' => 'heading',
                    'name' => __('Education & Guidelines', 'nebon'),
                ],
                [
                    'name' => __('Education 1 Logo', 'nebon'),
                    'id'   => 'team_education_1_logo',
                    'type' => 'single_image',
                ],
                [
                    'name' => __('Education 1 Title', 'nebon'),
                    'id'   => 'team_education_1_title',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 1 Description', 'nebon'),
                    'id'   => 'team_education_1_description',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 2 Logo', 'nebon'),
                    'id'   => 'team_education_2_logo',
                    'type' => 'single_image',
                ],
                [
                    'name' => __('Education 2 Title', 'nebon'),
                    'id'   => 'team_education_2_title',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 2 Description', 'nebon'),
                    'id'   => 'team_education_2_description',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 3 Logo', 'nebon'),
                    'id'   => 'team_education_3_logo',
                    'type' => 'single_image',
                ],
                [
                    'name' => __('Education 3 Title', 'nebon'),
                    'id'   => 'team_education_3_title',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 3 Description', 'nebon'),
                    'id'   => 'team_education_3_description',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 4 Logo', 'nebon'),
                    'id'   => 'team_education_4_logo',
                    'type' => 'single_image',
                ],
                [
                    'name' => __('Education 4 Title', 'nebon'),
                    'id'   => 'team_education_4_title',
                    'type' => 'text',
                ],
                [
                    'name' => __('Education 4 Description', 'nebon'),
                    'id'   => 'team_education_4_description',
                    'type' => 'text',
                ],
                [
                    'type' => 'heading',
                    'name' => __('Professional Skills', 'nebon'),
                ],
                [
                    'name' => __('Skills Description', 'nebon'),
                    'id'   => 'team_skills_description',
                    'type' => 'textarea',
                    'rows' => 3,
                ],
                [
                    'name' => __('Skill 1 Label', 'nebon'),
                    'id'   => 'team_skill_1_label',
                    'type' => 'text',
                ],
                [
                    'name' => __('Skill 1 Percentage', 'nebon'),
                    'id'   => 'team_skill_1_percentage',
                    'type' => 'number',
                    'min'  => 0,
                    'max'  => 100,
                    'std'  => 89,
                ],
                [
                    'name' => __('Skill 2 Label', 'nebon'),
                    'id'   => 'team_skill_2_label',
                    'type' => 'text',
                ],
                [
                    'name' => __('Skill 2 Percentage', 'nebon'),
                    'id'   => 'team_skill_2_percentage',
                    'type' => 'number',
                    'min'  => 0,
                    'max'  => 100,
                    'std'  => 97,
                ],
                [
                    'name' => __('Skill 3 Label', 'nebon'),
                    'id'   => 'team_skill_3_label',
                    'type' => 'text',
                ],
                [
                    'name' => __('Skill 3 Percentage', 'nebon'),
                    'id'   => 'team_skill_3_percentage',
                    'type' => 'number',
                    'min'  => 0,
                    'max'  => 100,
                    'std'  => 91,
                ],
            ],
        ];

        return $meta_boxes;
    }
}

MetaboxTeamMemberController::init();
