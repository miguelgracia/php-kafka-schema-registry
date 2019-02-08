<?php
namespace Kafka\SchemaRegistry\Constants;

/**
 * Kafka Consumer client which does avro schema decoding of messages.
 * Handles message deserialization.
 */
class KafkaConfParam
{
    /**
     * Indicates the builtin features for this build of librdkafka. 
     * An application can either query this value or attempt to set it with its list of required features to check for library support. 
     * *Type: CSV flags*
     * defaulValue gzip, snappy, ssl, sasl, regex, lz4, sasl_gssapi, sasl_plain, sasl_scram, plugins, zstd
     * Importance low
     */
    public const  BUILT_INT_FEATURES =  'builtin.features';


    public const  CLIENT_ID =  'client.id';
    
    

    public const CONSUMER_GROUP_ID = 'group.id';
    
    
    /* */
    public const BROKER_LIST = 'metadata.broker.list';
    public const COMPRESSION_TYPE = 'compression.type';
    public const LINGER_MS = 'linger.ms';
    public const BROKER_VERSION_FALLBACK = 'broker.version.fallback';
    public const QUEUE_BUFFERING_MAX_KBYTES = 'queue.buffering.max.kbytes';


/*    Property                                 | C/P | Range           |       Default | Importance | Description              
-----------------------------------------|-----|-----------------|--------------:|------------| --------------------------
builtin.features                         |  *  |                 | gzip, snappy, ssl, sasl, regex, lz4, sasl_gssapi, sasl_plain, sasl_scram, plugins, zstd | low        | Indicates the builtin features for this build of librdkafka. An application can either query this value or attempt to set it with its list of required features to check for library support. <br>*Type: CSV flags*
client.id                                |  *  |                 |       rdkafka | low        | Client identifier. <br>*Type: string*
metadata.broker.list                     |  *  |                 |               | high       | Initial list of brokers as a CSV list of broker host or host:port. The application may also use `rd_kafka_brokers_add()` to add brokers during runtime. <br>*Type: string*
bootstrap.servers                        |  *  |                 |               | high       | Alias for `metadata.broker.list`: Initial list of brokers as a CSV list of broker host or host:port. The application may also use `rd_kafka_brokers_add()` to add brokers during runtime. <br>*Type: string*
message.max.bytes                        |  *  | 1000 .. 1000000000 |       1000000 | medium     | Maximum Kafka protocol request message size. <br>*Type: integer*
message.copy.max.bytes                   |  *  | 0 .. 1000000000 |         65535 | low        | Maximum size for message to be copied to buffer. Messages larger than this will be passed by reference (zero-copy) at the expense of larger iovecs. <br>*Type: integer*
receive.message.max.bytes                |  *  | 1000 .. 2147483647 |     100000000 | medium     | Maximum Kafka protocol response message size. This serves as a safety precaution to avoid memory exhaustion in case of protocol hickups. This value must be at least `fetch.max.bytes`  + 512 to allow for protocol overhead; the value is adjusted automatically unless the configuration property is explicitly set. <br>*Type: integer*
max.in.flight.requests.per.connection    |  *  | 1 .. 1000000    |       1000000 | low        | Maximum number of in-flight requests per broker connection. This is a generic property applied to all broker communication, however it is primarily relevant to produce requests. In particular, note that other mechanisms limit the number of outstanding consumer fetch request per broker to one. <br>*Type: integer*
max.in.flight                            |  *  | 1 .. 1000000    |       1000000 | low        | Alias for `max.in.flight.requests.per.connection`: Maximum number of in-flight requests per broker connection. This is a generic property applied to all broker communication, however it is primarily relevant to produce requests. In particular, note that other mechanisms limit the number of outstanding consumer fetch request per broker to one. <br>*Type: integer*
metadata.request.timeout.ms              |  *  | 10 .. 900000    |         60000 | low        | Non-topic request timeout in milliseconds. This is for metadata requests, etc. <br>*Type: integer*
topic.metadata.refresh.interval.ms       |  *  | -1 .. 3600000   |        300000 | low        | Topic metadata refresh interval in milliseconds. The metadata is automatically refreshed on error and connect. Use -1 to disable the intervalled refresh. <br>*Type: integer*
metadata.max.age.ms                      |  *  | 1 .. 86400000   |        900000 | low        | Metadata cache max age. Defaults to topic.metadata.refresh.interval.ms * 3 <br>*Type: integer*
topic.metadata.refresh.fast.interval.ms  |  *  | 1 .. 60000      |           250 | low        | When a topic loses its leader a new metadata request will be enqueued with this initial interval, exponentially increasing until the topic metadata has been refreshed. This is used to recover quickly from transitioning leader brokers. <br>*Type: integer*
topic.metadata.refresh.fast.cnt          |  *  | 0 .. 1000       |            10 | low        | **DEPRECATED** No longer used. <br>*Type: integer*
topic.metadata.refresh.sparse            |  *  | true, false     |          true | low        | Sparse metadata requests (consumes less network bandwidth) <br>*Type: boolean*
topic.blacklist                          |  *  |                 |               | low        | Topic blacklist, a comma-separated list of regular expressions for matching topic names that should be ignored in broker metadata information as if the topics did not exist. <br>*Type: pattern list*
debug                                    |  *  | generic, broker, topic, metadata, feature, queue, msg, protocol, cgrp, security, fetch, interceptor, plugin, consumer, admin, eos, all |               | medium     | A comma-separated list of debug contexts to enable. Detailed Producer debugging: broker,topic,msg. Consumer: consumer,cgrp,topic,fetch <br>*Type: CSV flags*
socket.timeout.ms                        |  *  | 10 .. 300000    |         60000 | low        | Default timeout for network requests. Producer: ProduceRequests will use the lesser value of `socket.timeout.ms` and remaining `message.timeout.ms` for the first message in the batch. Consumer: FetchRequests will use `fetch.wait.max.ms` + `socket.timeout.ms`. Admin: Admin requests will use `socket.timeout.ms` or explicitly set `rd_kafka_AdminOptions_set_operation_timeout()` value. <br>*Type: integer*
socket.blocking.max.ms                   |  *  | 1 .. 60000      |          1000 | low        | **DEPRECATED** No longer used. <br>*Type: integer*
socket.send.buffer.bytes                 |  *  | 0 .. 100000000  |             0 | low        | Broker socket send buffer size. System default is used if 0. <br>*Type: integer*
socket.receive.buffer.bytes              |  *  | 0 .. 100000000  |             0 | low        | Broker socket receive buffer size. System default is used if 0. <br>*Type: integer*
socket.keepalive.enable                  |  *  | true, false     |         false | low        | Enable TCP keep-alives (SO_KEEPALIVE) on broker sockets <br>*Type: boolean*
socket.nagle.disable                     |  *  | true, false     |         false | low        | Disable the Nagle algorithm (TCP_NODELAY) on broker sockets. <br>*Type: boolean*
socket.max.fails                         |  *  | 0 .. 1000000    |             1 | low        | Disconnect from broker when this number of send failures (e.g., timed out requests) is reached. Disable with 0. WARNING: It is highly recommended to leave this setting at its default value of 1 to avoid the client and broker to become desynchronized in case of request timeouts. NOTE: The connection is automatically re-established. <br>*Type: integer*
broker.address.ttl                       |  *  | 0 .. 86400000   |          1000 | low        | How long to cache the broker address resolving results (milliseconds). <br>*Type: integer*
broker.address.family                    |  *  | any, v4, v6     |           any | low        | Allowed broker IP address families: any, v4, v6 <br>*Type: enum value*
enable.sparse.connections                |  *  | true, false     |          true | medium     | When enabled the client will only connect to brokers it needs to communicate with. When disabled the client will maintain connections to all brokers in the cluster. <br>*Type: boolean*
reconnect.backoff.jitter.ms              |  *  | 0 .. 3600000    |             0 | low        | **DEPRECATED** No longer used. See `reconnect.backoff.ms` and `reconnect.backoff.max.ms`. <br>*Type: integer*
reconnect.backoff.ms                     |  *  | 0 .. 3600000    |           100 | medium     | The initial time to wait before reconnecting to a broker after the connection has been closed. The time is increased exponentially until `reconnect.backoff.max.ms` is reached. -25% to +50% jitter is applied to each reconnect backoff. A value of 0 disables the backoff and reconnects immediately. <br>*Type: integer*
reconnect.backoff.max.ms                 |  *  | 0 .. 3600000    |         10000 | medium     | The maximum time to wait before reconnecting to a broker after the connection has been closed. <br>*Type: integer*
statistics.interval.ms                   |  *  | 0 .. 86400000   |             0 | high       | librdkafka statistics emit interval. The application also needs to register a stats callback using `rd_kafka_conf_set_stats_cb()`. The granularity is 1000ms. A value of 0 disables statistics. <br>*Type: integer*
enabled_events                           |  *  | 0 .. 2147483647 |             0 | low        | See `rd_kafka_conf_set_events()` <br>*Type: integer*
error_cb                                 |  *  |                 |               | low        | Error callback (set with rd_kafka_conf_set_error_cb()) <br>*Type: pointer*
throttle_cb                              |  *  |                 |               | low        | Throttle callback (set with rd_kafka_conf_set_throttle_cb()) <br>*Type: pointer*
stats_cb                                 |  *  |                 |               | low        | Statistics callback (set with rd_kafka_conf_set_stats_cb()) <br>*Type: pointer*
log_cb                                   |  *  |                 |               | low        | Log callback (set with rd_kafka_conf_set_log_cb()) <br>*Type: pointer*
log_level                                |  *  | 0 .. 7          |             6 | low        | Logging level (syslog(3) levels) <br>*Type: integer*
log.queue                                |  *  | true, false     |         false | low        | Disable spontaneous log_cb from internal librdkafka threads, instead enqueue log messages on queue set with `rd_kafka_set_log_queue()` and serve log callbacks or events through the standard poll APIs. **NOTE**: Log messages will linger in a temporary queue until the log queue has been set. <br>*Type: boolean*
log.thread.name                          |  *  | true, false     |          true | low        | Print internal thread name in log messages (useful for debugging librdkafka internals) <br>*Type: boolean*
log.connection.close                     |  *  | true, false     |          true | low        | Log broker disconnects. It might be useful to turn this off when interacting with 0.9 brokers with an aggressive `connection.max.idle.ms` value. <br>*Type: boolean*
background_event_cb                      |  *  |                 |               | low        | Background queue event callback (set with rd_kafka_conf_set_background_event_cb()) <br>*Type: pointer*
socket_cb                                |  *  |                 |               | low        | Socket creation callback to provide race-free CLOEXEC <br>*Type: pointer*
connect_cb                               |  *  |                 |               | low        | Socket connect callback <br>*Type: pointer*
closesocket_cb                           |  *  |                 |               | low        | Socket close callback <br>*Type: pointer*
open_cb                                  |  *  |                 |               | low        | File open callback to provide race-free CLOEXEC <br>*Type: pointer*
opaque                                   |  *  |                 |               | low        | Application opaque (set with rd_kafka_conf_set_opaque()) <br>*Type: pointer*
default_topic_conf                       |  *  |                 |               | low        | Default topic configuration for automatically subscribed topics <br>*Type: pointer*
internal.termination.signal              |  *  | 0 .. 128        |             0 | low        | Signal that librdkafka will use to quickly terminate on rd_kafka_destroy(). If this signal is not set then there will be a delay before rd_kafka_wait_destroyed() returns true as internal threads are timing out their system calls. If this signal is set however the delay will be minimal. The application should mask this signal as an internal signal handler is installed. <br>*Type: integer*
api.version.request                      |  *  | true, false     |          true | high       | Request broker's supported API versions to adjust functionality to available protocol features. If set to false, or the ApiVersionRequest fails, the fallback version `broker.version.fallback` will be used. **NOTE**: Depends on broker version >=0.10.0. If the request is not supported by (an older) broker the `broker.version.fallback` fallback is used. <br>*Type: boolean*
api.version.request.timeout.ms           |  *  | 1 .. 300000     |         10000 | low        | Timeout for broker API version requests. <br>*Type: integer*
api.version.fallback.ms                  |  *  | 0 .. 604800000  |             0 | medium     | Dictates how long the `broker.version.fallback` fallback is used in the case the ApiVersionRequest fails. **NOTE**: The ApiVersionRequest is only issued when a new connection to the broker is made (such as after an upgrade). <br>*Type: integer*
broker.version.fallback                  |  *  |                 |        0.10.0 | medium     | Older broker versions (before 0.10.0) provide no way for a client to query for supported protocol features (ApiVersionRequest, see `api.version.request`) making it impossible for the client to know what features it may use. As a workaround a user may set this property to the expected broker version and the client will automatically adjust its feature set accordingly if the ApiVersionRequest fails (or is disabled). The fallback broker version will be used for `api.version.fallback.ms`. Valid values are: 0.9.0, 0.8.2, 0.8.1, 0.8.0. Any other value >= 0.10, such as 0.10.2.1, enables ApiVersionRequests. <br>*Type: string*
security.protocol                        |  *  | plaintext, ssl, sasl_plaintext, sasl_ssl |     plaintext | high       | Protocol used to communicate with brokers. <br>*Type: enum value*
ssl.cipher.suites                        |  *  |                 |               | low        | A cipher suite is a named combination of authentication, encryption, MAC and key exchange algorithm used to negotiate the security settings for a network connection using TLS or SSL network protocol. See manual page for `ciphers(1)` and `SSL_CTX_set_cipher_list(3). <br>*Type: string*
ssl.curves.list                          |  *  |                 |               | low        | The supported-curves extension in the TLS ClientHello message specifies the curves (standard/named, or 'explicit' GF(2^k) or GF(p)) the client is willing to have the server use. See manual page for `SSL_CTX_set1_curves_list(3)`. OpenSSL >= 1.0.2 required. <br>*Type: string*
ssl.sigalgs.list                         |  *  |                 |               | low        | The client uses the TLS ClientHello signature_algorithms extension to indicate to the server which signature/hash algorithm pairs may be used in digital signatures. See manual page for `SSL_CTX_set1_sigalgs_list(3)`. OpenSSL >= 1.0.2 required. <br>*Type: string*
ssl.key.location                         |  *  |                 |               | low        | Path to client's private key (PEM) used for authentication. <br>*Type: string*
ssl.key.password                         |  *  |                 |               | low        | Private key passphrase <br>*Type: string*
ssl.certificate.location                 |  *  |                 |               | low        | Path to client's public key (PEM) used for authentication. <br>*Type: string*
ssl.ca.location                          |  *  |                 |               | medium     | File or directory path to CA certificate(s) for verifying the broker's key. <br>*Type: string*
ssl.crl.location                         |  *  |                 |               | low        | Path to CRL for verifying broker's certificate validity. <br>*Type: string*
ssl.keystore.location                    |  *  |                 |               | low        | Path to client's keystore (PKCS#12) used for authentication. <br>*Type: string*
ssl.keystore.password                    |  *  |                 |               | low        | Client's keystore (PKCS#12) password. <br>*Type: string*
sasl.mechanisms                          |  *  |                 |        GSSAPI | high       | SASL mechanism to use for authentication. Supported: GSSAPI, PLAIN, SCRAM-SHA-256, SCRAM-SHA-512. **NOTE**: Despite the name only one mechanism must be configured. <br>*Type: string*
sasl.mechanism                           |  *  |                 |        GSSAPI | high       | Alias for `sasl.mechanisms`: SASL mechanism to use for authentication. Supported: GSSAPI, PLAIN, SCRAM-SHA-256, SCRAM-SHA-512. **NOTE**: Despite the name only one mechanism must be configured. <br>*Type: string*
sasl.kerberos.service.name               |  *  |                 |         kafka | low        | Kerberos principal name that Kafka runs as, not including /hostname@REALM <br>*Type: string*
sasl.kerberos.principal                  |  *  |                 |   kafkaclient | low        | This client's Kerberos principal name. (Not supported on Windows, will use the logon user's principal). <br>*Type: string*
sasl.kerberos.kinit.cmd                  |  *  |                 | kinit -S "%{sasl.kerberos.service.name}/%{broker.name}" -k -t "%{sasl.kerberos.keytab}" %{sasl.kerberos.principal} | low        | Full kerberos kinit command string, %{config.prop.name} is replaced by corresponding config object value, %{broker.name} returns the broker's hostname. <br>*Type: string*
sasl.kerberos.keytab                     |  *  |                 |               | low        | Path to Kerberos keytab file. Uses system default if not set.**NOTE**: This is not automatically used but must be added to the template in sasl.kerberos.kinit.cmd as ` ... -t %{sasl.kerberos.keytab}`. <br>*Type: string*
sasl.kerberos.min.time.before.relogin    |  *  | 1 .. 86400000   |         60000 | low        | Minimum time in milliseconds between key refresh attempts. <br>*Type: integer*
sasl.username                            |  *  |                 |               | high       | SASL username for use with the PLAIN and SASL-SCRAM-.. mechanisms <br>*Type: string*
sasl.password                            |  *  |                 |               | high       | SASL password for use with the PLAIN and SASL-SCRAM-.. mechanism <br>*Type: string*
plugin.library.paths                     |  *  |                 |               | low        | List of plugin libraries to load (; separated). The library search path is platform dependent (see dlopen(3) for Unix and LoadLibrary() for Windows). If no filename extension is specified the platform-specific extension (such as .dll or .so) will be appended automatically. <br>*Type: string*
interceptors                             |  *  |                 |               | low        | Interceptors added through rd_kafka_conf_interceptor_add_..() and any configuration handled by interceptors. <br>*Type: *


 */   
}