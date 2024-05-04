<?php
// GENERATED CODE -- DO NOT EDIT!

namespace ;

/**
 */
class RatingServiceClient extends \Grpc\BaseStub {

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
        return $this->_simpleRequest('/RatingService/GetRating',
        $argument,
        ['\GetRatingResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \SetRatingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetRating(\SetRatingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/RatingService/SetRating',
        $argument,
        ['\SetRatingResponse', 'decode'],
        $metadata, $options);
    }

}
