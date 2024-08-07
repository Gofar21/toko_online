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
use App\Pertanyaan;
use Illuminate\Support\Facades\Auth;

class BotManController extends Controller
{
    public function handle()
    {
       $config = [];
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $botman = BotManFactory::create($config, new LaravelCache());

        // Menangkap semua input pengguna
        $botman->hears('{message}', function (BotMan $bot, $message) {
           
            $response = $this->test($message);

            $pesanUser = $message;
            $id_user = Auth::user()->id;
            // Mengambil string JSON dari fulfillmentText
            $fulfillmentText = $response['fulfillmentText'];

            // Menguraikan string JSON menjadi array PHP
            $fulfillmentData = json_decode($fulfillmentText, true);

            // Mengambil fulfillmentMessages dari array data
            $fulfillmentMessages = $fulfillmentData['fulfillmentMessages'];

            $options = [];

            $isPayloadProcessed = false;

            foreach ($fulfillmentMessages as $message) {
                if (isset($message['payload']) && isset($message['payload']['richContent'])) {
                    // var_dump($message['payload']);
                    foreach ($message['payload']['richContent'] as $content) {
                        // var_dump($content[1]['options']);
                        if (isset($content[1]['options'])) {
                            foreach ($content[1]['options'] as $option) {
                                // echo $option['text'];
                                $bot->reply(
                                    '<button type="button" onclick="window.tanya()" id="tanya">
                                    '.$option['text'].'
                                    </button>'
                                );
                            }
                        }
                    }

                    $textPayload = json_encode($fulfillmentMessages);
                    $textInputInsert = json_encode($message); // Mengubah message menjadi JSON string jika perlu

                // Debugging: Log atau tampilkan data yang akan disisipkan
                // \Log::info('Fulfillment Messages: ' . json_encode($fulfillmentMessages));
                // \Log::info('Message: ' . $message);

                Pertanyaan::create([
                    'text_payload' => $textPayload,
                    'label_type' => 'produk',
                    'text_input' => $pesanUser,
                    'user_id' => $id_user
                ]);

                $isPayloadProcessed = true;

                }


            }

            if (!$isPayloadProcessed) {
                foreach ($fulfillmentMessages as $message) {
                    if (isset($message['text']['text'][0])) {
                        $bot->reply($message['text']['text'][0]);
    
                        Pertanyaan::create([
                            'text_payload' => null,
                            'label_type' => 'produk',
                            'text_input' => $pesanUser,
                            'user_id' => $id_user
                        ]);
    
                        $isPayloadProcessed = true;
                        break;
                    }
                }
            }

            if (!$isPayloadProcessed && isset($data['fulfillmentText'])) {
                $bot->reply($data['fulfillmentText']);
    
                Pertanyaan::create([
                    'text_payload' => null,
                    'label_type' => 'produk',
                    'text_input' => $pesanUser,
                    'user_id' => $id_user
                ]);
            }
    
            
            
        });
    

        $botman->listen();
    }

    public function test($input)
    {
        $credentialsPath = base_path('dialogflow-key.json');
        $projectId  = 'hm-bot-dxtm';
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
