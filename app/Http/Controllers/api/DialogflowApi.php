<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Google\Cloud\Dialogflow\V2\TextInput;

class DialogflowApi extends Controller
{
    public function index(Request $request)
    {
        // $credentialsPath = __DIR__ . '/dialogflow-key.json';
        $credentialsPath = base_path('dialogflow-key.json');
        $projectId= $request->projectId;
        $text= $request->text;
        $sessionId= $request->sessionId;
        $languageCode = 'en-US';


        // echo $sessionId; die();

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
    
        header('Content-Type: application/json');
        echo $queryResultJson;
    
        $sessionsClient->close();
    
        return [
            'queryText' => $queryResult->getQueryText(),
            'fulfillmentText' => $queryResult->getFulfillmentText(),
            'intent' => $queryResult->getIntent()->getDisplayName()
        ];
    }
}
