<?php 
namespace Kafka\SchemaRegistry\Commands;

use Illuminate\Console\Command;
use Kafka\SchemaRegistry\Lib\CachedSchemaRegistryClient;
use AvroSchema;

/**
 * Command extends for kafka wich contains the needed common functions for consumers and producers
 */
abstract class KafkaCommand extends Command
{

    protected $conf;
    protected $topicConf;
    protected $schemaRegistryUrl = null;
    protected $brokerList        = null;
    protected $topics            = null;
    protected $schemaSubject     = null;
    protected $schemaVersion     = null;
    protected $keySchemaSubject  = null;
    protected $keySchemaVersion  = null;
    protected $schema            = null;
    protected $keySchema            = null;
    protected $kafka             = null;

    /**
     * Undocumented function
     *
     * @param string $schemaRegistryUrl
     * @param string $brokerList
     * @return void
     */
    abstract public function prepare($schemaRegistryUrl = null, $brokerList = null);
    
    /**
     * Init both configs if were needed
     *
     * @return void
     */
    protected function initConfIfNeeded(){
        if($this->conf === null){
            $this->conf = new \RdKafka\Conf();
        }
        if($this->topicConf === null){
            $this->topicConf = new \RdKafka\TopicConf();
        }
    }

    /**
     * Returns the current config
     *
     * @return \RdKafka\Conf $conf
     */
    protected function getConf(){
        $this->initConfIfNeeded();
        return $this->conf;
    }

    /**
     * Set a param to current config
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    protected function setConfParam($key, $value){
        $this->initConfIfNeeded();
        $this->conf->set($key, $value);
    }

    /**
     * Returns the current config
     *
     * @return \RdKafka\TopicConf $topicConf
     */
    protected function getTopicConf(){
        $this->initConfIfNeeded();
        return $this->topicConf;
    }

    /**
     * Set a param to current topic config
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    protected function setTopicConfParam($key, $value){
        $this->initConfIfNeeded();
        return $this->topicConf->set($key, $value);
    }

    /**
     * Search the schema and version previously given via setSchema method into the schema registry url and saves it in cache
     *
     * @return void
     */
    protected function prepareSchema(){

        $cachedSchema    = new CachedSchemaRegistryClient($this->schemaRegistryUrl);
        $this->schema    = $cachedSchema->getBySubjectAndVersion($this->schemaSubject, $this->schemaVersion);
        $this->keySchema = $cachedSchema->getBySubjectAndVersion($this->keySchemaSubject, $this->keySchemaVersion);
    }

    /**
     * Set the current schema and version 
     *
     * @param string $schemaSubject
     * @param string $version
     * @return void
     */
    protected function setSchema($schemaSubject, $version = '1'){
        $this->schemaSubject = $this->endsWith($schemaSubject, '-value') ? $schemaSubject : $schemaSubject . '-value';  
        $this->schemaVersion = $version;  
    }

    /**
     * Set the current schema and version 
     *
     * @param string $schemaSubject
     * @param string $version
     * @return void
     */
    protected function setKeySchema($schemaSubject, $version = '1'){
        $this->keySchemaSubject = $this->endsWith($schemaSubject, '-key') ? $schemaSubject : $schemaSubject . '-key';  
        $this->keySchemaVersion = $version;  
    }

    /**
     * Returns the current schema subject
     *
     * @return string $schemaSubject
     */
    protected function getSchemaSubject(){
        return $this->schemaSubject;
    }

    /**
     * Returns the current schema version
     *
     * @return string $schemaVersion
     */
    protected function getSchemaVersion(){
        return $this->schemaVersion;
    }

    

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}

?>