<?php

namespace cloudman;

interface VmImage extends DynamicArguments{
  public function getNativeReference();
}
