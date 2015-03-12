<?php

namespace cloudman\aws;

use cloudman\ServiceProvider;
use cloudman\ServiceProviderRegion;
use cloudman\Vm;
use cloudman\VmImage;
use cloudman\VmNetworkSettings;
use cloudman\VmStorage;
use cloudman\VmType;

class AwsVm implements Vm {

  private $provider;
  private $image;
  private $type;
  private $region;
  private $network;
  private $storage;
  private $hostname;

  private $awsResponse;

  public function __construct(ServiceProvider $provider,
                              VmImage $image,
                              VmType $type,
                              ServiceProviderRegion $region,
                              VmNetworkSettings $network,
                              VmStorage $storage) {
    $this->provider = $provider;
    $this->image = $image;
    $this->type = $type;
    $this->region = $region;
    $this->network = $network;
    $this->storage = $storage;
  }

  public function getType() {
    return $this->type;
  }

  public function getNetwork() {
    return $this->network;
  }

  public function getImage() {
    return $this->image;
  }

  public function getStorage() {
    return $this->storage;
  }

  public function getRegion() {
    return $this->region;
  }

  public function getServiceProvider() {
    return $this->provider;
  }

  public function setAwsResponse(array $response) {
    $this->awsResponse = $response;
  }

  public function getAwsResponse() {
    return $this->awsResponse;
  }

  public function setHostName($hostname) {
    $this->hostname = $hostname;
  }

  public function getHostName() {
    return $this->hostname;
  }
}