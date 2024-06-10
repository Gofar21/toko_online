<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\Cache\LaravelCache;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

class BotManController extends Controller
{
    public function handle()
    {
       $config = [];
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $botman = BotManFactory::create($config, new LaravelCache());

        // Menangkap semua input pengguna
        $botman->hears('{message}', function (BotMan $bot, $message) {
            // $response = $this->test($message);
            // $res = json_encode($response, JSON_PRETTY_PRINT);

            // $response =  $this->test($message);
            // $data = json_encode($response);
            // $test = json_decode($data);

            // $jawaban = $test->fulfillmentText;
            // $c = json_decode($jawaban);

            // echo json_encode($test);
            // echo $test->queryText;
            $response = $this->test($message);

            // Mengambil string JSON dari fulfillmentText
            $fulfillmentText = $response['fulfillmentText'];

            // Menguraikan string JSON menjadi array PHP
            $fulfillmentData = json_decode($fulfillmentText, true);

            // Mengambil fulfillmentMessages dari array data
            $fulfillmentMessages = $fulfillmentData['fulfillmentMessages'];

            $options = [];

            foreach ($fulfillmentMessages as $message) {
                if (isset($message['payload']) && isset($message['payload']['richContent'])) {
                    // var_dump($message['payload']);
                    foreach ($message['payload']['richContent'] as $content) {
                        // var_dump($content[1]['options']);
                        if (isset($content[1]['options'])) {
                            foreach ($content[1]['options'] as $option) {
                                // echo $option['text'];
                                $bot->reply($option['text']);
                            }
                        }
                    }
                }
            }
            

            // $bot->reply('hi');
        });

        $botman->listen();
    }

    public function test($input)
    {
        $credentialsPath = base_path('dialogflow-key.json');
        $projectId = 'hm-bot-mawi';
        $sessionId = '123456789';
        $text = $input;

        $languageCode = 'en-US';

        $sessionsClient = new SessionsClient([
            'credentials' => $credentialsPath
        ]);
    
        $session = $sessionsClient->sessionName($projectId, $sessionId);
        $textInput = new TextInput();
        $textInput->setText($text);
        $textInput->setLanguageCode($languageCode);
    
        $queryInput = new QueryInput();
        $queryInput->setText($textInput);
    
        $response = $sessionsClient->detectIntent($session, $queryInput);
        $queryResult = $response->getQueryResult();
    
        $queryResultJson = $queryResult->serializeToJsonString();
    
        // header('Content-Type: application/json');
        // echo $queryResultJson;
    
        $sessionsClient->close();
    
        return [
            'queryText' => $queryResult->getQueryText(),
            'fulfillmentText' => $queryResultJson,
            'intent' => $queryResult->getIntent()->getDisplayName()
        ];
    }

    public function hallo($hallo){
        $response = $this->test($hallo);

        // Mengambil string JSON dari fulfillmentText
        $fulfillmentText = $response['fulfillmentText'];

        // Menguraikan string JSON menjadi array PHP
        $fulfillmentData = json_decode($fulfillmentText, true);

        // Mengambil fulfillmentMessages dari array data
        $fulfillmentMessages = $fulfillmentData['fulfillmentMessages'];

        $options = [];

        foreach ($fulfillmentMessages as $message) {
            if (isset($message['payload']) && isset($message['payload']['richContent'])) {
                // var_dump($message['payload']);
                foreach ($message['payload']['richContent'] as $content) {
                    // var_dump($content[1]['options']);
                    if (isset($content[1]['options'])) {
                        foreach ($content[1]['options'] as $option) {
                            echo $option['text'];
                        }
                    }
                }
            }
        }
        
    }

    public function hallo_($hallo){
        $response =  $this->test($hallo);
        // var_dump($response);
        $data = json_encode($response);
        $test = json_decode($data);

        $jawaban = $test->fulfillmentText;
        $c = json_decode($jawaban);

        $b = $c->fulfillmentMessages;

        $fulfillmentMessages = $c->fulfillmentMessages;

        var_dump($fulfillmentMessages[1]['payload']);

        // $options = [];

        // foreach($fulfillmentMessages as $f){
        //     $richContent = $f->payload;
        //     echo $richContent;
        // }
        // $balasan = json_decode($b);

        // echo json_encode($b);
        // var_dump($b);
        // echo $test->queryText;

        // $res = json_decode($response);

        // echo $res->queryText;
        
    }
}
