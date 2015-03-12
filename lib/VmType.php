<?php

namespace cloudman;

interface VmType extends DynamicArguments{
  public function __construct(array $args);
  public function getNativeName();
  public function getDisplayName();
}