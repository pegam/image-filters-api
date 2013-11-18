<?php

class ImagesController extends Controller {

  /**
   * @methods GET
   */
  public function actionTypes () {
    $model = new ImageTypes();
    $model->getTypes();
    $model->output();
  }

  /**
   * @methods GET POST
   */
  public function actionFilter() {
    $filterArgs = $_GET;
    if (!isset($filterArgs['name'])) {
      throw new HttpException(400, 8);
    }
    $filter = $filterArgs['name'];
    if (!in_array($filter, Api::app()->awailableImageFilters)) {
      throw new HttpException(400, 9, null, array('{filter_name}' => $filter));
    }
    unset($filterArgs['name']);
    $dimage = new Image_DownloadedImage();
    $model = new ImageFilter($dimage, $filter, $filterArgs);
    $model->apply();
    $model->output();
  }

  /**
   * @methods GET POST
   */
  public function actionResize() {
    $resizeArgs = $_GET;
    if (!isset($resizeArgs['hsize']) && !isset($resizeArgs['vsize'])) {
      throw new HttpException(400, 20, null, array('{action}' => 'resize'));
    }
    $hsize = null;
    $vsize = null;
    $resample = false;
    if (isset($resizeArgs['hsize']) && is_numeric($resizeArgs['hsize'])) {
      $hsize = (int) $resizeArgs['hsize'];
    }
    if (isset($resizeArgs['vsize']) && is_numeric($resizeArgs['vsize'])) {
      $vsize = (int) $resizeArgs['vsize'];
    }
    if (isset($resizeArgs['resample'])) {
      $resample = filter_var($resizeArgs['resample'], FILTER_VALIDATE_BOOLEAN);
    }

    $dimage = new Image_DownloadedImage();
    $model = new ImageResize($dimage, $hsize, $vsize, $resample);
    $model->apply();
    $model->output();
  }

}