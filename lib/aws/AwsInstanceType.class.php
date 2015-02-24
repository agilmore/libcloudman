<?php

namespace cloudman\aws;


use cloudman\VmType;

class AWSInstanceType implements VmType {

  private $type = 'm1.small';

  public function __construct(array $args) {
    $this->type = $args['type'];
  }

  public function getNativeName() {
    return $this->type;
  }

  public function getDisplayName() {
    return $this->type;
  }

  public static function getArguments() {
    return array(
      '__construct' => array(
        'type' => 'The AWS Instance type (eg. m3.medium)'
      )
    );
  }
}