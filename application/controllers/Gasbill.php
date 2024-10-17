<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gasbill extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
    }

    public function index($id)
    {

        $data['gas_bill'] = $this->db->get_where('lpg_gas_payment', ['id' => $id])->row_array();
        $opcode = $data['gas_bill']['service_code'];
        $data['operator'] = $this->db->get_where('tbl_lpg_operator', ['opcode' => $opcode])->row_array();
        //  echo '<pre>';

        $data['account'] = $this->db->get_where('users', ['mobile' => $data['gas_bill']['pay_by']])->row_array();
        $account_type = $data['account']['account_type'];
        $data['user'] = $this->db->get_where('user_type', ['id' => $account_type])->row_array(); 

        function AmountInWords(float $amount)
        {
            $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
            // Check if there is any number after decimal
            $amt_hundred = null;
            $count_length = strlen($num);
            $x = 0;
            $string = array();
            $change_words = array(
                0 => '', 1 => 'One', 2 => 'Two',
                3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
                19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
                40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
                70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
            );
            $here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
            while ($x < $count_length) {
                $get_divider = ($x == 2) ? 10 : 100;
                $amount = floor($num % $get_divider);
                $num = floor($num / $get_divider);
                $x += $get_divider == 10 ? 1 : 2;
                if ($amount) {
                    $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                    $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                    $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
       ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
       ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
                } else $string[] = null;
            }
            $implode_to_Rupees = implode('', array_reverse($string));
            $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
            return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        }


        $amount = $data['gas_bill']['amount'];
        $data['words'] = AmountInWords($amount);
        // print_r($data['words']);
        // die;

        $this->load->view('gasbill', $data);
    }
}
