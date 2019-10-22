<?php defined('BASEPATH') or exit('No direct script access allowed');

class Theme_wyeth_milestone extends Theme
{
    public $name			= 'Wyeth Milestoe Themes';
    public $author			= 'ogilyoneid.com';
    public $author_website	= 'https://www.parentingclub.co.id/';
    public $website			= 'https://www.parentingclub.co.id/';
    public $description		= 'Wyeth Themes';
    public $version			= 'Wyeth Milestoe Themes';
    public $options         =  array(
        'home_title' => array(
            'title'         => 'Home Title',
            'description'   => 'Home Title',
            'default'       => '',
            'type'          => 'text',
            'options'       => '',
            'is_required'   => true
        ),
        'home_description' => array(
            'title'         => 'Home Description',
            'description'   => 'Home Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_consultation_title' => array(
            'title'         => 'Smart Consultation Title',
            'description'   => 'Smart Consultation Title',
            'default'       => '',
            'type'          => 'text',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_consultation_description' => array(
            'title'         => 'Smart Consultation Description',
            'description'   => 'Smart Consultation Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_consultation_qatitle' => array(
            'title'         => 'Smart Consultation QA Title',
            'description'   => 'Smart Consultation Qa Title',
            'default'       => '',
            'type'          => 'text',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_consultation_qadesc' => array(
            'title'         => 'Smart Consultation QA Description',
            'description'   => 'Smart Consultation QA Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_school_desc' => array(
            'title'         => 'Smart School Description',
            'description'   => 'Smart School Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_stories_title' => array(
            'title'         => 'Smart Stories Title',
            'description'   => 'Smart Stories Title',
            'default'       => '',
            'type'          => 'text',
            'options'       => '',
            'is_required'   => true
        ),
        'smart_stories_description' => array(
            'title'         => 'Smart Stories Description',
            'description'   => 'Smart Stories Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),
        'popup_asi' => array(
            'title'         => 'Pop Up Asi',
            'description'   => 'Pop Up Asi',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => true
        ),

        // meta data
        'home_metatitle' => array(
            'title'         => 'Home Meta Title',
            'description'   => 'Home Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'home_metakeyword' => array(
            'title'         => 'Home Meta Keyword',
            'description'   => 'Home Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'home_metadescription' => array(
            'title'         => 'Home Meta Description',
            'description'   => 'Home Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstrength_metatitle' => array(
            'title'         => 'Smartstrength Meta Title',
            'description'   => 'Smartstrength Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstrength_metakeyword' => array(
            'title'         => 'Smartstrength Meta Keyword',
            'description'   => 'Smartstrength Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstrength_metadescription' => array(
            'title'         => 'Smartstrength Meta Description',
            'description'   => 'Smartstrength Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstimulations_metatitle' => array(
            'title'         => 'Smartstimulations Meta Title',
            'description'   => 'Smartstimulations Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstimulations_metakeyword' => array(
            'title'         => 'Smartstimulations Meta Keyword',
            'description'   => 'Smartstimulations Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstimulations_metadescription' => array(
            'title'         => 'Smartstimulations Meta Description',
            'description'   => 'Smartstimulations Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        '8smartness_metatitle' => array(
            'title'         => '8 Smartness Meta Title',
            'description'   => '8 Smartness Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        '8smartness_metakeyword' => array(
            'title'         => '8 Smartness Meta Keyword',
            'description'   => '8 Smartness Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        '8smartness_metadescription' => array(
            'title'         => '8 Smartness Meta Description',
            'description'   => '8 Smartness Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartschool_metatitle' => array(
            'title'         => 'Smartschool Meta Title',
            'description'   => 'Smartschool Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartschool_metakeyword' => array(
            'title'         => 'Smartschool Meta Keyword',
            'description'   => 'Smartschool Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartschool_metadescription' => array(
            'title'         => 'Smartschool Meta Description',
            'description'   => 'Smartschool Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartconsultation_metatitle' => array(
            'title'         => 'Smartconsultation Meta Title',
            'description'   => 'Smartconsultation Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartconsultation_metakeyword' => array(
            'title'         => 'Smartconsultation Meta Keyword',
            'description'   => 'Smartconsultation Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartconsultation_metadescription' => array(
            'title'         => 'Smartconsultation Meta Description',
            'description'   => 'Smartconsultation Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstories_metatitle' => array(
            'title'         => 'Smartstories Meta Title',
            'description'   => 'Smartstories Meta Title',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstories_metakeyword' => array(
            'title'         => 'Smartstories Meta Keyword',
            'description'   => 'Smartstories Meta Keyword',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        ),
        'smartstories_metadescription' => array(
            'title'         => 'Smartstories Meta Description',
            'description'   => 'Smartstories Meta Description',
            'default'       => '',
            'type'          => 'textarea',
            'options'       => '',
            'is_required'   => false
        )
    );
}
