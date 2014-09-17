<?php

class ResourcesController extends AController {

  /**
   * @methods GET
   */
  public function actionImages () {
    $action = 'allactions';
    $restOfPath = Api::app()->request->getRestOfPath();
    if ($restOfPath) {
      $action = $restOfPath[0];
    }
    $this->printResourcesDocumentation($action, 'images');
  }

}