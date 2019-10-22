<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author  yudiantara.gde@gmail.com
 * @package PyroCMS\Core\Modules\Article\Models
 */
class Rewards_m extends MY_Model
{
	/* general */

	public function insert_data($table, $data){

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function update_data($table, $data, $field, $id){
        return $this->db->update($table, $data, $field.' = '.$id);
    }

    public function get_single_data($field, $id, $table){
        $this->db->where($field, $id);
        return $this->db->get($table)->row();
    }

    public function get_all_data($table){
        $this->db
			->select('*');

		return $this->db->get($table)->result();
    }

    public function get_all_data_join($table){

        //$this->db
			//->select('*');

		return $this->db->get($table)->result();
    }

    public function delete_data($table, $field, $id){
        return $this->db->delete($table, array($field=>$id));
    }

    public function count_data($table) {

		return $this->db->count_all_results($table);
	}

	public function publish_data($table, $field, $id = 0) {

		return $this->db->update($table, array('status' => 'live'), $field.' = '.$id);
	}

	public function unpublish_data($table, $field, $id = 0) {

		return $this->db->update($table, array('status' => 'draft'), $field.' = '.$id);
	}

	

	/* comments */
   
   	public function set_filter($params = array()){
   		if ( ! empty($params['keywords'])) {

			$this->db
				->like('rewards.title', trim($params['keywords']));
		}

		$action = true;
		if(isset($params['date_start']) && isset($params['date_end'])){
            $this->db->where('rewards.created BETWEEN "'.$params['date_start'].'" AND "'.$params['date_end'].'"', '', FALSE);
            $action = false;
        }

        if ($action) {
            if (isset($params['date_start'])) {
                $this->db->where('rewards.created >=', $params['date_start']);
            }

            if (isset($params['date_end'])) {
                $this->db->where('rewards.created <=', $params['date_end']);
            }
        }

		if ( ! empty($params['status'])) {

			if ($params['status'] != 'all') {

				$this->db->where('rewards.status', $params['status']);
			}
		} else {

			$this->db->where('rewards.status', 'live');
		}

		if (isset($params['limit']) && is_array($params['limit'])) {

			$this->db->limit($params['limit'][0], $params['limit'][1]);

		}elseif (isset($params['limit'])) {

			$this->db->limit($params['limit']);
		}
   	}

	

	

    public function del_data($table, $where){
        return $this->db->delete($table, $where);
    }

    

	public function check_exists($table, $params=array()) {
		if ( ! empty($params['title'])) {
			$this->db->where($table.'.title', $params['title']);
		}

		if ( ! empty($params['slug'])) {
			$this->db->where($table.'.slug', $params['slug']);
		}

		if ( ! empty($params['article_id'])) {
			$this->db->where($table.'.article_id !=', $params['article_id']);
		}

		if ( ! empty($params['ads_id'])) {
			$this->db->where($table.'.ads_id !=', $params['ads_id']);
		}

		if ( ! empty($params['livetv_id'])) {
			$this->db->where($table.'.id !=', $params['livetv_id']);
		}

		if ( ! empty($params['kidsage_id'])) {
			$this->db->where($table.'.kidsage_id !=', $params['kidsage_id']);
		}

		if ( ! empty($params['categories_id'])) {
			$this->db->where($table.'.categories_id !=', $params['categories_id']);
		}

		return $this->db->count_all_results($table) == 0;
	}

	//--- TAMBAHAN EMAIL NOTIF
		public function get_single_user($params, $table){
				$this->db->where($params);
				return $this->db->get($table)->row();
		}

	

}
