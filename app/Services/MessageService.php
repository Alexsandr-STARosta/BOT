<?php

namespace App\Services;

use App\Services\NewsService;
use GuzzleHttp\Client;
class MessageService
{

    private $token;
    private $url;
    private $client;
    private $chatId;
    private $text;
    private $news;
    public function __construct()
    {
        $this->token=env('TELEGRAM_BOT_TOKEN');
        $this->url=env('TELEGRAM_URL');
        $this->client= new Client(
            ['base_uri'=>$this->url.$this->token.'/']
        );
    }


    public function getMessages(){
        $responce = $this->client->request('GET','getUpdates',['query' => ['offset' => -1]]);
    if($responce->getStatusCode()===200){

        
            $message =json_decode($responce->getBody()->getContents(),true);

            if(array_key_exists('edited_message', $message['result'][0])) {

                $this->chatId = $message['result'][0]['edited_message']['chat']['id'];
                $this->text = $message['result'][0]['edited_message']['text'];
            } else {
                $this->chatId = $message['result'][0]['message']['chat']['id'];
                $this->text = $message['result'][0]['message']['text'];
            }
            if($this->text==='News'){
            $this->news = NewsService::getNews($this->text);
            dd($this->news);
            $this->sendMessages();
            }
        
    }}
    public function sendMessages(){
        $buttons=json_encode([
                'keyboard'=>[
                    ['News','Schedule'],
                    ['FIO','Test/Exam'],
                ]
            ]
            );
            $this->client->request('GET','sendMessage',['query' => [
                'chat_id' => $this->chatId,
                'text' => $this->news,
                'reply_markup'=>$buttons
            ]
        ]);



    }

}



