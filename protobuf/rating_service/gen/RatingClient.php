<?php
// GENERATED CODE -- DO NOT EDIT!

namespace ;

/**
 * TODO: protobuf messages shared between projects
 *
 */
class RatingClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \GetRatingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRating(\GetRatingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/Rating/GetRating',
        $argument,
        ['\GetRatingResponse', 'decode'],
        $metadata, $options);
    }

}
