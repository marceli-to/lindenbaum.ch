<?php

return [

    'image_manipulation' => [

        /*
        |--------------------------------------------------------------------------
        | Route Prefix
        |--------------------------------------------------------------------------
        |
        | The route prefix for serving HTTP based manipulated images through Glide.
        | If using the cached option, this should be the URL of the cached path.
        |
        */

        'route' => 'img',

        /*
        |--------------------------------------------------------------------------
        | Require Glide security token
        |--------------------------------------------------------------------------
        |
        | With this option enabled, you are protecting your website from mass image
        | resize attacks. You will need to generate tokens using the Glide tag
        | but may want to disable this while in development to tinker.
        |
        */

        'secure' => true,

        /*
        |--------------------------------------------------------------------------
        | Image Manipulation Driver
        |--------------------------------------------------------------------------
        |
        | The driver that will be used under the hood for image manipulation.
        | Supported: "gd" or "imagick" (if installed on your server)
        |
        */

        'driver' => 'gd',

        /*
        |--------------------------------------------------------------------------
        | Additional Image Extensions
        |--------------------------------------------------------------------------
        |
        | Define any additional image file extensions you would like Statamic to
        | process. You should ensure that both your server and the selected
        | image manipulation driver properly supports these extensions.
        |
        */

        'additional_extensions' => [
            // 'heic',
        ],

        /*
        |--------------------------------------------------------------------------
        | Save Cached Images
        |--------------------------------------------------------------------------
        |
        | Enabling this will make Glide save publicly accessible images. It will
        | increase performance at the cost of the dynamic nature of HTTP based
        | image manipulation. You will need to invalidate images manually.
        |
        */

        'cache' => false,
        'cache_path' => public_path('img'),

        /*
        |--------------------------------------------------------------------------
        | Image Manipulation Defaults
        |--------------------------------------------------------------------------
        |
        | You may define global defaults for all manipulation parameters, such as
        | quality, format, and sharpness. These can and will be be overwritten
        | on the tag parameter level as well as the preset level.
        |
        */

        'defaults' => [
            // 'quality' => 50,
        ],

        /*
        |--------------------------------------------------------------------------
        | Image Manipulation Presets
        |--------------------------------------------------------------------------
        |
        | Rather than specifying your manipulation params in your templates with
        | the glide tag, you may define them here and reference their handles.
        | They may also be automatically generated when you upload assets.
        | Containers can be configured to warm these caches on upload.
        |
        */

        'presets' => [

          // Standard images
          'md-webp' => ['w' => 768, 'h' => 10000, 'q' => 90, 'fit' => 'contain', 'fm' => 'webp'],
          'lg-webp' => ['w' => 1280, 'h' => 10000, 'q' => 90, 'fit' => 'contain', 'fm' => 'webp'],
          'xl-webp' => ['w' => 1440, 'h' => 10000, 'q' => 90, 'fit' => 'contain', 'fm' => 'webp'],
          '2xl-webp' => ['w' => 1680, 'h' => 10000, 'q' => 90, 'fit' => 'contain', 'fm' => 'webp'],
          'md' => ['w' => 768, 'h' => 10000, 'q' => 90, 'fit' => 'contain'],
          'lg' => ['w' => 1280, 'h' => 10000, 'q' => 90, 'fit' => 'contain'],
          'xl' => ['w' => 1440, 'h' => 10000, 'q' => 90, 'fit' => 'contain'],
          '2xl' => ['w' => 1680, 'h' => 10000, 'q' => 90, 'fit' => 'contain'],

          // Focal point images (4:3)
          'md-focal-4-3-webp' => ['w' => 768, 'h' => 576, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'lg-focal-4-3-webp' => ['w' => 1280, 'h' => 960, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'xl-focal-4-3-webp' => ['w' => 1440, 'h' => 1080, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          '2xl-focal-4-3-webp' => ['w' => 1680, 'h' => 1260, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'md-focal-4-3' => ['w' => 768, 'h' => 576, 'q' => 90, 'fit' => 'crop_focal'],
          'lg-focal-4-3' => ['w' => 1280, 'h' => 960, 'q' => 90, 'fit' => 'crop_focal'],
          'xl-focal-4-3' => ['w' => 1440, 'h' => 1080, 'q' => 90, 'fit' => 'crop_focal'],
          '2xl-focal-4-3' => ['w' => 1680, 'h' => 1260, 'q' => 90, 'fit' => 'crop_focal'],

          // Focal point images (16:9)
          'md-focal-16-9-webp' => ['w' => 768, 'h' => 432, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'lg-focal-16-9-webp' => ['w' => 1280, 'h' => 720, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'xl-focal-16-9-webp' => ['w' => 1440, 'h' => 810, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          '2xl-focal-16-9-webp' => ['w' => 1680, 'h' => 945, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'md-focal-16-9' => ['w' => 768, 'h' => 432, 'q' => 90, 'fit' => 'crop_focal'],
          'lg-focal-16-9' => ['w' => 1280, 'h' => 720, 'q' => 90, 'fit' => 'crop_focal'],
          'xl-focal-16-9' => ['w' => 1440, 'h' => 810, 'q' => 90, 'fit' => 'crop_focal'],
          '2xl-focal-16-9' => ['w' => 1680, 'h' => 945, 'q' => 90, 'fit' => 'crop_focal'],

          // Focal point image (16:10)
          'md-focal-16-10-webp' => ['w' => 768, 'h' => 480, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'lg-focal-16-10-webp' => ['w' => 1280, 'h' => 800, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'xl-focal-16-10-webp' => ['w' => 1440, 'h' => 900, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          '2xl-focal-16-10-webp' => ['w' => 1680, 'h' => 1050, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'md-focal-16-10' => ['w' => 768, 'h' => 480, 'q' => 90, 'fit' => 'crop_focal'],
          'lg-focal-16-10' => ['w' => 1280, 'h' => 800, 'q' => 90, 'fit' => 'crop_focal'],
          'xl-focal-16-10' => ['w' => 1440, 'h' => 900, 'q' => 90, 'fit' => 'crop_focal'],
          '2xl-focal-16-10' => ['w' => 1680, 'h' => 1050, 'q' => 90, 'fit' => 'crop_focal'],

          // Focal point image (4:5)
          'md-focal-4-5-webp' => ['w' => 768, 'h' => 960, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'lg-focal-4-5-webp' => ['w' => 1280, 'h' => 1600, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'xl-focal-4-5-webp' => ['w' => 1440, 'h' => 1800, 'q' => 90, 'fit' => 'crop_focal', 'fm' => 'webp'],
          'md-focal-4-5' => ['w' => 768, 'h' => 960, 'q' => 90, 'fit' => 'crop_focal'],
          'lg-focal-4-5' => ['w' => 1280, 'h' => 1600, 'q' => 90, 'fit' => 'crop_focal'],
          'xl-focal-4-5' => ['w' => 1440, 'h' => 1800, 'q' => 90, 'fit' => 'crop_focal'],
          
          'max_upload_size' => ['w' => 4000, 'h' => 4000, 'fit' => 'max'],

        ],

        /*
        |--------------------------------------------------------------------------
        | Generate Image Manipulation Presets on Upload
        |--------------------------------------------------------------------------
        |
        | By default, presets will be automatically generated on upload, ensuring
        | the cached images are available when they are first used. You may opt
        | out of this behavior here and have the presets generated on demand.
        |
        */

        'generate_presets_on_upload' => false,

    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Crop Assets
    |--------------------------------------------------------------------------
    |
    | Enabling this will make Glide automatically crop assets at their focal
    | point (which is the center if no focal point is defined). Otherwise,
    | you will need to manually add any crop related parameters.
    |
    */

    'auto_crop' => true,

    /*
    |--------------------------------------------------------------------------
    | Control Panel Thumbnail Restrictions
    |--------------------------------------------------------------------------
    |
    | Thumbnails will not be generated for any assets any larger (in either
    | axis) than the values listed below. This helps prevent memory usage
    | issues out of the box. You may increase or decrease as necessary.
    |
    */

    'thumbnails' => [
        'max_width' => 10000,
        'max_height' => 10000,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Previews with Google Docs
    |--------------------------------------------------------------------------
    |
    | Filetypes that cannot be rendered with HTML5 can opt into the Google Docs
    | Viewer. Google will get temporary access to these files so keep that in
    | mind for any privacy implications: https://policies.google.com/privacy
    |
    */

    'google_docs_viewer' => false,

    /*
    |--------------------------------------------------------------------------
    | Cache Metadata
    |--------------------------------------------------------------------------
    |
    | Asset metadata (filesize, dimensions, custom data, etc) will get cached
    | to optimize performance, so that it will not need to be constantly
    | re-evaluated from disk. You may disable this option if you are
    | planning to continually modify the same asset repeatedly.
    |
    */

    'cache_meta' => true,

    /*
    |--------------------------------------------------------------------------
    | Focal Point Editor
    |--------------------------------------------------------------------------
    |
    | When editing images in the Control Panel, there is an option to choose
    | a focal point. When working with third-party image providers such as
    | Cloudinary it can be useful to disable Statamic's built-in editor.
    |
    */

    'focal_point_editor' => true,

    /*
    |--------------------------------------------------------------------------
    | Enforce Lowercase Filenames
    |--------------------------------------------------------------------------
    |
    | Control whether asset filenames will be converted to lowercase when
    | uploading and renaming. This can help you avoid file conflicts
    | when working in case-insensitive filesystem environments.
    |
    */

    'lowercase' => true,

];
