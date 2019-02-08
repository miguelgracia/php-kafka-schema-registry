<?php 
namespace Kafka\SchemaRegistry\Commands;

use Kafka\SchemaRegistry\Exceptions\SchemaNotPreparedException;
use Kafka\SchemaRegistry\Constants\KafkaConfParam;
use Kafka\SchemaRegistry\Constants\TopicConfParam;
use Kafka\SchemaRegistry\Lib\AvroProducer;

/**
 * Undocumented class
 */
class ProducerCommand extends KafkaCommand
{

    private const CONFIG_CONTEXT = 'P';

    /**
     * //TODO comment function
     *
     * @param String $schemaRegistryUrl
     * @param String $brokerList
     * @return void
     */
    public function prepare($schemaRegistryUrl = null, $brokerList = null)
    {
        $this->schemaRegistryUrl = ($schemaRegistryUrl != null) ? $schemaRegistryUrl : env('SCHEMA_REGISTRY_URL');
        $this->brokerList        = ($brokerList != null) ? $brokerList : env('KAFKA_BROKERS');

        if(null === $this->getSchemaSubject() || null === $this->getSchemaVersion()){
            throw new SchemaNotPreparedException('You must set the schema subject and schema version via setSchema($subject, $version = 1) before call prepare() method', 10);
        }

        $this->prepareSchema();
        
        $this->kafka = new \RdKafka\Producer();
        $this->kafka->setLogLevel(LOG_DEBUG);
        $this->kafka->addBrokers($this->brokerList);
    }

    public function produce($topic, Array $data, $key = null)
    {
        echo "Producing " . sizeof($data). " messages to kafka topic '$topic'\n";
        
        $producer = new AvroProducer($this->kafka->newTopic($topic),$this->schemaRegistryUrl, null, $this->schema, ['register_missing_schemas' => true]);

        $start = microtime(true);
        
        foreach ($data as $item) {
            
            //TODO check this param format
            $format = mt_rand(0, 2);
            $format = $format === 2 ? null : $format;

            $producer->produce(RD_KAFKA_PARTITION_UA, 0, (array)$item, $key, null, null, $format);
        }

        $end = microtime(true);

        echo 'Published: '.($end - $start)."\n";
    
    }

    public function getConfigParams($property = null){
        return ConfigHelper::getConfigParams(self::CONFIG_CONTEXT, $property);
    }

    public function getTopicConfigParams($property = null){
        $this->table(ConfigHelper::getTopicConfigParams(self::CONFIG_CONTEXT, $property));
    }

}

?>