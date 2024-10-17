<?php
class Walletupi_model extends CI_Model
{

    public function getPartnerData($token)
    {
        $sql = "SELECT * FROM `tb_partner` WHERE token = '$token' AND status = 'active' ";
        return $this->db->query($sql)->row();
    }

    public function getUserdata($auth_token, $muid)
    {
        $sql = "SELECT * FROM `tb_partner` WHERE id = $muid AND token = '$auth_token'";
        return $this->db->query($sql)->row();
    }

    public function getIfsc($txn_ref_id)
    {
        $sql = "SELECT * FROM `tb_virtualtxn` WHERE bene_account_ifsc='$txn_ref_id' ";
        return $this->db->query($sql)->row();
    }

    public function getQuery($client_orderid)
    {
        $sql = "SELECT * FROM `tb_virtualtxn` WHERE client_orderid='$client_orderid' ";
        return $this->db->query($sql)->row();
    }
}
