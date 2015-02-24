<?php

namespace cloudman;

use cloudman\DynamicArguments;

interface ServiceProviderRegion extends DynamicArguments{
  public function __construct(array $args);
  public function getRegion();
}