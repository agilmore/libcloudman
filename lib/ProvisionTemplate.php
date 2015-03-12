<?php

namespace cloudman;

interface ProvisionTemplate extends DynamicArguments {
  public function render(Vm $host);
}