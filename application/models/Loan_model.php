<?php
class Loan_model extends CI_Model
{
    public function getService()
    {
        $sql = "SELECT * FROM tbl_loan_operator";
        return $this->db->query($sql)->result();
    }

    public function getData()
    {
        $sql = "SELECT * FROM tbl_settings";
        return $this->db->query($sql)->row();
    }

    public function getApi()
    {
        $sql = "SELECT * FROM tbl_utility_api";
        return $this->db->query($sql)->row();
    }

    public function getLoanPayData()
    {
        $sql = "SELECT * FROM tbl_loan_payment ORDER BY id DESC";
        return $this->db->query($sql)->result();
    }

    public function getLoanData($pay_by)
    {
        $sql = "SELECT 
                    tbl_loan_operator.operator,
                    tbl_loan_operator.op_logo,
                    tbl_loan_payment.*
                FROM 
                    tbl_loan_payment 
                JOIN tbl_loan_operator ON tbl_loan_operator.opcode = tbl_loan_payment.service_code
                WHERE tbl_loan_payment.pay_by = $pay_by 
                ORDER BY tbl_loan_payment.id DESC";
        return $this->db->query($sql)->result();
    }

    public function totalAmount()
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(profit) AS total_profit,
        SUM(dr) AS total_api_profit
     FROM
     tbl_loan_payment WHERE trans_status_code = 1";
        return $this->db->query($sql)->row();
    }

    public function totalBillAmount($pay_by)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(profit) AS total_profit
     FROM
     tbl_loan_payment
     WHERE
        pay_by = $pay_by AND trans_status_code = 1";
        return $this->db->query($sql)->row();
    }

    public function getLoanPayReport($from_date, $to_date, $opcode)
    {
        $params = array($from_date, $to_date, $opcode, $opcode);
        // print_r($params);die;
        $sql = "SELECT *
                FROM tbl_loan_payment
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getLoanReport($from_date, $to_date, $opcode, $pay_by)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $pay_by);
        // print_r($params);die;
        $sql = "SELECT *
                FROM tbl_loan_payment
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                    AND pay_by = ?
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function getLoanReportByMobile($from_date, $to_date, $opcode, $users)
    {
        $params = array($from_date, $to_date, $opcode, $opcode, $users);
        // print_r($params);die;
        $sql = "SELECT *
                FROM tbl_loan_payment
                WHERE date BETWEEN ? AND ?
                    AND (service_code = ? OR ? = '')
                    AND pay_by IN ?
                ORDER BY id DESC";

        $query = $this->db->query($sql, $params);
        return $query->result();
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

    public function getLoanDataByMobile($mobileNumbers)
    {
        $this->db->select('*');
        $this->db->from('tbl_loan_payment');
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
        $this->db->from('tbl_loan_payment');
        $this->db->where('trans_status_code', 1);
        $this->db->where_in('pay_by', $mobileNumbers);

        return $this->db->get()->row();
    }

    public function getUser($userid)
    {
        // echo $userid; die;
        return $this->db->query("SELECT * FROM users WHERE id = ?", [$userid])->row();
    }


    public function getCommission($opcode, $id, $slug, $service, $role_slug_id)
    {
        $result = $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = ? 
            AND user_id = ? 
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$opcode, $id, $slug, $service, $role_slug_id]
        )->row();


        $result_1 = $this->db->query(
            "SELECT * FROM commission 
            WHERE mob_operator = 'all' 
            AND user_id = ? 
            AND user_type = ? 
            AND service = ? 
            AND created_by = ?",
            [$id, $slug, $service, $role_slug_id]
        )->row();

        $result_2 = $this->db->query(
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
}
