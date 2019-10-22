<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author		MaxCMS Dev Team
 * @package		MaxCMS\Core\Modules\Users\Models
 */
class Profile_m extends MY_Model
{
	/**
	 * Get a user profile
	 *
	 *
	 * @param array $params Parameters used to retrieve the profile
	 * @return object
	 */
	public function get_profile($params = array())
	{
		$query = $this->db->get_where('profiles', $params);

		return $query->row();
	}

	public function get_profile_new($params = array())
	{
		$query = $this->db->select('profiles.*, users.email')
						  ->join('users', 'profiles.user_id=users.id', 'left')
						  ->get_where('profiles', $params);

		return $query->row();
	}

	public function get_child($params = array()){
		$query = $this->db->query('SELECT *, DATEDIFF("'.date('Y-m-d').'", dob) as age FROM default_users_child c WHERE c.user_id='.$params['user_id'].' ORDER BY age DESC');

		return $query;
	}

	public function update_data($table, $data, $params) {
        return $this->db->update($table, $data, $params);
    }

	public function delete_data($table, $params){
        return $this->db->delete($table, $params);
    }

    public function get_notif($id, $params=array(), $pagination = array()){
    	$query = 'SELECT * FROM
				  (SELECT
				    `ac`.*,
				    `a`.`title`,
				    `a`.`authors_id` AS `article_author`,
				    `a`.`intro`,
				    `p`.`display_name`
				  FROM
				    `default_article_comments` `ac`
				    LEFT JOIN `default_article` `a`
				      ON `ac`.`article_id` = `a`.`article_id`
				    LEFT JOIN `default_profiles` `p`
				      ON `ac`.`authors_id` = `p`.`user_id`
				  WHERE `ac`.`authors_id` = '.$id.' AND `ac`.`status` = "live"
				    OR `a`.`authors_id` = '.$id.'
				  UNION
				  ALL
				  SELECT
				    `ac`.*,
				    `a`.`title`,
				    `a`.`authors_id` AS `article_author`,
				    `a`.`intro`,
				    `p`.`display_name`
				  FROM
				    `default_article_comments` `ac`
				    LEFT JOIN `default_article` `a`
				      ON `ac`.`article_id` = `a`.`article_id`
				    LEFT JOIN `default_profiles` `p`
				      ON `ac`.`authors_id` = `p`.`user_id`
				  WHERE `ac`.`authors_id` = '.$id.' AND `ac`.`status` = "live"
				    OR `a`.`authors_id` = '.$id.') AS new_tab';

		if(isset($params['read_status'])){
			$query .= ' WHERE authors_read = 0'.$params['read_status'].' AND reply_read = '.$params['read_status'];
		}

		$query .= ' GROUP BY comments_id';
		$query .= ' ORDER BY comments_id DESC';
		if(isset($pagination['limit'])){
			$query .= ' LIMIT '.$pagination['limit'].' OFFSET '.$pagination['offset'];
		}

		return $this->db->query($query);
    }

    public function get_ae_notif($user_id = 0, $params = array())
    {
        $result = array();
        $this->db->select('default_ae_ask.*, default_ae_notif_answers.notif_read, default_ae_notif_answers.answer_id, default_ae_doctor_specialities.speciality_slug')
            ->from('default_ae_notif_answers')
            ->join('default_ae_ask', 'default_ae_notif_answers.ask_id=default_ae_ask.ask_id', 'left')
            ->join('default_ae_doctors', 'default_ae_doctors.doctor_id=default_ae_ask.doctor_id', 'left')
            ->join('default_ae_doctor_specialities', 'default_ae_doctors.speciality_id=default_ae_doctor_specialities.speciality_id', 'left');

        if(array_key_exists('notif_read',$params)){
            if(isset($params['notif_read'])){
                $this->db->where('default_ae_notif_answers.notif_read', $params['notif_read']);
            }
        }

        if(isset($user_id)){
            $this->db->where('default_ae_ask.user_id', $user_id);
            $this->db->where('default_ae_notif_answers.user_id', $user_id);
        }

        $result = $this->db->get();

        return $result;
    }

    public function get_report($params = array()){
    	$query = "SELECT *
					FROM
					  (SELECT
					    u.id AS user_id,
					    p.display_name,
						p.first_name,
						p.last_name,
					    p.gender,
					    p.dob,
					    p.phone,
					    p.bio,
					    p.profesi,
					    u.last_login,
					    u.created_on,
					    u.active,
					    u.email,
					    uc.id AS child_id,
					    uc.name AS child_name,
					    uc.gender AS child_gender,
					    tab_3.result_id AS quiz_id,
					    tab_3.date AS quiz_date,
					    tab_3.status AS quiz_status,
					    GROUP_CONCAT(smartness) AS top_smartness,
					    IFNULL(
					      (SELECT
					        created_at
					      FROM
					        default_ability_finder_events ae
					      WHERE ae.event_slug = 'download_twentyone_top3'
					        AND ae.user_id = tab_3.usr_id
					      ORDER BY ae.created_at ASC
					      LIMIT 1),
					      '-'
					    ) AS download_twentyone
					  FROM
					    (SELECT
					      r.*,
					      tab_2.title AS smartness,
					      tab_2.result_id
					    FROM
					      default_ability_finder_result r
					      JOIN
					        (SELECT
					          rd.*,
					          SUM(rd.result) AS total,
					          sc.title
					        FROM
					          default_ability_finder_result_detail rd
					          JOIN default_ability_finder_smart_categories sc
					            ON rd.cat_id = sc.id
					        GROUP BY rd.cat_id,
					          rd.result_id) AS tab_2
					        ON r.id = tab_2.result_id
					    ORDER BY tab_2.total DESC) AS tab_3
					    LEFT JOIN default_users u
					      ON u.id = tab_3.usr_id
					    JOIN default_profiles p
					      ON p.user_id = tab_3.usr_id
					  WHERE u.group_id != 1";

			if(isset($params['date_start'])){
				$query .= " AND tab_3.date >= '".$params['date_start']."'";
			}

			if(isset($params['date_end'])){
				$query .= " AND tab_3.date <= '".$params['date_end']."'";
			}

			if(isset($params['status'])){
				$query .= " AND tab_3.status = '".$params['status']."'";
			}

			$query .= " GROUP BY tab_3.result_id) AS tab GROUP BY user_id, child_id, quiz_id";
			//var_dump($query);
			//die();
		return $this->db->query($query)->result_array();
    }

    public function get_report_user($params){
    	$this->db->select('u.id, u.email, u.group_id, u.username, u.active, u.created_on, u.last_login,	p.display_name, p.first_name, p.last_name, p.gender, p.company, p.bio, p.phone, p.profesi')
    			 ->from('users u')
    			 ->join('profiles p', 'u.id=p.user_id', 'LEFT');

        $between = false;

        if (isset($params['date_start']) && isset($params['date_end'])) {
            $this->db->where('p.created BETWEEN "'.$params['date_start'] .'" AND "'. $params['date_end'] .'"');
            $between = true;
        }

        if ($between == false) {
            if(isset($params['date_start'])){
                $this->db->where('p.created >=', $params['date_start']);
            }

            if(isset($params['date_end'])){
                $this->db->where('p.created <=', $params['date_end']);
            }
        }

		if(isset($params['status'])){
			$this->db->where('u.active', $params['status']);
		}

		return $this->db->get()->result();
    }

    public function get_report_oneyearchild($params){
    	// $query  = 'SELECT uc.name, uc.gender, uc.dob, p.display_name as parent_name, p.phone, u.email, r.top_smartness, DATEDIFF("'.date('Y-m-d').'", uc.dob) as age';
        // $query .= ' FROM default_users_child uc';
        // $query .= ' LEFT JOIN default_profiles p ON p.user_id=uc.user_id';
        // $query .= ' LEFT JOIN default_users u ON uc.user_id=u.id';
        // $query .= ' LEFT JOIN default_ability_finder_report r ON uc.user_id=r.user_id and uc.id=child_id';

        // if (count($params) != 0) {
        // 	$between = false;
        // 	if (isset($params['date_start']) && isset($params['date_end'])) {
        // 		$query .= ' WHERE p.created BETWEEN "'.$params['date_start']. '" AND "'.$params['date_end'].'"';
        // 		$between = true;
        // 	}

        // 	if ($between == false) {
        // 		if(isset($params['date_start'])){
		//     		$query .= ' WHERE p.created >= "'.$params['date_start'].'"';
		//     	}

		//     	if(isset($params['date_end'])){
		//     		$query .= ' WHERE p.created <= "'.$params['date_end'].'"';
		// 		}
        // 	}
        // }


        // $query .= ' GROUP BY uc.id';
        // $query .= ' HAVING age >= 365';

        // $query .= ' ORDER BY p.user_id AND r.quiz_date ASC';

		// return $this->db->query($query)->result();

		return array();
    }

    public function get_report_oneyearchild_noquiz($params){
        // $query  = 'SELECT uc.name, uc.gender, uc.dob, p.display_name as parent_name, p.phone, u.email, DATEDIFF("'.date('Y-m-d').'", uc.dob) as age';
        // $query .= ' FROM default_users_child uc';
        // $query .= ' LEFT JOIN default_profiles p ON p.user_id=uc.user_id';
        // $query .= ' LEFT JOIN default_users u ON uc.user_id=u.id';

        // if (count($params) != 0) {
        //     $between = false;
        //     if (isset($params['date_start']) && isset($params['date_end'])) {
        //         $query .= ' WHERE p.created BETWEEN "'.$params['date_start']. '" AND "'.$params['date_end'].'"';
        //         $between = true;
        //     }

        //     if ($between == false) {
        //         if(isset($params['date_start'])){
        //             $query .= ' WHERE p.created >= "'.$params['date_start'].'"';
        //         }

        //         if(isset($params['date_end'])){
        //             $query .= ' WHERE p.created <= "'.$params['date_end'].'"';
        //         }
        //     }
        // }


        // $query .= ' GROUP BY uc.id';
        // $query .= ' HAVING age >= 365';

        // $query .= ' ORDER BY p.user_id ASC';

		// return $this->db->query($query)->result();
		
		return array();
    }

    public function get_complete_report($params=array()){
    	$query = "SELECT ar.*, IFNULL( (SELECT created_at FROM default_ability_finder_events ae WHERE ae.event_slug = 'download_twentyone_top3' AND ae.user_id = ar.user_id ORDER BY ae.created_at ASC LIMIT 1), '-' ) AS download_twentyone FROM default_ability_finder_report ar";

    	$where = ' WHERE';
    	if(isset($params['date_start'])){
    		$query .= $where.' quiz_date >= "'.$params['date_start'].'"';
    		$where = ' AND';
		}

		if(isset($params['date_end'])){
			$query .= $where.' quiz_date <= "'.$params['date_end'].'"';
		}

		return $this->db->query($query)->result_array();
    }

    public function register_log($name, $email, $reason, $phone='-', $email_reg='-'){
    	$data = array(
    				'name' => $name,
    				'email' => $email,
    				'phone' => $phone,
    				'email_reg' => $email_reg,
    				'reason' => $reason,
    				'created_at' => date('Y-m-d H:i:s'),
    			);

    	$this->db->insert('register_log', $data);
    	return $this->db->insert_id();
    }

    public function login_log($name='-', $email, $reason){
    	$data = array(
    				'name' => $name,
    				'email' => $email,
    				'reason' => $reason,
    				'created_at' => date('Y-m-d H:i:s'),
    			);

    	$this->db->insert('login_log', $data);
    	return $this->db->insert_id();
    }

    public function get_log($table='login', $params = array()){
    	$this->db
    		 ->select('*')
    		 ->from($table.'_log');

    	if(isset($params['keywords'])){
    		$this->db->like('name', $params['keywords'])
    				 ->or_like('email', $params['keywords']);
    				 // ->or_like('phone', $params['keywords']);
    	}

    	if(isset($params['from'])){
    		$this->db->where('created_at >=', $params['from']);
    	}

    	if(isset($params['to'])){
    		$this->db->where('created_at <=', $params['to']);
    	}

    	$this->db->order_by('id', 'DESC');
		return $this->db->get();
	}

	public function get_single_log($table, $params){
        $this->db->select('*, users.salt, users.email')
                 ->from($table)
                 ->join('users', $table.'.email=users.email', 'left')
                 ->where($params);

        return $this->db->get()->row();
    }

    public function get_single_user($table, $params){
        $this->db->select('*, users.salt, users.email')
                 ->from($table)
                 ->join('users', $table.'.user_id=users.id', 'left')
                 ->where($params);

        return $this->db->get()->row();
    }

    public function set_active($email){
    	$query = "UPDATE default_users JOIN default_profiles ON default_users.id = default_profiles.user_id SET `default_users`.`active` = 1, `default_profiles`.`password_temp` = 0 WHERE `default_users`.`email` = '".$email."'";

    	return $this->db->query($query);
    }

    public function get_count($params=array()){
    	// $query  = 'SELECT id, count(id) as kids_count FROM (';
    	// $query .= 'SELECT u.id, DATEDIFF("'.date('Y-m-d').'", uc.dob)/365 as age';
        // $query .= ' FROM default_users u';
        // // $query .= ' JOIN default_users_child uc ON uc.user_id=u.id';

        // $where = ' WHERE';
    	// if(isset($params['from'])){
    	// 	$query .= $where.' u.created_on >='.strtotime($params['from'].' 00:00:00');
        // 	$where = ' AND';
    	// }

    	// if(isset($params['to'])){
    	// 	$query .= $where.' u.created_on <='.strtotime($params['to'].' 24:00:00');
    	// }

    	// if(isset($params['kidsage'])){
    	// 	if($params['kidsage']==1){
        // 		$query .= ' HAVING age >=0 AND age < 3';
    	// 	}else if($params['kidsage']==2){
        // 		$query .= ' HAVING age >= 3 AND age < 5';
    	// 	}else if($params['kidsage']==3){
        // 		$query .= ' HAVING age >= 5';
    	// 	}
    	// }

    	// $query .= ') AS tab';
    	// $query .= ' GROUP BY id';

    	// if(isset($params['kids'])){
    	// 	if($params['kids']==3){
        // 		$query .= ' HAVING kids_count >= 3';
    	// 	}else{
        // 		$query .= ' HAVING kids_count ='.$params['kids'];
    	// 	}
    	// }

		// return $this->db->query($query);

		return null;
    }

    public function nokid_count($params=array()){
    	// $this->db
    	// 	 ->select('count(uc.id) as count')
    	// 	 ->from('users u')
    	// 	 ->join('users_child uc', 'uc.user_id=u.id', 'left')
    	// 	 ->group_by('u.id');

    	// if(isset($params['from'])){
    	// 	$this->db->where('u.created_on >=', strtotime($params['from'].' 00:00:00'));
    	// }

    	// if(isset($params['to'])){
    	// 	$this->db->where('u.created_on <=', strtotime($params['to'].' 00:00:00'));
    	// }

    	// $this->db->having('count', 0);

		// return $this->db->get();
		
		return null;
    }

    public function pregnant_count($params=array()){
    	$this->db
    		 ->select('count(user_id) as count')
    		 ->from('profiles')
    		 ->where('pregnant', 1);

    	if(isset($params['from'])){
    		$this->db->where('created >=', $params['from'].' 00:00:00');
    	}

    	if(isset($params['to'])){
    		$this->db->where('created <=', $params['to'].' 00:00:00');
    	}

    	return $this->db->get();
    }

    public function get_parents_counter($params = array())
    {
        $this->db
            ->select('*')
            ->from('users u')
            ->join('profiles p', 'p.user_id = u.id', 'left');

        if (isset($params['group_id'])) {
            $this->db->where('u.group_id', $params['group_id']);
        }

        if (isset($params['active'])) {
            $this->db->where('u.active', $params['active']);
        }

        if (isset($params['gender'])) {
            $this->db->where('p.gender', $params['gender']);
        }

        return $this->db->get();
    }
}
