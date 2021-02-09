<?php

namespace Cactus\Core;

abstract class Base_Cron {

  protected $name;
  protected $period='daily';

  abstract public function init();

  public function __construct() {
    add_action('admin_head', [$this, 'register']);
    add_action($this->name, [$this, 'init']);
  }

  public function register() {
    if (!wp_next_scheduled($this->name)) {
      wp_schedule_event(time(), $this->period, $this->name);
    }
  }

}