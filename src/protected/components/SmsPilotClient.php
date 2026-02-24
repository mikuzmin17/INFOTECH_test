<?php

class SmsPilotClient extends CApplicationComponent
{
    public $apiUrl = 'https://smspilot.ru/api.php';
    public $apiKey = '';

    public function init()
    {
        parent::init();
    }

    public function send($phone, $message)
    {
        if ($this->apiKey === '') {
            Yii::log('SMS not sent: missing API key.', CLogger::LEVEL_WARNING);
            return false;
        }

        $query = http_build_query([
            'send' => $message,
            'to' => $phone,
            'apikey' => $this->apiKey,
        ]);

        $url = $this->apiUrl . '?' . $query;
        $context = stream_context_create([
            'http' => ['timeout' => 5],
        ]);
        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            Yii::log('SMS not sent: request failed.', CLogger::LEVEL_ERROR);
            return false;
        }

        if (strpos($response, 'ERROR') === 0) {
            Yii::log('SMS error: ' . $response, CLogger::LEVEL_ERROR);
            return false;
        }

        return true;
    }
}
