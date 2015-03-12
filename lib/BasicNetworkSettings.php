<?php

namespace cloudman;


class BasicNetworkSettings implements VmNetworkSettings {

  private $hostname;
  private $fqdn;

  function __construct(array $args) {
    $this->hostname = $args['hostname'];
    $this->fqdn = $args['fqdn'];
  }

  public static function getArguments() {
    return array(
      '__construct' => array(
        'hostname' => 'The hostname',
        'fqdn' => 'The fully qualified domain name',
      )
    );
  }

  public function getHostname() {
    return $this->hostname;
  }

  public function getFqdn() {
    return $this->fqdn;
  }
}