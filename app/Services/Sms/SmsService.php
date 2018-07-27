<?php
namespace App\Services\Sms;

use GuzzleHttp\Client;

class SmsService
{
    const SMS_SENT = 1;
    const SMS_NOT_SENT = 0;

    public function send(int $code, string $phone)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken = config('app.twilio')['TWILIO_AUTH_TOKEN'];
        $twillioNumber = config('app.twilio')['TWILIO_NUMBER'];
        $status = self::SMS_NOT_SENT;
        try {
            $client = new Client(['auth' => [$accountSid, $authToken]]);
            $status = $client->post('https://api.twilio.com/2010-04-01/Accounts/'.$accountSid.'/Messages',
                ['form_params' => [
                    'Body' => 'CODE: '. $code,
                    'To' => $phone,
                    'From' => $twillioNumber
                ]]);
          
            $status = self::SMS_SENT;
        }
        catch (\Exception $e)
        {
            echo "Error: " . $e->getMessage();
        }
        return $status;
    }
}