<?php defined('BASEPATH') or exit('No Direct Script Access Allowed');

class Milestone
{
    private $data = array();
    private $data_name = 'milestone/data';
    private $data_id = array();
    private $data_id_name = 'milestone/data_id';

    function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('article_m');
        $this->ci->load->library('maxcache');
        $this->init();
    }

    public function init()
    {
        $this->data = $this->ci->maxcache->get($this->data_name);
        $this->data_id = $this->ci->maxcache->get($this->data_id_name);

        if (!$this->data) {
            $this->data = array();
            $this->data_id = array();
            $save = 0;

            $parameter = array(
                'status' => 'live',
                'global_milestone' => true,
            );
            $milestone = $this->ci->article_m->get_many_kidsage($parameter);

            foreach ($milestone as $value) {
                switch ($value->type) {
                    case 'prepregnancy':
                        $this->data['prakehamilan'][] = (array) $value;
                        $this->data_id['prakehamilan'][] = $value->kidsage_id;
                        break;
                    case 'trimester':
                        $this->data['kehamilan'][] = (array) $value;
                        $this->data_id['kehamilan'][] = $value->kidsage_id;
                        break;
                    case 'months':
                        $this->data['bayi'][] = (array) $value;
                        $this->data_id['bayi'][] = $value->kidsage_id;
                        break;
                    case 'years':
                        $this->data['anak'][] = (array) $value;
                        $this->data_id['anak'][] = $value->kidsage_id;
                        break;
                }
            }

            if ($this->data_id && isset($this->data_id['prakehamilan'])) {
                $this->data_id['prakehamilan'] = implode(',', $this->data_id['prakehamilan']);
                $save++;
            }

            if ($this->data_id && isset($this->data_id['kehamilan'])) {
                $this->data_id['kehamilan'] = implode(',', $this->data_id['kehamilan']);
                $save++;
            }

            if ($this->data_id && isset($this->data_id['bayi'])) {
                $this->data_id['bayi'] = implode(',', $this->data_id['bayi']);
                $save++;
            }

            if ($this->data_id && isset($this->data_id['anak'])) {
                $this->data_id['anak'] = implode(',', $this->data_id['anak']);
                $save++;
            }

            if ($save == 4) {
                $this->ci->maxcache->write($this->data, $this->data_name);
                $this->ci->maxcache->write($this->data_id, $this->data_id_name);
            }
        }
    }

    public function get_data()
    {
        if (!$this->data) {
            $this->init();
        }

        return $this->data;
    }

    public function get_data_name()
    {
        return $this->data_name;
    }

    public function get_data_id()
    {
        if (!$this->data_id) {
            $this->init();
        }

        return $this->data_id;
    }

    public function get_data_id_name()
    {
        return $this->data_id_name;
    }

    public function clear_data()
    {
        $this->ci->maxcache->delete($this->data_name);
        $this->ci->maxcache->delete($this->data_id_name);
    }
}
