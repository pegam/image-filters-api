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
    $model->applyFilter();
    $model->output();
  }

}