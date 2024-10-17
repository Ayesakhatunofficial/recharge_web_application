<?php
class Recharge1_model extends CI_Model
{
    public function getOperator()
    {
        $sql = "SELECT * from tbl_operator";
        return $this->db->query($sql)->result_array();
    }

    public function getUser($userid)
    {
        // echo $userid; die;
        return $this->db->query("SELECT * FROM users WHERE id = ?", [$userid])->row();
    }

    public function checkTransid($transid)
    {
        return $this->db->query("SELECT * FROM tbl_recharge WHERE trans_id = ?", [$transid])->row();
    }

    public function getCommission($opcode, $id, $slug, $service, $role_slug_id)
    {
        $result =  $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = ? 
            AND user_id = ? 
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$opcode, $id, $slug, $service, $role_slug_id]
        )->row();


        $result_1 =  $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = 'all' 
            AND user_id = ? 
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$id, $slug, $service, $role_slug_id]
        )->row();

        $result_2 =  $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = ?
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$opcode, $slug, $service, $role_slug_id]
        )->row();

        $result_3 = $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = 'all'
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$slug, $service, $role_slug_id]
        )->row();

        if (!is_null($result)) {
            return $result;
        } else if (!is_null($result_1)) {
            return $result_1;
        } else if (!is_null($result_2)) {
            return $result_2;
        } else if (!is_null($result_3)) {
            return $result_3;
        }
    }


    public function getRechargeList($recharge_by)
    {
        $sql = "SELECT
        tbl_operator.opcode,
        tbl_operator.operator,
        tbl_recharge.*
    FROM
        tbl_recharge
    JOIN tbl_operator ON tbl_recharge.operator_id = tbl_operator.opcode
    WHERE
        tbl_recharge.type = 'Mobile' AND tbl_recharge.recharge_by = $recharge_by
    ORDER BY
        tbl_recharge.id
    DESC
    LIMIT 10";

        return $this->db->query($sql)->result();
    }

    public function getData()
    {
        $sql = "SELECT
        tbl_operator.opcode,
        tbl_operator.operator,
        tbl_recharge.*
    FROM
        tbl_recharge
    JOIN tbl_operator ON tbl_recharge.operator_id = tbl_operator.opcode
    WHERE
        tbl_recharge.type = 'Mobile'
    ORDER BY
        tbl_recharge.id
    DESC
        ";

        return $this->db->query($sql)->result();
    }


    public function totalAmount()
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
    FROM
        tbl_recharge
    WHERE TYPE
        = 'Mobile' AND
    STATUS
        = 'SUCCESS'";
        return $this->db->query($sql)->row();
    }

    public function totalRechargeAmount($recharge_by)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
    FROM
        tbl_recharge
    WHERE TYPE
        = 'Mobile' AND
    STATUS
        = 'SUCCESS' AND recharge_by = $recharge_by";
        return $this->db->query($sql)->row();
    }



    public function getDthhisData($recharge_by)
    {
        $sql = "SELECT
        tbl_dth_operator.opcode,
        tbl_dth_operator.operator,
        tbl_recharge.*
    FROM
        tbl_recharge
    JOIN tbl_dth_operator ON tbl_recharge.operator_id = tbl_dth_operator.opcode
    WHERE
        tbl_recharge.type = 'DTH' AND tbl_recharge.recharge_by = $recharge_by
    ORDER BY
        tbl_recharge.id
    DESC";

        return $this->db->query($sql)->result();
    }


    public function totaldthrechAmount($recharge_by)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
    FROM
        tbl_recharge
    WHERE TYPE
        = 'DTH' AND
    STATUS
        = 'SUCCESS' AND recharge_by = $recharge_by";
        return $this->db->query($sql)->row();
    }



    public function getDTHData()
    {
        $sql = "SELECT
        tbl_dth_operator.opcode,
        tbl_dth_operator.operator,
        tbl_recharge.*
    FROM
        tbl_recharge
    JOIN tbl_dth_operator ON tbl_recharge.operator_id = tbl_dth_operator.opcode
    WHERE
        tbl_recharge.type = 'DTH'
    ORDER BY
        tbl_recharge.id
    DESC ";
        return $this->db->query($sql)->result();
    }



    public function totalDTHAmount()
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
    FROM
        tbl_recharge
    WHERE TYPE
        = 'DTH' AND
    STATUS
        = 'SUCCESS'";
        return $this->db->query($sql)->row();
    }


    public function getDthOperator()
    {
        $sql = "SELECT * from tbl_dth_operator";
        return $this->db->query($sql)->result_array();
    }
}
