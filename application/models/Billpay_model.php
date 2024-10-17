<?php
class Billpay_model extends CI_Model
{

    public function getUser($userid)
    {
        // echo $userid; die;
        return $this->db->query("SELECT * FROM users WHERE id = ?", [$userid])->row();
    }


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

    public function getElectricDataByMobile($mobileNumbers)
    {
        $this->db->select('*');
        $this->db->from('tbl_electric_bill_pay');
        $this->db->where_in('pay_by', $mobileNumbers);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function totalBillAmountByMobile($mobileNumbers)
    {
        $this->db->select(
            'SUM(amount) AS total_amount,
            SUM(profit) AS total_profit'
        );
        $this->db->from('tbl_electric_bill_pay');
        $this->db->where('trans_status_code', 1);
        $this->db->where_in('pay_by', $mobileNumbers);

        return $this->db->get()->row();
    }


    public function getService()
    {
        $sql = "SELECT * FROM tbl_services";
        return $this->db->query($sql)->result();
    }
    public function getData()
    {
        $sql = "SELECT * FROM tbl_settings";
        return $this->db->query($sql)->row();
    }

    public function getBillPayData()
    {
        $sql = "SELECT * FROM tbl_electric_bill_pay ORDER BY id DESC";
        return $this->db->query($sql)->result();
    }

    public function getElectricData($pay_by)
    {
        $sql = "SELECT * FROM tbl_electric_bill_pay WHERE pay_by = $pay_by ORDER BY id DESC";
        return $this->db->query($sql)->result();
    }

    public function getBalanceData()
    {
        $sql = "SELECT * FROM tbl_utility_balance";
        return $this->db->query($sql)->row();
    }

    public function totalAmount()
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(profit) AS total_profit,
        SUM(dr) AS total_api_profit
     FROM
        tbl_electric_bill_pay WHERE trans_status_code = 1";
        return $this->db->query($sql)->row();
    }

    public function totalBillAmount($pay_by)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(profit) AS total_profit
     FROM
        tbl_electric_bill_pay
     WHERE
        pay_by = $pay_by AND trans_status_code = 1";
        return $this->db->query($sql)->row();
    }

    public function getApi()
    {
        $sql = "SELECT * FROM tbl_utility_api";
        return $this->db->query($sql)->row();
    }

    public function getElectricReport($from_date, $to_date, $opcode)
    {
        $params = array($from_date, $to_date, $opcode, $opcode);
        // print_r($params);die;
        $sql = "SELECT *
                FROM tbl_electric_bill_pay
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getElectricBillReport($from_date, $to_date, $opcode, $pay_by)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $pay_by);
        // print_r($params);die;
        $sql = "SELECT *
                FROM tbl_electric_bill_pay
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                    AND pay_by = ?
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }


    public function getElectricPayData($pay_by)
    {
        $sql = "SELECT 
                    tbl_services.op_logo,
                    tbl_electric_bill_pay.*
                FROM 
                    tbl_electric_bill_pay 
                JOIN 
                    tbl_services
                ON 
                    tbl_services.opcode = tbl_electric_bill_pay.service_code        
                WHERE 
                    tbl_electric_bill_pay.pay_by = $pay_by 
                ORDER BY 
                    tbl_electric_bill_pay.id 
                DESC";
        return $this->db->query($sql)->result();
    }

    public function getElectricBillReportByMobile($from_date, $to_date, $opcode, $users)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $users);

        $sql = "SELECT *
                FROM tbl_electric_bill_pay
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                    AND pay_by IN ?
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }
}
