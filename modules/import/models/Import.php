<?php

namespace app\modules\import\models;

//class Import  extends \yii\db\ActiveRecord
class Import
{
    private $sessionId;
    public function auth()
    {
        $customerId = '10966'; //11797
        $password = 'mZZ04JDl'; //5uQwDTkt
        $query_auth = file_get_contents('https://api.farmnet.ru/Login?customerId=' . $customerId . '&password=' . $password);
        $query_auth = json_decode($query_auth, true);
        if ($query_auth['status'] == 1) {
            mail_error($query_auth['error']);
            die;
        }
        $sessionId = $query_auth['sessionId'];
        return $sessionId;
    }


    public function getDrugs()
    {
        $parentId = '10966'; // id владельца pass = mZZ04JDl
        $ch = curl_init('https://api.farmnet.ru/OstByDate?parentId=' . $parentId . '&date=' . date("Y-m-d%20H:i:s"));
        $ost = [];
        $options = [
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => ["WebApiSession:" . $this->auth()],
            CURLOPT_RETURNTRANSFER
        ];

        curl_setopt_array($ch, $options);

        $file = curl_exec($ch);
        curl_close($ch);
        if (!$file) {
//            mail_error('Ошибка с ostByDate_file_get_contents_curl');//TODO: mail_error
            echo "Ошибка получения остатков";
            die;
        }
        $ost = json_decode($file, true);
        return $ost;
    }

    public function getDrugTest()
    {
        $opts = [
            'http' => [
                'method' => "GET",
                'header' => "WebApiSession:" . $this->auth()// . "\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        // Открываем файл с помощью установленных выше HTTP-заголовков
        $file = file_get_contents('https://api.farmnet.ru/OstByDate?parentId=10966' . '&date=' . date("Y-m-d%20H:i:s"), false, $context);
        if (!$file) {
            mail_error('Ошибка с ostByDate_file_get_contents_curl');
            echo "Ошибка получения остатков";
            die;
        }
        $ost_arr = json_decode($file, true);
        return $ost_arr;

    }

}