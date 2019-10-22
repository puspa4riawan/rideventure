<?php
require_once 'vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Gd\Font as ImageFont;

class Baseintervention
{
    protected $manager;
    public function __construct()
	{
        $this->manager = new ImageManager(array('driver' => 'gd'));
    }

    public function init()
    {
        $init = new ImageManager(array('driver' => 'gd'));
        return $init;
    }

    public function imageFont($font)
    {
        $image_font = new ImageFont($font);
        return $image_font;
    }
}