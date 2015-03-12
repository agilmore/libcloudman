<?php

namespace cloudman\aws;

require_once dirname(__FILE__) . '/../ServiceProviderRegion.php';

use cloudman\ServiceProviderRegion;

class AwsRegion implements ServiceProviderRegion {

  private $region;

  public static function getArguments() {
    return array(
      '__construct' => array(
        'region' => array(
          'description' => 'The region',
          'type' => 'string',
          'options' => array('us-west-1', 'eu-west-1')
        )
      )
    );
  }

  public function __construct(array $args) {
    $allowed = self::getArguments();
    if (isset($args['region']) && in_array($args['region'], $allowed[__FUNCTION__]['region']['options'])) {
      $this->region = $args['region'];
    }
  }

  public function getRegion() {
    return $this->region;
  }
}