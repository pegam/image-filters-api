<?php

class ImagesController extends AController {

  /**
   * @methods GET
   */
  public function actionTypes () {
    $model = new ImageMdl_Types();
    $model->getTypes();
    $model->output();
  }

  /**
   * @methods POST
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
    $model = new ImageMdl_Filter($dimage, $filter, $filterArgs);
    $model->apply();
    $model->output();
  }

  /**
   * @methods POST
   */
  public function actionResize() {
    $resizeArgs = $_GET;
    if (!isset($resizeArgs['hsize']) && !isset($resizeArgs['vsize'])) {
      throw new HttpException(400, 20);
    }
    $hsize = null;
    $vsize = null;
    $resample = true;
    if (isset($resizeArgs['hsize']) && is_numeric($resizeArgs['hsize'])) {
      $hsize = (int) $resizeArgs['hsize'];
    }
    if (isset($resizeArgs['vsize']) && is_numeric($resizeArgs['vsize'])) {
      $vsize = (int) $resizeArgs['vsize'];
    }
    $dimage = new Image_DownloadedImage();
    $model = new ImageMdl_Resize($dimage, $hsize, $vsize, $resample);
    $model->apply();
    $model->output();
  }

  /**
   * @methods POST
   */
  public function actionCrop() {
    $cropArgs = $_GET;
    if (!isset($cropArgs['hsize']) && !isset($cropArgs['vsize'])) {
      throw new HttpException(400, 21);
    }
    $xpoint = null;
    $ypoint = null;
    $hsize = null;
    $vsize = null;
    $resample = true;
    if (isset($cropArgs['xpoint']) && is_numeric($cropArgs['xpoint'])) {
      $xpoint = (int) $cropArgs['xpoint'];
    }
    if (isset($cropArgs['ypoint']) && is_numeric($cropArgs['ypoint'])) {
      $ypoint = (int) $cropArgs['ypoint'];
    }
    if (isset($cropArgs['hsize']) && is_numeric($cropArgs['hsize'])) {
      $hsize = (int) $cropArgs['hsize'];
    }
    if (isset($cropArgs['vsize']) && is_numeric($cropArgs['vsize'])) {
      $vsize = (int) $cropArgs['vsize'];
    }
    $dimage = new Image_DownloadedImage();
    $model = new ImageMdl_Crop($dimage, $xpoint, $ypoint, $hsize, $vsize, $resample);
    $model->apply();
    $model->output();
  }

  /**
   * @methods POST
   */
  public function actionFitin() {
    $fitinArgs = $_GET;
    if (!isset($fitinArgs['hsize']) && !isset($fitinArgs['vsize'])) {
      throw new HttpException(400, 23);
    }
    $hsize = null;
    $vsize = null;
    $resample = true;
    if (isset($fitinArgs['hsize']) && is_numeric($fitinArgs['hsize'])) {
      $hsize = (int) $fitinArgs['hsize'];
    }
    if (isset($fitinArgs['vsize']) && is_numeric($fitinArgs['vsize'])) {
      $vsize = (int) $fitinArgs['vsize'];
    }
    $dimage = new Image_DownloadedImage();
    $model = new ImageMdl_FitIn($dimage, $hsize, $vsize, $resample);
    $model->apply();
    $model->output();
  }

  /**
   * @methods POST
   */
  public function actionFlip() {
    $flipArgs = $_GET;
    if (!isset($flipArgs['direction'])) {
      throw new HttpException(400, 24);
    }
    $direction = $flipArgs['direction'];
    if ($direction !== ImageMdl_Flip::FLIP_HORIZONTAL
            && $direction !== ImageMdl_Flip::FLIP_VERTICAL
            && $direction !== ImageMdl_Flip::FLIP_BOTH) {
      throw new HttpException(400, 24);
    }
    $dimage = new Image_DownloadedImage();
    $model = new ImageMdl_Flip($dimage, $direction);
    $model->apply();
    $model->output();
  }

  /**
   * @methods POST
   */
  public function actionRotate() {
    $rotateArgs = $_GET;
    if (!isset($rotateArgs['angle']) || !is_numeric($rotateArgs['angle'])) {
      throw new HttpException(400, 25);
    }
    $angle = (float) $rotateArgs['angle'];
    $bgred = ImageMdl_Rotate::COLOR_MIN;
    $bggreen = ImageMdl_Rotate::COLOR_MIN;
    $bgblue = ImageMdl_Rotate::COLOR_MIN;
    $bgalpha = ImageMdl_Rotate::ALPHA_MAX;
    if (isset($rotateArgs['bgred']) && is_numeric($rotateArgs['bgred'])) {
      $bgred = (int) $rotateArgs['bgred'];
      if ($bgred < ImageMdl_Rotate::COLOR_MIN || $bgred > ImageMdl_Rotate::COLOR_MAX) {
        throw new HttpException(400, 25);
      }
    }
    if (isset($rotateArgs['bggreen']) && is_numeric($rotateArgs['bggreen'])) {
      $bggreen = (int) $rotateArgs['bggreen'];
      if ($bggreen < ImageMdl_Rotate::COLOR_MIN || $bggreen > ImageMdl_Rotate::COLOR_MAX) {
        throw new HttpException(400, 25);
      }
    }
    if (isset($rotateArgs['bgblue']) && is_numeric($rotateArgs['bgblue'])) {
      $bgblue = (int) $rotateArgs['bgblue'];
      if ($bgblue < ImageMdl_Rotate::COLOR_MIN || $bgblue > ImageMdl_Rotate::COLOR_MAX) {
        throw new HttpException(400, 25);
      }
    }
    if (isset($rotateArgs['bgalpha']) && is_numeric($rotateArgs['bgalpha'])) {
      $bgalpha = (int) $rotateArgs['bgalpha'];
      if ($bgalpha < ImageMdl_Rotate::ALPHA_MIN || $bgalpha > ImageMdl_Rotate::ALPHA_MAX) {
        throw new HttpException(400, 25);
      }
    }
    $dimage = new Image_DownloadedImage();
    $model = new ImageMdl_Rotate($dimage, $angle, $bgred, $bggreen, $bgblue, $bgalpha);
    $model->apply();
    $model->output();
  }

}