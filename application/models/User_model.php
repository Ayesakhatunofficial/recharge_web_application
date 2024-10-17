<?php
class User_model extends CI_Model
{
    public function getSubordinateDistributors($adminId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('created_by_id', $adminId);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result_array();

        $distributors = array();

        foreach ($result as $user) {
            if ($user['account_type'] == 2) {
                // If the user is a distributor, fetch their subordinates
                $user['subordinates'] = $this->getSubordinateDistributors($user['id']);
                $distributors[] = $user;
            } elseif ($user['account_type'] == 1) {
                // If the user is super distributor, fetch distributors under sd
                $user['subordinates'] = $this->getSubordinateDistributors($user['id']);
                $distributors = array_merge($distributors, $user['subordinates']);
            }
        }

        return $distributors;
    }


    public function getSubordinateRetailers($adminId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('created_by_id', $adminId);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result_array();

        $retailers = array();

        foreach ($result as $user) {
            if ($user['account_type'] == 3) {
                // If the user is a retailer, fetch their subordinates
                $user['subordinates'] = $this->getSubordinateRetailers($user['id']);
                $retailers[] = $user;
            } elseif ($user['account_type'] == 1 || $user['account_type'] == 2) {
                // If the user is a super distributor or distributor, fetch retailers under them
                $user['subordinates'] = $this->getSubordinateDistributors($user['id']);

                foreach ($user['subordinates'] as $subordinate) {
                    // Check if the subordinate is a retailer and fetch their subordinates
                    if ($subordinate['account_type'] == 3) {
                        $subordinate['subordinates'] = $this->getSubordinateRetailers($subordinate['id']);
                        $retailers = array_merge($retailers, $subordinate['subordinates']);
                    } elseif ($subordinate['account_type'] == 2) {
                        $subordinate['subordinates'] = $this->getSubordinateRetailers($subordinate['id']);

                        $retailers = array_merge($retailers, $subordinate['subordinates']);

                    }
                }
            }
        }

        return $retailers;
    }





}
