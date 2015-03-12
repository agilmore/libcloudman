<?php

namespace cloudman;

interface DynamicArguments {

  /**
   * Returns an array of arrays keyed to the method name, each method array contains list of argument keys.
   * example:
   * return array(
   *  '__construct' => array('one', 'two'),
   *  'doSomething' => array('thing', 'action')
   * );
   * @return array
   */
  public static function getArguments();

}