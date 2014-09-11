<?php

return array(
  'resources' => array(
    'images' => array(
      'path' => '/{version}/images',
      'actions' => array(
        'types' => array(
          'path' => '/{version}/images/types',
          'httpMethod' => 'GET',
          'description' => 'Returns all image types that API can work with.',
        ),
        'filter' => array(
          'path' => '/{version}/images/filter',
          'httpMethod' => 'POST',
          'parameters' => array(
            'name' => array(
              'type' => 'string',
              'required' => true,
              'choice' => array(
                'brightness' => array(
                  'parameters' => array(
                    'level' => array(
                      'type' => 'integer',
                      'min' => -255,
                      'max' => 255,
                      'required' => true,
                      'description' => 'Level of brightness (-255 = min brightness, 0 = no change, 255 = max brightness).',
                    ),
                  ),
                  'description' => 'Change the brightness of the image.',
                ),
                'colorize' => array(
                  'parameters' => array(
                    'red' => array(
                      'type' => 'integer',
                      'min' => -255,
                      'max' => 255,
                      'required' => true,
                      'description' => 'Red component of image (-255 = min, 0 = no change, 255 = max).',
                    ),
                    'green' => array(
                      'type' => 'integer',
                      'min' => -255,
                      'max' => 255,
                      'required' => true,
                      'description' => 'Green component of image (-255 = min, 0 = no change, 255 = max).',
                    ),
                    'blue' => array(
                      'type' => 'integer',
                      'min' => -255,
                      'max' => 255,
                      'required' => true,
                      'description' => 'Blue component of image (-255 = min, 0 = no change, 255 = max).',
                    ),
                    'alpha' => array(
                      'type' => 'integer',
                      'min' => 0,
                      'max' => 127,
                      'required' => true,
                      'description' => 'Transparency image (0 indicates completely opaque while 127 indicates completely transparent).',
                    ),
                  ),
                  'description' => 'Adds (subtracts) specified RGB values to each pixel.',
                ),
                'contrast' => array(
                  'parameters' => array(
                    'level' => array(
                      'type' => 'integer',
                      'min' => -100,
                      'max' => 100,
                      'required' => true,
                      'description' => 'Level of contrast (-100 = max contrast, 0 = no change, +100 = min contrast).',
                    ),
                  ),
                  'description' => 'Change the contrast of the image.',
                ),
                'edgedetect' => array(
                  'description' => 'Use edge detection to highlight the edges in the image.',
                ),
                'emboss' => array(
                  'description' => 'Emboss the image.',
                ),
                'gaussianblur' => array(
                  'description' => 'Blur the image using the Gaussian method.',
                ),
                'grayscale' => array(
                  'description' => 'Convert the image into grayscale.',
                ),
                'meanremoval' => array(
                  'description' => 'Use mean removal to achieve a "sketchy" effect.',
                ),
                'negate' => array(
                  'description' => 'Reverse all colors of the image. ',
                ),
                'pixelate' => array(
                  'parameters' => array(
                    'size' => array(
                      'type' => 'integer',
                      'min' => 1,
                      'required' => true,
                      'description' => 'The block size.',
                    ),
                  ),
                  'description' => 'Apply pixelation effect to the image.',
                ),
                'selectiveblur' => array(
                  'description' => 'Blur the image.',
                ),
                'smooth' => array(
                  'parameters' => array(
                    'level' => array(
                      'type' => 'float',
                      'required' => true,
                      'description' => 'Any float is accepted, no change for large values (2048 or more).',
                    ),
                  ),
                  'description' => 'Make the image smoother.',
                ),
              ),
              'description' => 'Available filters.',
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Applies filter to the image.',
        ),
        'resize' => array(
          'path' => '/{version}/images/resize',
          'httpMethod' => 'POST',
          'parameters' => array(
            'hsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Horizontal size to scale image to.',
            ),
            'vsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Vertical size to scale image to.',
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Scale image to a new size.',
        ),
        'crop' => array(
          'path' => '/{version}/images/crop',
          'httpMethod' => 'POST',
          'parameters' => array(
            'xpoint' => array(
              'type' => 'integer',
              'min' => 0,
              'required' => true,
              'description' => 'Horizontal coordinate of the upper left vertex of new image (after cropping).',
            ),
            'ypoint' => array(
              'type' => 'integer',
              'min' => 0,
              'required' => true,
              'description' => 'Vertical coordinate of the upper left vertex of new image (after cropping).',
            ),
            'hsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Horizontal size of new image (after cropping).',
            ),
            'vsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Vertical size of new image (after cropping).',
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Remove outer parts of the image.',
        ),
        'fitin' => array(
          'path' => '/{version}/images/fitin',
          'httpMethod' => 'POST',
          'parameters' => array(
            'hsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Horizontal size of imaginary rectangle in which new image should fit in.',
            ),
            'vsize' => array(
              'type' => 'integer',
              'min' => 1,
              'required' => true,
              'description' => 'Vertical size of imaginary rectangle in which new image should fit in.',
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Change image size to fit in corresponding rectangle and keep aspect ratio.',
        ),
        'flip' => array(
          'path' => '/{version}/images/flip',
          'httpMethod' => 'POST',
          'parameters' => array(
            'direction' => array(
              'type' => 'string',
              'choice' => array(
                'horizontal',
                'vertical',
                'both',
              ),
              'required' => true,
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Mirror image across the horizontal, vertical or both axes.',
        ),
        'rotate' => array(
          'path' => '/{version}/images/rotate',
          'httpMethod' => 'POST',
          'parameters' => array(
            'angle' => array(
              'type' => 'float',
              'required' => true,
              'description' => 'Positive values for anticlockwise.',
            ),
            'bgred' => array(
              'type' => 'integer',
              'min' => 0,
              'max' => 255,
              'required' => true,
              'description' => 'Red component of background around rotated image.',
            ),
            'bggreen' => array(
              'type' => 'integer',
              'min' => 0,
              'max' => 255,
              'required' => true,
              'description' => 'Green component of background around rotated image.',
            ),
            'bgblue' => array(
              'type' => 'integer',
              'min' => 0,
              'max' => 255,
              'required' => true,
              'description' => 'Blue component of background around rotated image.',
            ),
            'bgalpha' => array(
              'type' => 'integer',
              'min' => 0,
              'max' => 127,
              'required' => true,
              'description' => 'Transparency of background around rotated image (0 indicates completely opaque while 127 indicates completely transparent).',
            ),
            'url' => array(
              'type' => 'string',
              'required' => false,
              'description' => 'Image url.',
            ),
            'out' => array(
              'type' => 'string',
              'choice' => array(
                'gif',
                'jpeg',
                'jpg',
                'png',
              ),
              'required' => false,
              'description' => 'Output format.',
            ),
          ),
          'description' => 'Rotate image.',
        ),
      )
    )
  )
);