<?php 
namespace Kafka\SchemaRegistry\Commands;

use Illuminate\Console\Command;
use Kafka\SchemaRegistry\Lib\CachedSchemaRegistryClient;
use AvroSchema;

abstract class KafkaCommand extends Command
{

    protected $conf;
    protected $topicConf;
    protected $schemaRegistryUrl = null;
    protected $brokerList        = null;
    protected $topics            = null;
    protected $schemaSubject     = null;
    protected $schemaVersion     = null;
    protected $schema            = null;
    protected $kafka             = null;

    abstract public function prepare($schemaRegistryUrl = null, $brokerList = null);
    abstract public function getConfigParams($property = null);
    abstract public function getTopicConfigParams($property = null);
    
    private function initConfIfNeeded(){
        if($this->conf === null){
            $this->conf = new \RdKafka\Conf();
        }
    }

    protected function getConf(){
        $this->initConfIfNeeded();
        return $this->conf;
    }

    protected function setConfParam($key, $value){
        $this->initConfIfNeeded();
        return $this->conf->set($key, $value);
    }

    protected function prepareSchema(){

        $cachedSchema = new CachedSchemaRegistryClient($this->schemaRegistryUrl);
        $this->schema = $cachedSchema->getBySubjectAndVersion($this->schemaSubject, $this->schemaVersion);
//        $this->schema = json_encode($this->schema->to_avro());
//        $this->schema = AvroSchema::parse($this->schema);
    }

    protected function setSchema($schemaSubject, $version = '1'){
        $this->schemaSubject = $schemaSubject;  
        $this->schemaVersion = $version;  
    }

    protected function getSchemaSubject(){
        return $this->schemaSubject;
    }

    protected function getSchemaVersion(){
        return $this->schemaVersion;
    }
}

?>