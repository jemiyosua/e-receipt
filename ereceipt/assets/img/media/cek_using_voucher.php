<?php
//error_reporting(0);

require_once('../functions.php');
require_once('../set_header.php');
// $txtuserid = $_REQUEST["txtuserid"];

class get_list_topup_narindo extends Rest
{
    private $DeviceUUID;
    private $MerchantID;
    
    function setDeviceUUID($DeviceUUID)
    {
        $this->DeviceUUID = $DeviceUUID;
    }
    function getDeviceUUID()
    {
        return $this->DeviceUUID;
    }

    function setMerchantID($MerchantID)
    {
        $this->MerchantID = $MerchantID;
    }
    function getMerchantID()
    {
        return $this->MerchantID;
    }

    public function __construct()
    {
        parent::__construct();
        $this->db = new DbConnect;
        $this->dbConn = $this->db->connect_mysql();
        $this->functions = new api_function;
        $this->data = json_decode($this->request, true);
    }

    public function getData()
    {
        $token = "";

        $conn = $this->dbConn;
        $deviceUUID = $this->getDeviceUUID();
        $merchantId = $this->getMerchantID();

        try{
            // GET USER ID
            $sqlCek = "SELECT user_id FROM starpoin_profile_randomkey
                        WHERE deviceuuid = '".$deviceUUID."' ";
            $result = $conn->query($sqlCek);
            if (!$result) {
                $this->functions->sendLogError($deviceUUID, 'cek_using_voucher.php', "", "Gagal select starpoin_profile_randomkey ".mysqli_error($conn),json_encode($this->data));
            }
            while($rs = mysqli_fetch_array($result))
            {
                $userId = $rs['user_id'];
            }

            // GET USING VOUCHER
            $sql = "SELECT COUNT(1) AS CNT FROM wp_qrcode
                    WHERE user_id = '".$userId."'
                    AND merchant_id = '".$merchantId."'";
            $result = $conn->query($sql);
            if (!$result) {
                $this->functions->sendLogError($deviceUUID, 'cek_using_voucher.php', "", "Gagal select wp_qrcode ".mysqli_error($conn),json_encode($this->data));
            }
            if($rs = mysqli_fetch_array($result))
            {
                $CNT = $rs['CNT'];

                if ($CNT == 1) {
                    $button = "<button class='btn btn-danger' type='button' id='btn_berhasil_gunakan_promo'>BERHASIL <img src='images/ic_checklist/drawable-hdpi/ic_checklist.png' width='20'></button>";
                    $txt = "<div style='text-align: center;padding-top: 10px;'>Tunjukan layar ini kepada Kasir.</div>";

                    $return["ErrMsg"] = "Sudah pernah digunakan";
                    $return["ErrCode"] = 1;
                    $return["ButtonVoucher"] = $this->functions->toUnicode($button);
                    $return["TextVoucher"] = $this->functions->toUnicode($txt);

                    return $return;
                    exit;
                } else {
                    $button = "<button class='btn btn-danger' type='button' style='background-color: red;color: white;' id='btn_gunakan_promo'>GUNAKAN</button>";
                    $txt = "";

                    $return["ErrMsg"] = "Belum digunakan";
                    $return["ErrCode"] = 0;
                    $return["ButtonVoucher"] = $this->functions->toUnicode($button);
                    $return["TextVoucher"] = $this->functions->toUnicode($txt);

                    return $return;
                    exit;
                }
            } else {
                $this->functions->sendLogError($deviceUUID, "cek_using_voucher.php", "", "Data tidak ditemukan",json_encode($this->data));

                $return["ErrMsg"] = "Data tidak ditemukan";
                $return["ErrCode"] = 1;
                $return["ButtonVoucher"] = "";
                $return["TextVoucher"] = "";

                return $return;
                exit;
            }

        } catch (Exception $e) {
            $this->functions->sendLogError($deviceUUID, "cek_using_voucher.php", "", $e->getMessage(),json_encode($this->data));
            $return["ErrMsg"] = "Data tidak ditemukan";
            $return["ErrCode"] = 1;
            $return["ButtonVoucher"] = "";
            $return["TextVoucher"] = "";
            
            return $return;
            exit;
        }
    }

    public function result()
    {
        $this->validasiToken();
        // $this->validasiTokenWithoutRandomkey();
        $this->setDeviceUUID($this->data['param1']);
        $this->setMerchantID($this->data['param2']);

        $result = $this->getData();
        mysqli_close($this->dbConn);
        $this->returnResponse(SUCCESS_RESPONSE, $result);
    }
}

$api = new get_list_topup_narindo;
$api->result();
