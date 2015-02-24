<?php

namespace cloudman;

interface ServiceProvider {
  public function supports($key = null);
  public function createVM(VmImage $image,
                           VmType $type,
                           ServiceProviderRegion $region,
                           VmNetworkSettings $network,
                           VmStorage $storage,
                           ProvisionTemplate $template,
                           array $extra_options = array());

  public static function getOptions();
}