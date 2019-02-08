<?php 
namespace Kafka\SchemaRegistry\Commands;

use Kafka\SchemaRegistry\Helpers\ConfigHelper;

use Kafka\SchemaRegistry\Constants\KafkaConfParam;
use Kafka\SchemaRegistry\Constants\TopicConfParam;
use Kafka\SchemaRegistry\Lib\AvroConsumer;

class ConsumerCommand extends KafkaCommand
{

    private const CONFIG_CONTEXT = 'C';

    protected $consumerGroupId = null;
    protected $consumer = null;

    public function prepare($schemaRegistryUrl = null, $brokerList = null)
    {

        $this->schemaRegistryUrl = ($schemaRegistryUrl != null) ? $schemaRegistryUrl : env('SCHEMA_REGISTRY_URL');
        $this->brokerList        = ($brokerList != null) ? $brokerList : env('KAFKA_BROKERS');

        $this->conf = new \RdKafka\Conf();
        
        $this->conf->setRebalanceCb(function (\RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
            switch ($err) {
                case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
                    $kafka->assign($partitions);
                    break;

                case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
                    $kafka->assign(NULL);
                    break;

                default:
                    throw new \Exception($err);
            }
        });

        // Initial list of Kafka brokers
        $this->conf->set(KafkaConfParam::BROKER_LIST, $this->brokerList);
        
        $this->topicConf = new \RdKafka\TopicConf();

        // Set where to start consuming messages when there is no initial offset in
        // offset store or the desired offset is out of range.
        // 'smallest': start from the beginning
        $this->topicConf->set(TopicConfParam::AUTO_OFFSET_RESET, 'smallest');

        // Set the configuration to use for subscribed/assigned topics
        $this->conf->setDefaultTopicConf($this->topicConf);

    }

    public function listen($topics, $callBackClass){
        $this->kafka = new AvroConsumer($this->conf, $this->schemaRegistryUrl, ['register_missing_schemas' => false]);

        $this->kafka->subscribe($topics);

        echo "Waiting for partition assignment... (make take some time when\n";
        echo "quickly re-joining the group after leaving it.)\n";

        while (true) {
            $message = $this->kafka->consume(1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    (new $callBackClass($message))->consume();
                    
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    //echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }
        }
    }

    public function setConsumerGroup($consumerGroupId = null)
    {
        
        if($consumerGroupId == null){
            if(!empty(env('KAFKA_CONSUMER_GROUP_ID'))){
                $consumerGroupId = env('KAFKA_CONSUMER_GROUP_ID');
            }
        }

        if($consumerGroupId != null){
            $this->conf->set(KafkaConfParam::CONSUMER_GROUP_ID, $consumerGroupId);
        }
        
    }

    public function getConfigParams($property = null){
        $array = ConfigHelper::getConfigParams(self::CONFIG_CONTEXT, $property);
        $headers = $array[0];
        unset($array[0]);
        $this->table($headers, $array);
    }

    public function getTopicConfigParams($property = null){
        $array = ConfigHelper::getTopicConfigParams(self::CONFIG_CONTEXT, $property);
        $this->table(ConfigHelper::getTopicConfigParams(self::CONFIG_CONTEXT, $property)[0]);
    }
}

?>