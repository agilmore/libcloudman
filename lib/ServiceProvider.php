<?php

namespace cloudman;

require_once dirname(__FILE__) . '/DynamicArguments.php';

interface ServiceProvider extends DynamicArguments {
  public function supports($key = null);
  public function createVM(VmImage $image,
                           VmType $type,
                           ServiceProviderRegion $region,
                           VmNetworkSettings $network,
                           VmStorage $storage,
                           ProvisionTemplate $template,
                           array $extra_options = array());
  public function findVMs($search);
}