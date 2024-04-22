<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/rating.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>GetRatingResponse</code>
 */
class GetRatingResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string rating = 1 [json_name = "rating"];</code>
     */
    protected $rating = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $rating
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Proto\Rating::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string rating = 1 [json_name = "rating"];</code>
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Generated from protobuf field <code>string rating = 1 [json_name = "rating"];</code>
     * @param string $var
     * @return $this
     */
    public function setRating($var)
    {
        GPBUtil::checkString($var, True);
        $this->rating = $var;

        return $this;
    }

}

