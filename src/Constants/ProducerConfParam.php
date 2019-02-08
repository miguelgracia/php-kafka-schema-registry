<?php
namespace Kafka\SchemaRegistry\Constants;

/**
 * Kafka Consumer client which does avro schema decoding of messages.
 * Handles message deserialization.
 */
class ProducerConfParam extends KafkaConfParam
{
    /** 
     * Indicates the builtin features for this build of librdkafka. An application can either query this value or attempt to set it with its list of required features to check for library support. 
     * *Type: CSV flags*
     * Context *
     * 
     * @return String builtin.features
     * 
     * @range
     * @defaulValue gzip, snappy, ssl, sasl, regex, lz4, sasl_gssapi, sasl_plain, sasl_scram, plugins, zstd
     * @Importance low
     * 
    */

    /**
     * Indicates the builtin features for this build of librdkafka. An application can either query this value or attempt to set it with its list of required features to check for library support. 
     * *Type: CSV flags*
     * @return String builtin.features
     */
    public static function BUILT_INT_FEATURES(){return 'builtin.features';}
    //public const BUILT_INT_FEATURES = 'builtin.features'; //Indicates the builtin features for this build of librdkafka. An application can either query this value or attempt to set it with its list of required features to check for library support. <br>*Type: CSV flags*

    public const CONSUMER_GROUP_ID = 'group.id';
    
    public const BROKER_LIST       = 'metadata.broker.list';
    /* */
    public const COMPRESSION_TYPE = 'compression.type';
    public const LINGER_MS = 'linger.ms';
    public const BROKER_VERSION_FALLBACK = 'broker.version.fallback';
    public const QUEUR_BUFFERING_MAX_KBYTES = 'queue.buffering.max.kbytes';


/*    Property                                 | C/P | Range           |       Default | Importance | Description              
-----------------------------------------|-----|-----------------|--------------:|------------| --------------------------
enable.idempotence                       |  P  | true, false     |         false | high       | When set to `true`, the producer will ensure that messages are successfully produced exactly once and in the original produce order. The following configuration properties are adjusted automatically (if not modified by the user) when idempotence is enabled: `max.in.flight.requests.per.connection=5` (must be less than or equal to 5), `retries=INT32_MAX` (must be greater than 0), `acks=all`, `queuing.strategy=fifo`. Producer instantation will fail if user-supplied configuration is incompatible. <br>*Type: boolean*
enable.gapless.guarantee                 |  P  | true, false     |         false | low        | **EXPERIMENTAL**: subject to change or removal. When set to `true`, any error that could result in a gap in the produced message series when a batch of messages fails, will raise a fatal error (ERR__GAPLESS_GUARANTEE) and stop the producer. Messages failing due to `message.timeout.ms` are not covered by this guarantee. Requires `enable.idempotence=true`. <br>*Type: boolean*
queue.buffering.max.messages             |  P  | 1 .. 10000000   |        100000 | high       | Maximum number of messages allowed on the producer queue. This queue is shared by all topics and partitions. <br>*Type: integer*
queue.buffering.max.kbytes               |  P  | 1 .. 2097151    |       1048576 | high       | Maximum total message size sum allowed on the producer queue. This queue is shared by all topics and partitions. This property has higher priority than queue.buffering.max.messages. <br>*Type: integer*
queue.buffering.max.ms                   |  P  | 0 .. 900000     |             0 | high       | Delay in milliseconds to wait for messages in the producer queue to accumulate before constructing message batches (MessageSets) to transmit to brokers. A higher value allows larger and more effective (less overhead, improved compression) batches of messages to accumulate at the expense of increased message delivery latency. <br>*Type: integer*
linger.ms                                |  P  | 0 .. 900000     |             0 | high       | Alias for `queue.buffering.max.ms`: Delay in milliseconds to wait for messages in the producer queue to accumulate before constructing message batches (MessageSets) to transmit to brokers. A higher value allows larger and more effective (less overhead, improved compression) batches of messages to accumulate at the expense of increased message delivery latency. <br>*Type: integer*
message.send.max.retries                 |  P  | 0 .. 10000000   |             2 | high       | How many times to retry sending a failing Message. **Note:** retrying may cause reordering unless `enable.idempotence` is set to true. <br>*Type: integer*
retries                                  |  P  | 0 .. 10000000   |             2 | high       | Alias for `message.send.max.retries`: How many times to retry sending a failing Message. **Note:** retrying may cause reordering unless `enable.idempotence` is set to true. <br>*Type: integer*
retry.backoff.ms                         |  P  | 1 .. 300000     |           100 | medium     | The backoff time in milliseconds before retrying a protocol request. <br>*Type: integer*
queue.buffering.backpressure.threshold   |  P  | 1 .. 1000000    |             1 | low        | The threshold of outstanding not yet transmitted broker requests needed to backpressure the producer's message accumulator. If the number of not yet transmitted requests equals or exceeds this number, produce request creation that would have otherwise been triggered (for example, in accordance with linger.ms) will be delayed. A lower number yields larger and more effective batches. A higher value can improve latency when using compression on slow machines. <br>*Type: integer*
compression.codec                        |  P  | none, gzip, snappy, lz4, zstd |          none | medium     | compression codec to use for compressing message sets. This is the default value for all topics, may be overridden by the topic configuration property `compression.codec`.  <br>*Type: enum value*
compression.type                         |  P  | none, gzip, snappy, lz4, zstd |          none | medium     | Alias for `compression.codec`: compression codec to use for compressing message sets. This is the default value for all topics, may be overridden by the topic configuration property `compression.codec`.  <br>*Type: enum value*
batch.num.messages                       |  P  | 1 .. 1000000    |         10000 | medium     | Maximum number of messages batched in one MessageSet. The total MessageSet size is also limited by message.max.bytes. <br>*Type: integer*
delivery.report.only.error               |  P  | true, false     |         false | low        | Only provide delivery reports for failed messages. <br>*Type: boolean*
dr_cb                                    |  P  |                 |               | low        | Delivery report callback (set with rd_kafka_conf_set_dr_cb()) <br>*Type: pointer*
dr_msg_cb                                |  P  |                 |               | low        | Delivery report callback (set with rd_kafka_conf_set_dr_msg_cb()) <br>*Type: pointer*


    array:76 [
        "builtin.features" => "snappy,ssl,sasl,regex,lz4,sasl_plain,sasl_scram,plugins"
        "client.id" => "rdkafka"
        "message.max.bytes" => "1000000"
        "message.copy.max.bytes" => "65535"
        "receive.message.max.bytes" => "100000000"
        "max.in.flight.requests.per.connection" => "1000000"
        "metadata.request.timeout.ms" => "60000"
        "topic.metadata.refresh.interval.ms" => "300000"
        "metadata.max.age.ms" => "900000"
        "topic.metadata.refresh.fast.interval.ms" => "250"
        "topic.metadata.refresh.fast.cnt" => "10"
        "topic.metadata.refresh.sparse" => "true"
        "debug" => ""
        "socket.timeout.ms" => "60000"
        "socket.blocking.max.ms" => "1000"
        "socket.send.buffer.bytes" => "0"
        "socket.receive.buffer.bytes" => "0"
        "socket.keepalive.enable" => "false"
        "socket.nagle.disable" => "false"
        "socket.max.fails" => "1"
        "broker.address.ttl" => "1000"
        "broker.address.family" => "any"
        "enable.sparse.connections" => "true"
        "reconnect.backoff.jitter.ms" => "0"
        "reconnect.backoff.ms" => "100"
        "reconnect.backoff.max.ms" => "10000"
        "statistics.interval.ms" => "0"
        "enabled_events" => "0"
        "log_cb" => "0x7f9c08f66bf0"
        "log_level" => "6"
        "log.queue" => "false"
        "log.thread.name" => "true"
        "log.connection.close" => "true"
        "socket_cb" => "0x7f9c08f7ba10"
        "open_cb" => "0x7f9c08f910c0"
        "internal.termination.signal" => "0"
        "api.version.request" => "true"
        "api.version.request.timeout.ms" => "10000"
        "api.version.fallback.ms" => "1200000"
        "broker.version.fallback" => "0.9.0"
        "security.protocol" => "plaintext"
        "sasl.mechanisms" => "GSSAPI"
        "sasl.kerberos.service.name" => "kafka"
        "sasl.kerberos.principal" => "kafkaclient"
        "sasl.kerberos.kinit.cmd" => "kinit -S "%{sasl.kerberos.service.name}/%{broker.name}" -k-t "%{sasl.kerberos.keytab}" %{sasl.kerberos.principal}"
        "sasl.kerberos.min.time.before.relogin" => "60000"
        "partition.assignment.strategy" => "range,roundrobin"
        "session.timeout.ms" => "10000"
        "heartbeat.interval.ms" => "3000"
        "group.protocol.type" => "consumer"
        "coordinator.query.interval.ms" => "600000"
        "max.poll.interval.ms" => "300000"
        "enable.auto.commit" => "true"
        "auto.commit.interval.ms" => "5000"
        "enable.auto.offset.store" => "true"
        "queued.min.messages" => "100000"
        "queued.max.messages.kbytes" => "1048576"
        "fetch.wait.max.ms" => "100"
        "fetch.message.max.bytes" => "1048576"
        "fetch.max.bytes" => "52428800"
        "fetch.min.bytes" => "1"
        "fetch.error.backoff.ms" => "500"
        "offset.store.method" => "broker"
        "enable.partition.eof" => "true"
        "check.crcs" => "false"
        "enable.idempotence" => "false"
        "enable.gapless.guarantee" => "true"
        "queue.buffering.max.messages" => "100000"
        "queue.buffering.max.kbytes" => "1048576"
        "queue.buffering.max.ms" => "0"
        "message.send.max.retries" => "2"
        "retry.backoff.ms" => "100"
        "queue.buffering.backpressure.threshold" => "1"
        "compression.codec" => "none"
        "batch.num.messages" => "10000"
        "delivery.report.only.error" => "false"
      ]


 */   
}