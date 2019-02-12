# lumen.kafka.schema-registry

[![release](http://github-release-version.herokuapp.com/github/jsolam/lumen-schema-registry/release.svg?style=flat)](https://github.com/jsolam/lumen-schema-registry/releases/latest)

Library to consume and produce in Apache Kafka < 2.1 and Schema Registry, using Lumen or Laravel console commands. This lib use the base present in Nicofuma/poc-php-kafka lib.

## Installation

```

composer require jsolam/lumen-schema-registry 1.0.*

```
## .env Params
All .env params can be setted in consumer class
```
#Schema registry url
SCHEMA_REGISTRY_URL=http://xx.xx.xx.xx:2181

#List of brokers
KAFKA_BROKERS=xx.xx.xx.xx:9092,xx.xx.xx.xx:9093... 

#Consumer group id or null
KAFKA_CONSUMER_GROUP_ID=myConsumerGroupId

```

## Consumption Usage

```
class MyConsumerCommand extends \Kafka\SchemaRegistry\Commands\ConsumerCommand
{
    ...
    
    public function handle()
    {
        //Prepare basic configs as broker list or RebalanceCb
        $this->prepare(
            $chemaRegistryUrl /* Mandatory if .env SCHEMA_REGISTRY_URL not configured */,
            $brokerList /* Mandatory if .env KAFKA_BROKERS not configured*/,
          );
        
        //Execute if you want to set a consumer group Id to your app
        $this->setConsumerGroup();
        
        //Before call listen method, you can set customs config params via setConf or setTopicConf
        
        //listen method init the Avro Consumer and subscribe it to the desired topics
        
        //You can manage your callback with a callback class
        $this->listen(
            ['topic_xxx'] /* List of topics you want to subscribe your consumer */, 
            CallbackClass::class /* CallbackClass will be used to manage your messages. This class must implements Kafka\SchemaRegistry\Interfaces\ConsumerCallbackInterface*/
        ); 
        
        //Or sending a function which receive the message as second param
        $this->listen(
            ['topic_xxx'], 
            function($message){
              //Do something $message->payload
            }
        );
    }`
    
    ...
}

```
### Consumer default config
##### Consumer

* "metadata.broker.list" (ConsumerConfParam::METADATA_BROKER_LIST) = broker list given

##### Topic
* "auto.offset.reset" (TopicConfParam::AUTO_OFFSET_RESET) = 'smallest'


#### Important:
Your CallbackClass must implements Kafka\SchemaRegistry\Interfaces\ConsumerCallbackInterface presents in vendor


## Production Usage

```
class MyProducerCommand extends \Kafka\SchemaRegistry\Commands\PoducerCommand
{
    ...
    
    public function handle()
    {

        //Set the schema and version which we're going to use
        //No that by default, the schema naming strategy is for schema value is topic-value and for the key topic-key
        //This suffix is added before produce by library
        $this->setSchema('topic', 1);
        $this->setKeySchema('topic', 1);
        
        
        //Prepare basic configs as broker list or copresion type
        $this->prepare(
            $chemaRegistryUrl /* Mandatory if .env SCHEMA_REGISTRY_URL not configured */,
            $brokerList /* Mandatory if .env KAFKA_BROKERS not configured*/,
        );
        
        //Example of schema generated via https://github.com/Landoop/schema-registry-ui
        /*{
          "type": "record",
          "name": "visits",
          "namespace": "com.landoop",
          "doc": "This is a sample Avro schema to get you started. Please edit",
          "fields": [
            {
              "name": "time",
              "type": "int"
            },
            {
              "name": "site",
              "type": "string"
            },
            {
              "name": "ip",
              "type": "string"
            }
          ]
        }*/
        //You can use object or array to generate your items
        $item = new \stdClass();
         $item->time = time();
         $item->site = "www.example.com";
         $item->ip = "192.168.2.".mt_rand(0, 255);

         /*$item = [
           "time" => time(),
           "site" => "www.hola.es",
           "ip"   => "192.168.2.".mt_rand(0, 255)
         ];*/
     
        $data = [$item];
        
        //Schema for visits-key
        /*{
          "type": "record",
          "name": "visits_key",
          "namespace": "com.landoop",
          "doc": "This is a sample Avro schema to get you started. Please edit",
          "fields": [
            {
              "name": "key",
              "type": "string"
            }
          ]
        }*/
        $key  = ["key" => "2"]; 
        
        //Produce data
        $this->produce('topic', $data /* Array of items*/, $key /* Or null */);
        
    }`
    
    ...
}

```
### Producer default config
##### Producer

* "compression.type"          (ProducerConfParam::COMPRESSION_TYPE) = 'snappy'
* "linger.ms"                 (ProducerConfParam::LINGER_MS) = '20'
* "broker.version.fallback"   (ProducerConfParam::BROKER_VERSION_FALLBACK) = '2.0.1'
* "queue.buffering.max.kbytes"(ProducerConfParam::QUEUE_BUFFERING_MAX_KBYTES) = (string)32*1024

##### Topic
None


## Available Config
You can add any extra configuration you need using ConsumerConfParam o ProducerConfParam constants 
before call listen or produce methods depens your context.

To set configs:

```
//Example for producer enable idempotence
$this->setConfig(ProducerConfParam::ENABLE_IDEMPOTENCE, true);

//Example for topic change autocommin interval idempotence
$this->setConfig(TopicConfParam::AUTO_COMMIT_INTERVAL_MS, 500):


```
You can get a full list of current config using dump method present in rdKafka lib
To get configs:

```
dd($this->getConfig()->dump());

//Or

dd($this->getTopicConf()->dump());

```

## More references at

* [confluent-schema-registry-docs](https://docs.confluent.io/current/schema-registry/docs/index.html), Schema registry - Confluent platform documentation
* [schema-registry-ui](https://github.com/Landoop/schema-registry-ui), View, create, evolve and manage your Avro Schemas for multiple Kafka clusters
* [kafka-site](https://kafka.apache.org/20/documentation.html), Kafka site documentation
* [avro-site](http://avro.apache.org/docs/current), Avro site documentation

