<?php

namespace cloudman\provision;

use cloudman\ProvisionTemplate;
use cloudman\Vm;
use cloudman\VmImage;
use cloudman\VmType;

class CloudInit implements ProvisionTemplate{

  private $data;

  public function __construct(array $args) {
    $this->data = $args['data'];
  }

  public function render(Vm $host) {
    $data = $this->data;
    $data = $this->replaceTokens(array(
      'hostname' => $host->getNetwork()->getHostname(),
      'fqdn' => $host->getNetwork()->getFqdn(),
      'built_url' => 'http://www.example.com/',
    ), $data);
    return base64_encode($data);
  }

  /**
   * array(
   *   'tokenname' => 'replacementvalue'
   * )
   * @param array $tokens
   * @param string $text
   * @return string
   */
  private function replaceTokens(array $tokens, $text) {
    $text = preg_replace_callback('/{{([a-z_]*)}}/', function(array $matches) use ($tokens) {
      return $tokens[$matches[1]];
    }, $text);
    return $text;
  }

  public static function getArguments() {
    return array(
      '__construct' => array(
        'data' => array(
          'description' => 'The cloud-init config file as a string',
          'type' => 'string',
        )
      )
    );
  }
}