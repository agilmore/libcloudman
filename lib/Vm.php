<?php

namespace cloudman;

interface Vm {
  public function getType();
  public function getNetwork();
  public function getImage();
  public function getStorage();
  public function getRegion();

  public function setHostName($hostname);
  public function getHostName();

  public function getServiceProvider();
}