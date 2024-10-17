<?php
class Dashboard_model extends CI_Model
{
    public function getTodayCommission($today, $mob)
    {
        // echo $mob; die;
        $sql = "SELECT
        SUM(profit) AS today_margin,
        SUM(amount) AS today_amount
     FROM
        tbl_recharge
     WHERE
        DATE = '$today' AND
     STATUS
        = 'SUCCESS' AND recharge_by = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getTodayUserProfit($mob)
    {
        $today = date('d-m-Y');

        $this->db->select_sum('amount');
        $this->db->where('date', $today);
        $this->db->where('from_mobile', $mob);
        $this->db->group_start();
        $this->db->where('remarks', 'Mobile Recharge Profit');
        $this->db->or_where('remarks', 'DTH Recharge Profit');
        $this->db->group_end();

        return $this->db->get('wallet_balance_history')->row_array();
    }

    public function getMonthUserProfit($mob)
    {
        $today = date('d-m-Y');

        $onemonthago = date('d-m-Y', strtotime('-30 days'));
        // echo $onemonthago;
        // echo $today; die;
        $sql = "SELECT SUM(amount) as onemonth_amount FROM wallet_balance_history WHERE (date >= '$onemonthago' OR date <= '$today') AND( remarks = 'Mobile Recharge Profit' OR remarks = 'DTH Recharge Profit' ) AND from_mobile = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalUserProfit($mob)
    {
        $sql = "SELECT SUM(amount) as t_amount FROM wallet_balance_history WHERE ( remarks = 'Mobile Recharge Profit' OR remarks = 'DTH Recharge Profit' ) AND from_mobile = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getTodayCom($today)
    {
        $sql = "SELECT
        SUM(profit) AS today_margin,
        SUM(api_profit) AS t_profit,
        SUM(amount) AS today_amount
     FROM
        tbl_recharge
     WHERE
        DATE = '$today' AND
     STATUS
        = 'SUCCESS'";
        return $this->db->query($sql)->row_array();
    }

    public function getTodayProfit()
    {
        $today = date('d-m-Y');

        $this->db->select_sum('amount');
        $this->db->where('date', $today);
        $this->db->group_start();
        $this->db->where('remarks', 'Mobile Recharge Profit');
        $this->db->or_where('remarks', 'DTH Recharge Profit');
        $this->db->group_end();

        return $this->db->get('wallet_balance_history')->row_array();
    }


    public function getOnemonthCommission($today, $onemonthago, $mob)
    {
        $sql = "SELECT
        SUM(profit) AS onemonth_margin,
        SUM(amount) AS onemonth_amount
     FROM
        tbl_recharge
     WHERE
        DATE >= '$onemonthago' AND DATE <= '$today' AND
     STATUS
        = 'SUCCESS' AND recharge_by = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getOnemonthCom($today, $onemonthago)
    {
        $sql = "SELECT
        SUM(profit) AS onemonth_margin,
        SUM(api_profit) AS onemonth_profit,
        SUM(amount) AS onemonth_amount
     FROM
        tbl_recharge
     WHERE
        DATE >= '$onemonthago' AND DATE <= '$today' AND
     STATUS
        = 'SUCCESS'";
        return $this->db->query($sql)->row_array();
    }

    public function geOnemonthProfit()
    {
        $today = date('d-m-Y');

        $onemonthago = date('d-m-Y', strtotime('-30 days'));
        // echo $onemonthago;
        // echo $today; die;
        $sql = "SELECT SUM(amount) as onemonth_amount FROM wallet_balance_history WHERE (date >= '$onemonthago' OR date <= '$today') AND( remarks = 'Mobile Recharge Profit' OR remarks = 'DTH Recharge Profit' ) ";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalCommission($mob)
    {
        $sql = "SELECT
        SUM(profit) AS total_margin,
        SUM(amount) AS total_amount,
        COUNT(id) AS total_recharge
     FROM
        tbl_recharge
     WHERE
     STATUS
        = 'SUCCESS' AND recharge_by = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalCom()
    {
        $sql = "SELECT
        SUM(profit) AS total_margin,
        SUM(api_profit) AS total_profit,
        SUM(amount) AS total_amount,
        COUNT(id) AS total_recharge
     FROM
        tbl_recharge
     WHERE
     STATUS
        = 'SUCCESS' ";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalProfit()
    {
        $sql = "SELECT SUM(amount) as t_amount FROM wallet_balance_history WHERE ( remarks = 'Mobile Recharge Profit' OR remarks = 'DTH Recharge Profit' )";
        return $this->db->query($sql)->row_array();
    }

    public function getTodayUtilityData($mob, $today)
    {
        $sql = "SELECT
        SUM(amount) AS today_amount,
        SUM(profit) AS today_profit
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success' AND pay_by = $mob AND date = '$today'";
        return $this->db->query($sql)->row_array();
    }

    public function todayUtilityProfit($mob)
    {
        $today = date('d-m-Y');

        $this->db->select_sum('amount');
        $this->db->where('date', $today);
        $this->db->where('from_mobile', $mob);
        $this->db->where('remarks', 'Electric Bill Pay Profit');

        return $this->db->get('wallet_balance_history')->row_array();
    }

    public function getTodayUtility($today)
    {
        $sql = "SELECT
        SUM(amount) AS today_amount,
        SUM(dr) AS today_api_profit
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success' AND date = '$today'";
        return $this->db->query($sql)->row_array();
    }

    public function getOnemonthUtilityData($mob, $today, $onemonthago)
    {
        $sql = "SELECT
        SUM(amount) AS onemonth_amount,
        SUM(profit) AS onemonth_profit
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success' AND DATE >= '$onemonthago' AND DATE <= '$today' AND pay_by = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getOnemonthUtility($today, $onemonthago)
    {
        $sql = "SELECT
        SUM(amount) AS onemonth_amount,
        SUM(dr) AS onemonth_api_profit
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success' AND DATE >= '$onemonthago' AND DATE <= '$today'";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalUtilityData($mob)
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(profit) AS total_profit,
        COUNT(id) AS total_pay
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success' AND pay_by = $mob";
        return $this->db->query($sql)->row_array();
    }

    public function getTotalUtility()
    {
        $sql = "SELECT
        SUM(amount) AS total_amount,
        SUM(dr) AS total_api_profit,
        COUNT(id) AS total_pay
    FROM
        tbl_electric_bill_pay
    WHERE
        trans_status = 'Success'";
        return $this->db->query($sql)->row_array();
    }
}
