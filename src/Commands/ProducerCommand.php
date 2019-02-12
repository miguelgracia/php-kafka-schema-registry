<?php 
namespace Kafka\SchemaRegistry\Commands;

use Kafka\SchemaRegistry\Exceptions\SchemaNotPreparedException;
use Kafka\SchemaRegistry\Constants\ProducerConfParam;
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

        $this->initConfIfNeeded();

        $this->prepareSchema();
        
        $this->conf->set(ProducerConfParam::COMPRESSION_TYPE, 'snappy');
        $this->conf->set(ProducerConfParam::LINGER_MS, '20');
        $this->conf->set(ProducerConfParam::BROKER_VERSION_FALLBACK, '2.0.1');
        $this->conf->set(ProducerConfParam::QUEUE_BUFFERING_MAX_KBYTES, (string)32*1024);

        $this->conf->setDefaultTopicConf($this->topicConf);

        $this->kafka = new \RdKafka\Producer($this->conf);
        $this->kafka->setLogLevel(LOG_DEBUG);
        $this->kafka->addBrokers($this->brokerList);
    }

    public function produce($topic, Array $data, $key = null)
    {
        echo "Producing " . sizeof($data). " messages to kafka topic '$topic'\n";
        
        $producer = new AvroProducer($this->kafka->newTopic($topic),$this->schemaRegistryUrl, $this->keySchema, $this->schema, ['register_missing_schemas' => false]);

        $start = microtime(true);
        
        foreach ($data as $item) {
            
            //TODO check this param format
            $format = mt_rand(0, 2);
            $format = $format === 2 ? null : $format;

            $producer->produce(RD_KAFKA_PARTITION_UA, 0, $item, $key, null, null, null);
        }

        $end = microtime(true);

        echo 'Published: '.($end - $start)."\n";
    
    }

}

?>