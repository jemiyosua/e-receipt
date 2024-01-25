<?php 

require_once("../koneksi.php");
 
$sql = mysqli_query($conn, "SELECT NO_HP FROM LOGIN WHERE NO_HP <> '' AND NO_HP IS NOT NULL AND NOTIFIKASI = 1");
while($row = mysqli_fetch_assoc($sql)) {
    $no_hp = $row["NO_HP"];

    schedule_message($no_hp);
}

function schedule_message($no_hp) {
    $curl = curl_init();
    $token = "iJMqQmOZxQ9JPLj5KyKCQoD2FNik6Z3PjORO0dcMs7puRlsjPp";
    $isi = "Hello, *Do not forget to create your Receipt Payment at E-Receipt*
    ==============================
    *Login to create your Receipt Pyment here :* http://e-receipt.website
    ==============================
    Thank you for using E-Receipt to create your Payment Receipt :).
    ";
    $v_isi = str_replace("<br>", CHR(13), $isi);
    $data = [
        "receiver" => $no_hp,
        "device" => "6282118009042",
        "message" => $v_isi,
        "type" => "chat"
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Accept: application/json",
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer $token",
        ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, "https://app.whatspie.com/api/messages");
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);

    echo $result;
}

?>