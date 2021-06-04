<?php

namespace App\Services;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Validator;
class NewsService
{
    private $client;
    private $TELEGRAM_DATE;
    private $TELEGRAM_KEY;
    private $TELEGRAM_count;
    private $TELEGRAM_page;
    private $url;
    public function __construct()
    {
        $this->TELEGRAM_DATE=env('TELEGRAM_DATE');
        $this-> TELEGRAM_KEY=env('TELEGRAM_KEY');
        $this-> TELEGRAM_count=env('TELEGRAM_count');
        $this-> TELEGRAM_page=env('TELEGRAM_page');
        $this-> url=env('NEWS_URL');
        $this->client= new Client(
            ['base_uri'=>$this-> url]
        );
    }
    
    public static function getNews($string='ups') { 
        
        $responce =$this->client->request('GET','newsList',[
            'query'=>[
                'api_key'=>$this->TELEGRAM_KEY,
               


            ]
        ]);
        dd($responce->getStatusCode());
        $product= json_decode($response->getBody()->getContents());
        dd($responce->getStatusCode());
        return null;
        
    }
    
    
}