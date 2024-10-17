<?php
class Recharge_model extends CI_Model
{
    public function getSubordinateUsers($adminId)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('created_by_id', $adminId);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();

        $mobileNumbers = array();

        foreach ($result as $user) {
            $mobileNumbers[] = $user->mobile;
        }

        foreach ($result as $user) {
            $mobileNumbers = array_merge($mobileNumbers, $this->getSubordinateUsers($user->id));
        }

        return $mobileNumbers;
    }



    public function getRechargeDataByMobileNumbers($mobileNumbers)
    {
        $this->db->select('tbl_operator.id as oprator_id,
        tbl_operator.op_logo,
        tbl_operator.opcode,
        tbl_operator.operator,
        tbl_recharge.*');
        $this->db->from('tbl_recharge');
        $this->db->join('tbl_operator', 'tbl_recharge.operator_id = tbl_operator.opcode');
        $this->db->where_in('tbl_recharge.recharge_by', $mobileNumbers);
        $this->db->where('tbl_recharge.type', 'Mobile');
        $this->db->order_by('tbl_recharge.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    public function totalMobileRechargeAmount($mobileNumbers)
    {
        $this->db->select('
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
     ');

        $this->db->from('tbl_recharge');
        $this->db->where('type', 'Mobile');
        $this->db->where('status', 'SUCCESS');
        $this->db->where_in('recharge_by', $mobileNumbers);

        return $this->db->get()->row();
    }


    public function getRechargeList($recharge_by)
    {
        $sql = "SELECT
        tbl_operator.opcode,
        tbl_operator.operator,
        tbl_operator.op_logo,
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


    public function totalRechargeAmount($recharge_by)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit,
        SUM('admin_profit') AS t_admin_profit,
        COUNT('admin_profit') AS t_admin_count
     FROM
        tbl_recharge
     WHERE TYPE
        = 'Mobile' AND
     STATUS
        = 'SUCCESS' AND recharge_by = $recharge_by";
        return $this->db->query($sql)->row();
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


    public function getDthDataByMobile($mobileNumbers)
    {
        $this->db->select('tbl_dth_operator.id as operator_id,
        tbl_dth_operator.opcode,
        tbl_dth_operator.op_logo,
        tbl_dth_operator.operator,
        tbl_recharge.*');
        $this->db->from('tbl_recharge');
        $this->db->join('tbl_dth_operator', 'tbl_recharge.operator_id = tbl_dth_operator.opcode');
        $this->db->where_in('recharge_by', $mobileNumbers);
        $this->db->where('tbl_recharge.type', 'DTH');
        $this->db->order_by('tbl_recharge.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    public function totalDthRechargeAmount($mobileNumbers)
    {
        $this->db->select('
        SUM(amount) AS total_amount,
        SUM(margin) AS total_margin,
        COUNT(margin) AS t_margin,
        SUM(profit) AS total_profit,
        SUM(api_commission) AS t_commission,
        COUNT(api_commission) AS t_com,
        SUM(api_profit) AS t_api_profit
     ');

        $this->db->from('tbl_recharge');
        $this->db->where('type', 'DTH');
        $this->db->where('status', 'SUCCESS');
        $this->db->where_in('recharge_by', $mobileNumbers);

        return $this->db->get()->row();
    }

    public function getDthhisData($recharge_by)
    {
        $sql = "SELECT
        tbl_dth_operator.opcode,
        tbl_dth_operator.operator,
        tbl_dth_operator.op_logo,
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



    public function getRechargeData($recharge_by)
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
        ";

        return $this->db->query($sql)->result();
    }



    public function getBalanceData()
    {
        $sql = "SELECT * FROM tbl_balance";
        return $this->db->query($sql)->row();
    }


    public function getReport($from_date, $to_date, $opcode)
    {
        $params = array($from_date, $to_date, $opcode, $opcode);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_operator.opcode,
                    tbl_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_operator ON tbl_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'Mobile'
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getMobReport($from_date, $to_date, $opcode, $recharge_by)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $recharge_by);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_operator.opcode,
                    tbl_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_operator ON tbl_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'Mobile'
                    AND recharge_by = ?
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getMobReportBYMobile($from_date, $to_date, $opcode, $users)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $users);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_operator.opcode,
                    tbl_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_operator ON tbl_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'Mobile'
                    AND tbl_recharge.recharge_by IN ?
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getDthReport($from_date, $to_date, $opcode)
    {
        $params = array($from_date, $to_date, $opcode, $opcode);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_dth_operator.opcode,
                    tbl_dth_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_dth_operator ON tbl_dth_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'DTH'
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getDthRechargeReport($from_date, $to_date, $opcode, $recharge_by)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $recharge_by);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_dth_operator.opcode,
                    tbl_dth_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_dth_operator ON tbl_dth_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'DTH'
                    AND tbl_recharge.recharge_by = ?
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }


    public function getDthRechargeReportBYMobile($from_date, $to_date, $opcode, $users)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $users);
        // print_r($params);die;
        $sql = "SELECT
                    tbl_dth_operator.opcode,
                    tbl_dth_operator.operator,
                    tbl_recharge.*
                FROM tbl_recharge
                JOIN tbl_dth_operator ON tbl_dth_operator.opcode = tbl_recharge.operator_id
                WHERE tbl_recharge.date BETWEEN ? AND ?
                    AND (tbl_recharge.operator_id = ? OR ? = '')
                    AND tbl_recharge.type = 'DTH'
                    AND tbl_recharge.recharge_by IN ?
                ORDER BY tbl_recharge.id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }




    public function getComReport()
    {
        $sql = "SELECT 
            SUM(api_profit) as api_profit, 
            SUM(profit) as profit ,
            `date`
        FROM 
            tbl_recharge WHERE status = 'SUCCESS'
        GROUP BY 
            `date`
        ORDER BY 
            `date` DESC";


        return $this->db->query($sql)->result();
    }

    public function getCommissionReport($from_date, $to_date)
    {
        $params = array($from_date, $to_date);
        // print_r($params);die;
        $sql = "SELECT 
            SUM(api_profit) as api_profit, 
            SUM(profit) as profit ,
            `date` 
        FROM tbl_recharge
        WHERE status = 'SUCCESS' AND date BETWEEN ? AND ?
        GROUP BY 
            `date`
        ORDER BY 
            `date` DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getUserComReport($mobile)
    {
        $sql = "SELECT 
            SUM(api_profit) as api_profit, 
            SUM(profit) as profit ,
            `date`
        FROM 
            tbl_recharge WHERE recharge_by = $mobile AND status = 'SUCCESS' 
        GROUP BY 
            `date`
        ORDER BY 
            `date` DESC";


        return $this->db->query($sql)->result();
    }

    public function getUserCommissionReport($from_date, $to_date, $mobile)
    {
        $params = array($mobile, $from_date, $to_date);
        // print_r($params);die;
        $sql = "SELECT 
            SUM(api_profit) as api_profit, 
            SUM(profit) as profit ,
            `date` 
        FROM tbl_recharge
        WHERE recharge_by = ? AND status = 'SUCCESS' AND date BETWEEN ? AND ?
        GROUP BY 
            `date`
        ORDER BY 
            `date` DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }


    public function getMobileRechargeList()
    {
    }
}
