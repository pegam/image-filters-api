<?php

return array(
  'resources' => array(
    'images' => array(
      'actions' => array(
        'types' => array(
          'GET' => array(
            'description' => 'Returns all image types that API can work with.',
          ),
        ),
        'filter' => array(
          'POST' => array(
            'parameters' => array(
              'name' => array(
                'type' => 'string',
                'required' => true,
                'choice' => array(
                  'brightness' => array(
                    'parameters' => array(
                      'level' => array(
                        'type' => 'int',
                        'min' => -255,
                        'max' => 255,
                        'required' => true,
                        'descriptopn' => 'Level of brightness (-255 = min brightness, 0 = no change, 255 = max brightness).',
                      ),
                    ),
                    'descriptopn' => 'Change the brightness of the image.',
                  ),
                  'colorize' => array(
                    'parameters' => array(
                      'red' => array(
                        'type' => 'int',
                        'min' => -255,
                        'max' => 255,
                        'required' => true,
                        'description' => 'Red component of image (-255 = min, 0 = no change, 255 = max).',
                      ),
                      'green' => array(
                        'type' => 'int',
                        'min' => -255,
                        'max' => 255,
                        'required' => true,
                        'description' => 'Green component of image (-255 = min, 0 = no change, 255 = max).',
                      ),
                      'blue' => array(
                        'type' => 'int',
                        'min' => -255,
                        'max' => 255,
                        'required' => true,
                        'description' => 'Blue component of image (-255 = min, 0 = no change, 255 = max).',
                      ),
                      'alpha' => array(
                        'type' => 'int',
                        'min' => 0,
                        'max' => 127,
                        'required' => true,
                        'description' => 'Transparency image (0 indicates completely opaque while 127 indicates completely transparent).',
                      ),
                    ),
                    'descriptopn' => 'Adds (subtracts) specified RGB values to each pixel.',
                  ),
                  'contrast' => array(
                    'parameters' => array(
                      'level' => array(
                        'type' => 'int',
                        'min' => -100,
                        'max' => 100,
                        'required' => true,
                        'descriptopn' => 'Level of contrast (-100 = max contrast, 0 = no change, +100 = min contrast).',
                      ),
                    ),
                    'descriptopn' => 'Change the contrast of the image.',
                  ),
                  'edgedetect' => array(
                    'descriptopn' => 'Use edge detection to highlight the edges in the image.',
                  ),
                  'emboss' => array(
                    'descriptopn' => 'Emboss the image.',
                  ),
                  'gaussianblur' => array(
                    'descriptopn' => 'Blur the image using the Gaussian method.',
                  ),
                  'grayscale' => array(
                    'descriptopn' => 'Convert the image into grayscale.',
                  ),
                  'meanremoval' => array(
                    'descriptopn' => 'Use mean removal to achieve a "sketchy" effect.',
                  ),
                  'negate' => array(
                    'descriptopn' => 'Reverse all colors of the image. ',
                  ),
                  'pixelate' => array(
                    'parameters' => array(
                      'size' => array(
                        'type' => 'int',
                        'min' => 1,
                        'required' => true,
                        'description' => 'The block size.',
                      ),
                    ),
                    'descriptopn' => 'Apply pixelation effect to the image.',
                  ),
                  'selectiveblur' => array(
                    'descriptopn' => 'Blur the image.',
                  ),
                  'smooth' => array(
                    'parameters' => array(
                      'level' => array(
                        'type' => 'float',
                        'required' => true,
                        'description' => 'Any float is accepted, no change for large values (2048 or more).',
                      ),
                    ),
                    'descriptopn' => 'Make the image smoother.',
                  ),
                ),
              ),
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
            'description' => 'Applies filter to the image.',
          ),
        ),
        'resize' => array(
          'POST' => array(
            'parameters' => array(
              'hsize' => array(
                'type' => 'int',
                'min' => 1,
                'required' => true,
                'description' => 'Horizontal size to scale image to.',
              ),
              'vsize' => array(
                'type' => 'int',
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
        ),
        'crop' => array(
          'POST' => array(
            'parameters' => array(
              'xpoint' => array(
                'type' => 'int',
                'min' => 0,
                'required' => true,
                'description' => 'Horizontal coordinate of the upper left vertex of new image (after cropping).',
              ),
              'ypoint' => array(
                'type' => 'int',
                'min' => 0,
                'required' => true,
                'description' => 'Vertical coordinate of the upper left vertex of new image (after cropping).',
              ),
              'hsize' => array(
                'type' => 'int',
                'min' => 1,
                'required' => true,
                'description' => 'Horizontal size of new image (after cropping).',
              ),
              'vsize' => array(
                'type' => 'int',
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
        ),
        'fitin' => array(
          'POST' => array(
            'parameters' => array(
              'hsize' => array(
                'type' => 'int',
                'min' => 1,
                'required' => true,
                'description' => 'Horizontal size of imaginary rectangle in which new image should fit in.',
              ),
              'vsize' => array(
                'type' => 'int',
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
        ),
        'flip' => array(
          'POST' => array(
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
        ),
        'rotate' => array(
          'POST' => array(
            'parameters' => array(
              'angle' => array(
                'type' => 'float',
                'required' => true,
                'description' => 'Positive values for anticlockwise.',
              ),
              'bgred' => array(
                'type' => 'int',
                'min' => 0,
                'max' => 255,
                'required' => true,
                'description' => 'Red component of background around rotated image.',
              ),
              'bggreen' => array(
                'type' => 'int',
                'min' => 0,
                'max' => 255,
                'required' => true,
                'description' => 'Green component of background around rotated image.',
              ),
              'bgblue' => array(
                'type' => 'int',
                'min' => 0,
                'max' => 255,
                'required' => true,
                'description' => 'Blue component of background around rotated image.',
              ),
              'bgalpha' => array(
                'type' => 'int',
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
        ),
      )
    )
  )
);