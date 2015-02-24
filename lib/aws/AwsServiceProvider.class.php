<?php

namespace cloudman\aws;

require_once dirname(__FILE__) . '/../..//vendor/autoload.php';

use Aws\Ec2\Ec2Client;
use cloudman\provision\CloudInit;
use cloudman\ProvisionTemplate;
use cloudman\ServiceProvider;
use cloudman\ServiceProviderRegion;
use cloudman\VmImage;
use cloudman\VMNetworkSettings;
use cloudman\VMStorage;
use cloudman\VmType;

class AwsServiceProvider implements ServiceProvider{

  private $supports = array(
    'cloud-init',

  );
  private $options = array();

  public function __construct(array $options) {
    $this->options = $options;
  }

  public function supports($key = null) {
    if ($key === null) {
      return $this->supports;
    }
    else {
      return isset($this->supports[$key]) ? $this->supports[$key] : false;
    }
  }

  public function createVM(VmImage $image,
                           VmType $type,
                           ServiceProviderRegion $region,
                           VmNetworkSettings $network,
                           VmStorage $storage,
                           ProvisionTemplate $template,
                           array $extra_options = array()) {

    if(!$image instanceof AmiImage) {
      throw new Exception(__CLASS__ . ' currently only supports AMI Images');
    }
    if(!$region instanceof AwsRegion) {
      throw new Exception(__CLASS__ . ' currently only supports Amazon Regions');
    }
    if(!$template instanceof CloudInit) {
      throw new Exception(__CLASS__ . ' currently only supports cloud-init provisioning templates');
    }

    $vm = new AwsVm($this, $image, $type, $region, $network, $storage);

    $ec2 = Ec2Client::factory(array(
      'key' => $this->options['key'],
      'secret' => $this->options['secret'],
      'region' => $region->getRegion(),
    ));
    $instance = array(
      'ImageId' => $image->getNativeReference(),
      'MinCount' => 1,
      'MaxCount' => 1,
      'SecurityGroups' => isset($extra_options['security_groups']) ? $extra_options['security_groups'] : array('default'),
      'UserData' => $template->render($vm),
      'InstanceType' => $type->getNativeName(),
      'Placement' => array(
        //'AvailabilityZone' => 'string',
        //'GroupName' => 'string',
        'Tenancy' => $extra_options['tenancy'],
      ),
      'Monitoring' => array(
        'Enabled' => !empty($extra_options['enable_cloudwatch']),
      ),
      'DisableApiTermination' => !empty($extra_options['termination_protection']),
      'InstanceInitiatedShutdownBehavior' => $extra_options['shutdown_behavior'],

    );

    if ($storage !== null) {
      // TODO
      /*
     'BlockDeviceMappings' => array(
        array(
            'VirtualName' => 'string',
            'DeviceName' => 'string',
            'Ebs' => array(
                'SnapshotId' => 'string',
                'VolumeSize' => integer,
                'DeleteOnTermination' => true || false,
                'VolumeType' => 'string',
                'Iops' => integer,
                'Encrypted' => true || false,
            ),
            'NoDevice' => 'string',
        ),
        // ... repeated
       ),
       */
    }

    if ($network !== null) {
      // TODO
      /*
      'SubnetId' => 'string',
      'PrivateIpAddress' => 'string',
      'NetworkInterfaces' => array(
        array(
            'NetworkInterfaceId' => 'string',
            'DeviceIndex' => integer,
            'SubnetId' => 'string',
            'Description' => 'string',
            'PrivateIpAddress' => 'string',
            'Groups' => array('string', ... ),
            'DeleteOnTermination' => true || false,
            'PrivateIpAddresses' => array(
                array(
                    // PrivateIpAddress is required
                    'PrivateIpAddress' => 'string',
                    'Primary' => true || false,
                ),
                // ... repeated
            ),
            'SecondaryPrivateIpAddressCount' => integer,
            'AssociatePublicIpAddress' => true || false,
        ),
        // ... repeated
      ),
      */
    }

    $instance = $ec2->runInstances($instance);

    $vm->setAwsResponse($instance->get('Instances'));
  }

  // TODO: getTypes

  public static function getOptions() {
    return array(
      '__construct' => array(
        'key' => 'AWS Access Key ID',
        'secret' => 'AWS Secret Access Key'
      ),
    );
  }
}