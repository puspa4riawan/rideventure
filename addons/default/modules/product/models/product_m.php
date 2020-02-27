<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author  yudiantara.gde@gmail.com
 * @package PyroCMS\Core\Modules\Article\Models
 */
class Product_m extends MY_Model
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

	public function cheker_data($table, $params=array()){
		if(isset($params['article_id'])){
			$this->db->where($table.'.article_id', $params['article_id']);
		}

		if(isset($params['featured'])){
			$this->db->where($table.'.featured', $params['featured']);
		}

		if (isset($params['featured_milestone'])) {
			$this->db->where($table.'.featured_milestone', $params['featured_milestone']);
		}

		if(isset($params['featured_afs'])){
			$this->db->where($table.'.featured_afs', $params['featured_afs']);
		}

		return $this->db->get_where($table);
	}

	/* category */
    public function count_category($params = array()) {
		if ( ! empty($params['keywords'])) {
			$this->db
				->like('title', trim($params['keywords']));
		}

		if ( ! empty($params['slug'])) {
			$this->db
				->like('slug', trim($params['slug']));
		}

		if ( ! empty($params['status'])) {

			if ($params['status'] != 'all') {

				$this->db->where('status', $params['status']);
			}
		} else {

			$this->db->where('status', 'live');
		}

		if (isset($params['limit']) && is_array($params['limit'])) {

			$this->db->limit($params['limit'][0], $params['limit'][1]);

		}elseif (isset($params['limit'])) {

			$this->db->limit($params['limit']);
		}

		return $this->db->count_all_results('article_categories');
	}

	public function get_many_benner($params = array()) {

		if ( ! empty($params['keywords'])) {
			$this->db
				->like('title', trim($params['keywords']));
		}

		

		if ( ! empty($params['status'])) {
			if ($params['status'] != 'all') {
				$this->db->where('status', $params['status']);
			}
		} else {
			$this->db->where('status != ', 'all');
		}

		if (isset($params['limit']) && is_array($params['limit'])) {
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		} elseif (isset($params['limit'])) {
			$this->db->limit($params['limit']);		}

		return $this->get_all_benner();
	}

	public function get_by_category($params = array()) {
		if ( ! empty($params['keywords'])) {
			$this->db
				->like('title', trim($params['keywords']));
		}

		if ( ! empty($params['slug'])) {
			$this->db
				->like('slug', trim($params['slug']));
		}

		if ( ! empty($params['status'])) {
			if ($params['status'] != 'all') {
				$this->db->where('status', $params['status']);
			}
		} else {
			$this->db->where('status != ', 'all');
		}

		if (isset($params['limit']) && is_array($params['limit'])) {
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		} elseif (isset($params['limit'])) {
			$this->db->limit($params['limit']);		}

		return $this->db->get('article_categories')->row();
	}

	public function get_all_benner() {
	   $this->db
			->select('*')
			->order_by('id', 'ASC');

		return $this->db->get('benner')->result();
	}

	/* articles */
    public function count_data_table($params = array(),$tablename) {

		if ( ! empty($params['keywords'])) {
			$this->db->like($tablename.'.title', trim($params['keywords']));
		}

		$action = true;
		if(isset($params['date_start']) && isset($params['date_end'])){
            $this->db->where($tablename.'.created BETWEEN "'.$params['date_start'].'" AND "'.$params['date_end'].'"', '', FALSE);
            $action = false;
        }

        if ($action) {
            if (isset($params['date_start'])) {
                $this->db->where($tablename.'.created >=', $params['date_start']);
            }

            if (isset($params['date_end'])) {
                $this->db->where($tablename.'.created <=', $params['date_end']);
            }
        }

		if ( ! empty($params['status'])) {

			if ($params['status'] != 'all') {

				$this->db->where($tablename.'.status', $params['status']);
			}
		} else {

			$this->db->where($tablename.'.status', 'live');
		}

		


		if (isset($params['limit']) && is_array($params['limit'])) {

			$this->db->limit($params['limit'][0], $params['limit'][1]);

		}elseif (isset($params['limit'])) {

			$this->db->limit($params['limit']);
		}


		return $this->db->count_all_results($tablename.'');
	}

	public function get_many_datatable($params = array(),$tablename) {
		if ( ! empty($params['keywords'])) {
			$this->db
				->like($tablename.'.title', trim($params['keywords']));
		}

		$action = true;
		if(isset($params['date_start']) && isset($params['date_end'])){
            $this->db->where($tablename.'.created BETWEEN "'.$params['date_start'].'" AND "'.$params['date_end'].'"', '', FALSE);
            $action = false;
        }

        if ($action) {
            if (isset($params['date_start'])) {
                $this->db->where($tablename.'.created >=', $params['date_start']);
            }

            if (isset($params['date_end'])) {
                $this->db->where($tablename.'.created <=', $params['date_end']);
            }
        }

		if ( ! empty($params['status'])) {
			if ($params['status'] != 'all') {
				$this->db->where($tablename.'.status', $params['status']);
			}
		} else {
			$this->db->where($tablename.'.status !=', 'all');
		}

		if (isset($params['limit']) && is_array($params['limit'])) {
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		} elseif (isset($params['limit'])) {
			$this->db->limit($params['limit']);
		}

		if (isset($params['order']) && is_array($params['order'])) {
			$this->db->order_by($tablename.'.'.$params['order'][0], $params['order'][1]);
		} elseif (isset($params['order'])) {
			$this->db->order_by($tablename.'.article_id', 'DESC');
		}

		return $this->db->get($tablename)->result();
	}

	public function get_related_articles($params = array()) {
		/*if (!empty($params['status'])) {
			if ($params['status'] != 'all') {
				$this->db->where('article.status', $params['status']);
			}
		} else {
			$this->db->where('article.status', 'live');
		}
		if ( ! empty($params['categories'])) {
			$categories = explode(",", $params['categories']);
			foreach ($categories as $value) {
				$this->db->or_like('article.categories_id', $value);
			}
		}

		if ( ! empty($params['kidsage'])) {
			$kidsage = explode(",", $params['kidsage']);
			foreach ($kidsage as $value) {
				$this->db->or_like('article.kidsage_id', $value);
			}
		}

		if (isset($params['limit']) && is_array($params['limit'])) {
			$this->db->limit($params['limit'][0], $params['limit'][1]);
		}
		elseif (isset($params['limit'])) {
			$this->db->limit($params['limit']);
		}
		return $this->get_all_articles();*/

		if(!array_key_exists('status', $params)) {
			$params['status'] = 'live';
		}

		if(!array_key_exists('not_article_id', $params)) {
			$params['not_article_id'] = 0;
		}

		if(!array_key_exists('limit', $params)) {
			$params['limit'] = 0;
		}

		$query = "SELECT `default_article`.*, `default_article_categories`.`title` as `categories`, `default_article_categories`.`slug` as `categories_slug`, `default_article_categories`.`filename` as `cat_icon`, `default_article_categories`.`full_path` as `cat_icon_fullpath`, `default_article_kidsage`.`title` as `kidsage`, `default_article_kidsage`.`slug` as `kidsage_slug`, `default_profiles`.`first_name` as `first_name`, `default_profiles`.`last_name` as `last_name` FROM `default_article` LEFT JOIN `default_article_categories` ON `default_article`.`categories_id` = `default_article_categories`.`categories_id` LEFT JOIN `default_article_kidsage` ON `default_article`.`kidsage_id` = `default_article_kidsage`.`kidsage_id` LEFT JOIN `default_profiles` ON `default_article`.`authors_id` = `default_profiles`.`user_id` WHERE `default_article`.`article_id` <> '".$params['not_article_id']."' AND `default_article`.`status` = '".$params['status']."'";

		if ( ! empty($params['categories'])) {
			$categories = explode(",", $params['categories']);
			$query .= ' AND ';
			$query .= ' (`default_article`.`categories_id` LIKE "%'.$categories[0].'%")';
			/*$query .= ' OR ';
			foreach ($categories as $keyc=>$value) {
				if($keyc==0) {
					$query .= ' (`default_article`.`categories_id` LIKE "%'.$value.'%")';
				} else {
				$query .= ' OR ';
					$query .= ' (`default_article`.`categories_id` LIKE "%'.$value.'%")';
				}
			}*/
		}
		
		if ($params['limit'] > 0) {
			if (isset($params['random'])) {
				$query .= ' ORDER BY RAND() LIMIT '.$params['limit'];
			} else {
				$query .= ' ORDER BY `article_id` DESC LIMIT '.$params['limit'];
			}
		} else {
			$query .= ' ORDER BY `article_id` DESC';
		}

		$array = new stdClass();
		$exe_query = $this->db->query($query)->result();
		if($exe_query){
			$array = $exe_query;
		}
		return $array;
	}

	public function get_all_articles() {
		$array=new stdClass();

		$this->db
			 ->select('
				article.*,
				category.name as categories
			 ')
			 ->join('category', 'article.categories_id = category.id');
			 // ->join('article_kidsage', 'article.kidsage_id = article_kidsage.kidsage_id', 'left')
			 // ->join('profiles', 'article.authors_id = profiles.user_id', 'left');
		$query = $this->db->get('article')->result();
		if($query){
			$array=$query;
		}
		return $array;
	}

	public function get_single_articles(){

       $this->db
			 ->select('
				article.*,
				article_categories.title as categories,
				article_categories.slug as categories_slug,
				article_categories.filename as cat_icon,
				article_categories.full_path as cat_icon_fullpath,
				article_kidsage.title as kidsage,
				article_kidsage.slug as kidsage_slug,
			 ')

			 ->join('article_categories', 'article.categories_id = article_categories.categories_id', 'left')
			 ->join('article_kidsage', 'article.kidsage_id = article_kidsage.kidsage_id', 'left');
			 // ->join('article_authors', 'article.authors_id = article_authors.authors_id', 'left');

        return $this->db->get('article')->row();
    }

	function insert_article_img($data){
    	$this->db->insert('article_images', $data);
        return $this->db->insert_id();
    }

	public function check_exists($table, $params=array()) {
		if ( ! empty($params['title'])) {
			$this->db->where($table.'.title', $params['title']);
		}

		if ( ! empty($params['slug'])) {
			$this->db->where($table.'.slug', $params['slug']);
		}

		if ( ! empty($params['id'])) {
			$this->db->where($table.'.id !=', $params['id']);
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

	private function indo_date($format, $date="now", $lang="id"){
		$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb",
		"Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

		$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
		"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September",
		"Oktober","November","Desember");

		return str_replace($en,$$lang,date($format,strtotime($date)));
	}

	public function getDataForExport($params = array())
	{
		$result = array();

		// $this->db
		// 	->select('a.*, p.display_name as authors_id')
		// 	->from('article a')
		// 	->join('profiles p', 'p.user_id = a.authors_id');
		$this->db
			->select('a.*')
			->from('article a');
			// ->join('profiles p', 'p.user_id = a.authors_id');

		if (isset($params['status'])) {
			$this->db->where('a.status', $params['status']);
		}

		$articles = $this->db->get()->result();

		foreach ($articles as $key => $article) {
			$article->categories_id = $this->getCategoriesName($article->article_id);
			// $article->kidsage_id = $this->getKidsageName($article->article_id);

			$result[] = $article;
		}

		return $result;
	}

	private function getCategoriesName($id)
	{
		$sql = 'select
				    group_concat(ac.name) as categories_id
				from
				    default_article a
				    join default_category ac on find_in_set(ac.id, a.categories_id) > 0
			    where
			    	a.article_id = '.$id.'
				group by
				    a.article_id';
	    $query = $this->db->query($sql)->row();

	    return $query ? $query->categories_id : '';
	}

	private function getKidsageName($id)
	{
		$sql = 'select
				    group_concat(ak.title) as kidsage_id
				from
				    default_article a
				    join default_article_kidsage ak on find_in_set(ak.kidsage_id, a.kidsage_id) > 0
			    where
			    	a.article_id = '.$id.'
				group by
				    a.article_id';
	    $query = $this->db->query($sql)->row();

	    return $query ? $query->kidsage_id : '';
	}

	public function get_images_for_article($id)
	{
		return $this->db
			->select('full_path')
			->where('article_id', $id)
			->where('ftype', 'img')
			->or_where('ftype', 'carousel')
			->get('article_files')
			->result();
	}
}
