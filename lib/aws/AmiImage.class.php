<?php

namespace cloudman\aws;

use cloudman\VmImage;

class AmiImage implements VmImage {

  private $amiId;

  public function __construct(array $options) {
    $this->amiId = $options['ami_id'];
  }

  public function getNativeReference() {
    return $this->amiId;
  }

  public static function getArguments() {
    return array(
      '__construct' => array(
        'ami_id' => 'AMI Id (ami-xxxxxxxx)',
      )
    );
  }
}