<?php

namespace Drupal\playground\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  private $gridder;

  public function __construct($gridder) {
    $this->gridder = $gridder;
  }


  public static function create(ContainerInterface $container) {
    $gridder = $container->get('playground.gridder');
    return new static($gridder);
  }


  public function test() {


    $default = [
      '#theme' => 'playground',
      '#test_var' => $this->t("testing complete"),
      '#new_var' => "Some brand new variable",
        ];

    return $default;
  }

}
