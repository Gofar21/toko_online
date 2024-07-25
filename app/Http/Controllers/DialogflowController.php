<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pertanyaan;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
use Google\Protobuf\ListValue;

class DialogflowController extends Controller
{
    private $projectId = 'hm-bot-dxtm'; // Ganti dengan ID proyek Dialogflow Anda
    private $sessionId;
    private $sessionsClient;

    public function __construct()
    {
        $this->sessionId = session()->getId();
        $this->sessionsClient = new SessionsClient([
            'credentials' => base_path('dialogflow-key.json')
        ]);
    }

    public function handle(Request $request)
    {
        $message = $request->input('message');
        $userId = Auth::user()->id;
        // Check if message is provided
        if (empty($message)) {
            return response()->json(['error' => 'Message is required'], 400);
        }

        $response = $this->detectIntent($message);

        $queryResult = $response->getQueryResult();
        $fulfillmentText = $queryResult->getFulfillmentText();
        $fulfillmentMessages = $queryResult->getFulfillmentMessages();

        // $fulfillmentMessagesArray = [];
        // foreach ($fulfillmentMessages as $message) {
        //     $payload = $message->getPayload();
        //     if ($payload) {
        //         $fulfillmentMessagesArray[] = $this->structToArray($payload);
        //     }
        // }

        // Serialisasi array menjadi string JSON
        $fulfillmentMessagesJson = json_encode($fulfillmentMessages);

        Pertanyaan::create([
            'text_payload' => $fulfillmentMessagesJson,
            'label_type' => 'produk',
            'text_input' => $message,
            'user_id' => $userId
        ]);

        $isPayloadProcessed = false;

        foreach ($fulfillmentMessages as $message) {
            $payload = $message->getPayload();
            if ($payload) {
                // Convert payload from Google\Protobuf\Struct to an associative array
                $payloadArray = $this->structToArray($payload);

                if (isset($payloadArray['richContent'])) {
                    $richContent = $payloadArray['richContent'];
                    foreach ($richContent as $content) {
                        if (isset($content[1]['options'])) {
                            $options = $content[1]['options'];
                            $botResponses = [];
                            foreach ($options as $option) {
                                $pesan = preg_replace('/^\d+\.\s*/', '', $option['text']);
                                $botResponses[] = '<button type="button" onclick="tanya(\'' . $pesan . '\')" id="jawabanButton">' . htmlspecialchars($option['text']) . '</button>';
                            }
                            return $this->reply(implode(' ', $botResponses));
                            $isPayloadProcessed = true;
                            // break; // Hentikan loop jika payload sudah diproses
                        }
                    }
                    if ($isPayloadProcessed) {
                        // break; // Hentikan loop jika payload sudah diproses
                    }
                }
            }
        }

        // Jika tidak ada payload yang diproses, kirimkan teks fulfillment
        if (!$isPayloadProcessed && $fulfillmentText) {
            return $this->reply($fulfillmentText);
        }

        // Convert fulfillmentMessages to a more suitable format
        

        // Save to database
        
        
        return response()->json(['message' => 'Data saved and processed']);
    }


    private function detectIntent($text)
    {
        $session = $this->sessionsClient->sessionName($this->projectId, $this->sessionId);

        $textInput = new TextInput();
        $textInput->setText($text);
        $textInput->setLanguageCode('id');

        $queryInput = new QueryInput();
        $queryInput->setText($textInput);

        return $this->sessionsClient->detectIntent($session, $queryInput);
    }

    private function reply($message)
    {
        // Gunakan response JSON jika sesuai dengan aplikasi Anda
        return response()->json(['message' => $message]);
    }

    private function structToArray(?Struct $struct): array
    {
        $array = [];
        if ($struct === null) {
            return $array;
        }

        foreach ($struct->getFields() as $key => $value) {
            if ($value->hasStructValue()) {
                $array[$key] = $this->structToArray($value->getStructValue());
            } elseif ($value->hasListValue()) {
                $array[$key] = $this->listToArray($value->getListValue());
            } elseif ($value->hasStringValue()) {
                $array[$key] = $value->getStringValue();
            } elseif ($value->hasNumberValue()) {
                $array[$key] = $value->getNumberValue();
            } elseif ($value->hasBoolValue()) {
                $array[$key] = $value->getBoolValue();
            } elseif ($value->hasNullValue()) {
                $array[$key] = null;
            }
        }
        return $array;
    }

    private function listToArray(?ListValue $list): array
    {
        $array = [];
        if ($list === null) {
            return $array;
        }

        foreach ($list->getValues() as $value) {
            if ($value->hasStructValue()) {
                $array[] = $this->structToArray($value->getStructValue());
            } elseif ($value->hasListValue()) {
                $array[] = $this->listToArray($value->getListValue());
            } elseif ($value->hasStringValue()) {
                $array[] = $value->getStringValue();
            } elseif ($value->hasNumberValue()) {
                $array[] = $value->getNumberValue();
            } elseif ($value->hasBoolValue()) {
                $array[] = $value->getBoolValue();
            } elseif ($value->hasNullValue()) {
                $array[] = null;
            }
        }
        return $array;
    }
}
