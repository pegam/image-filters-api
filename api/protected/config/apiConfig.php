<?php

return array(
    'httpCodesConfLoc'          => BASE_PATH . '/protected/config/httpCodes.php',
    'apiErrCodesConfLoc'        => BASE_PATH . '/protected/config/apiErrCodes.php',
    'redirectUrl'               => 'http://developers.imagefilters.com/',
    'allowedHttpRequestMethods' => array('GET', 'POST', 'PUT', 'DELETE'),
    'awailableImageFormats'     => array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG),
    'awailableImageFilters'     => array(
        IMG_FILTER_NEGATE         => 'negate',
        IMG_FILTER_GRAYSCALE      => 'grayscale',
        IMG_FILTER_BRIGHTNESS     => 'brightness',
        IMG_FILTER_CONTRAST       => 'contrast',
        IMG_FILTER_COLORIZE       => 'colorize',
        IMG_FILTER_EDGEDETECT     => 'edgedetect',
        IMG_FILTER_EMBOSS         => 'emboss',
        IMG_FILTER_GAUSSIAN_BLUR  => 'gaussianblur',
        IMG_FILTER_SELECTIVE_BLUR => 'selectiveblur',
        IMG_FILTER_MEAN_REMOVAL   => 'meanremoval',
        IMG_FILTER_SMOOTH         => 'smooth',
        IMG_FILTER_PIXELATE       => 'pixelate',
    ),
//    'uploadedImgMaxSize'          => 10240, // php.ini - upload_max_filesize i post_max_size
);

/*
The documentation misses the exact meaning and valid ranges of the arguments for ImageFilter(). According to the 5.2.0 sources the arguments are:
IMG_FILTER_BRIGHTNESS
-255 = min brightness, 0 = no change, +255 = max brightness

IMG_FILTER_CONTRAST
-100 = max contrast, 0 = no change, +100 = min contrast (note the direction!)

IMG_FILTER_COLORIZE
Adds (subtracts) specified RGB values to each pixel. The valid range for each color is -255...+255, not 0...255. The correct order is red, green, blue.
-255 = min, 0 = no change, +255 = max
This has not much to do with IMG_FILTER_GRAYSCALE.

IMG_FILTER_SMOOTH
Applies a 9-cell convolution matrix where center pixel has the weight arg1 and others weight of 1.0. The result is normalized by dividing the sum with arg1 + 8.0 (sum of the matrix).
any float is accepted, large value (in practice: 2048 or more) = no change

ImageFilter seem to return false if the argument(s) are out of range for the chosen filter.
 */

/*
http://www.tuxradar.com/practicalphp/11/2/15
 */