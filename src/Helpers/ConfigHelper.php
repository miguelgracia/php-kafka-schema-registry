<?php 
namespace Kafka\SchemaRegistry\Helpers;

class ConfigHelper{

    private static $globalPath   = __DIR__ . '/../ConfigFiles/global.txt';
    private static $consumerPath = __DIR__ . '/../ConfigFiles/consumer.txt';
    private static $producerPath = __DIR__ . '/../ConfigFiles/producer.txt';
    private static $topicPath    = __DIR__ . '/../ConfigFiles/topic.txt';

    /**
     * Undocumented function
     *
     * @param string $context ->  possible values * / C / P
     * @return array with requested config;
     */
    public static function getConfigParams($context = '*', $property = null){
        
        $globalItems = self::toArray(self::$globalPath);
        return $globalItems;
        if($context === 'C' || $context === '*')
        {
            $consumerItems = self::toArray(self::$consumerPath);
        }
            
        if($context === 'P' || $context === '*')
        {
            $producerItems = self::toArray(self::$producerPath);
        }


    }

    public static function getTopicConfigParams($context = '*', $property = null){
        
    }

    private static function toArray($input){
        
        $data = fopen ( $input , "r" );
        $array = [];
        while (($datos = fgetcsv($data, 1000, "|")) !== FALSE) {
            foreach($datos as $key => $item){
                $datos[$key] = trim($item);
            }
            $array[] = $datos;
        }
        return $array;
        array_walk($array, function(&$a) use ($array) {
            $a = array_combine($array[0], $a);
        });
        array_shift($array);
        dd($array);
    }
}