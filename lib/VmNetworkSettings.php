<?php

namespace cloudman;

interface VmNetworkSettings extends DynamicArguments {
  public function getHostname();
  public function getFqdn();
}