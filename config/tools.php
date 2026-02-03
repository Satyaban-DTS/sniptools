<?php
// web/config/tools.php

$tools = [
    'json-formatter' => [
        'id' => 1,
        'name' => 'JSON Formatter',
        'desc' => 'Validate, beautify, and minify your JSON data.',
        'icon' => 'fa-code',
        'category' => 'developer',
        'keywords' => 'json validator, json beautifier, json minify, json lint, online json formatter',
        'tip' => 'Formatting JSON helps in debugging complex APIs and data structures.'
    ],
    'word-counter' => [
        'id' => 2,
        'name' => 'Word Counter',
        'desc' => 'Counting words, characters, and reading time in real-time.',
        'icon' => 'fa-file-lines',
        'category' => 'text',
        'keywords' => 'word count, character count, reading time, text analyzer, word frequency',
        'tip' => 'Our counter excludes punctuation by default for more accurate word counts.'
    ],
    'case-converter' => [
        'id' => 3,
        'name' => 'Case Converter',
        'desc' => 'Convert text to UPPERCASE, lowercase, CamelCase, etc.',
        'icon' => 'fa-font',
        'category' => 'text',
        'keywords' => 'text case converter, uppercase, lowercase, camelcase, pascalcase, snakecase',
        'tip' => 'Use CamelCase or PascalCase for programming variable names.'
    ],
    'base64' => [
        'id' => 4,
        'name' => 'Base64 Encoder / Decoder',
        'desc' => 'Securely encode or decode text to Base64 format.',
        'icon' => 'fa-shield-halved',
        'category' => 'converters',
        'keywords' => 'base64 encode, base64 decode, base64 string converter, base64 utility',
        'tip' => 'Base64 is commonly used to transfer binary data over text-based protocols.'
    ],
    'lorem-ipsum' => [
        'id' => 5,
        'name' => 'Lorem Ipsum Generator',
        'desc' => 'Generate placeholder text for layouts and designs.',
        'icon' => 'fa-paragraph',
        'category' => 'text',
        'keywords' => 'lorem ipsum, dummy text, placeholder text, lipsum generator, text generator',
        'tip' => 'Placeholder text helps designers visualize the final layout before the actual copy is ready.'
    ],
    'qr-code' => [
        'id' => 6,
        'name' => 'QR Code Generator',
        'desc' => 'Generate high-quality QR codes for URLs and text.',
        'icon' => 'fa-qrcode',
        'category' => 'developer',
        'keywords' => 'qr code maker, qr generator, create qr code, free qr code, url to qr',
        'tip' => 'Keep your URLs short or use a URL shortener for better QR code scanability.'
    ],
    'uuid-generator' => [
        'id' => 7,
        'name' => 'UUID Generator',
        'desc' => 'Generate secure random UUIDs (v4).',
        'icon' => 'fa-fingerprint',
        'category' => 'developer',
        'keywords' => 'uuid generator, guid generator, random uuid, v4 uuid, unique identifier',
        'tip' => 'UUID v4 is completely random and extremely unlikely to have collisions.'
    ],
    'hash-generator' => [
        'id' => 8,
        'name' => 'Hash Generator',
        'desc' => 'Calculate MD5, SHA-1, SHA-256 hashes of text.',
        'icon' => 'fa-hashtag',
        'category' => 'developer',
        'keywords' => 'md5 hash, sha1 generator, sha256, hash calculator, text hasher, checksum',
        'tip' => 'Hashing is a one-way process. You cannot retrieve the original text from a hash.'
    ],
    'gradient-generator' => [
        'id' => 9,
        'name' => 'Gradient Generator',
        'desc' => 'Create beautiful linear and radial CSS gradients.',
        'icon' => 'fa-palette',
        'category' => 'tailwind',
        'keywords' => 'css gradient, background gradient, linear gradient, radial gradient, css generator',
        'tip' => 'Gradients can add depth and modern feel to your UI designs.'
    ],
    'box-shadow' => [
        'id' => 10,
        'name' => 'Box Shadow Generator',
        'desc' => 'Visualise and generate CSS box-shadow code.',
        'icon' => 'fa-layer-group',
        'category' => 'tailwind',
        'keywords' => 'css box shadow, shadow generator, css shadow, box-shadow generator, elevation',
        'tip' => 'Subtle shadows look more professional than heavy, dark ones.'
    ],
    'tailwind-components' => [
        'id' => 11,
        'name' => 'Tailwind Components',
        'desc' => 'Ready-to-use premium Tailwind CSS components.',
        'icon' => 'fa-wind',
        'category' => 'tailwind',
        'keywords' => 'tailwind css blocks, tailwind ui, free tailwind components, ui kit',
        'tip' => 'Copy-paste these components to speed up your web development flow.'
    ],
    'css-to-tailwind' => [
        'id' => 12,
        'name' => 'CSS to Tailwind',
        'desc' => 'Magic converter from standard CSS to Tailwind utility classes.',
        'icon' => 'fa-wand-magic-sparkles',
        'category' => 'tailwind',
        'keywords' => 'css converter, css to tailwind class, convert css to utilities, tailwind converter',
        'tip' => 'Not all CSS can be mapped to Tailwind, but we cover the most common layout and style properties.'
    ],
    'url-encoder' => [
        'id' => 13,
        'name' => 'URL Encoder / Decoder',
        'desc' => 'Safely encode or decode URLs and parameters.',
        'icon' => 'fa-link',
        'category' => 'developer',
        'keywords' => 'url encode, url decode, uri component, percent encoding, url params',
        'tip' => 'Encoding ensures that special characters in URLs don\'t break web requests.'
    ],
    'password-generator' => [
        'id' => 14,
        'name' => 'Password Generator',
        'desc' => 'Generate secure, random passwords instantly.',
        'icon' => 'fa-key',
        'category' => 'developer',
        'keywords' => 'secure password, random password, password creator, strong password, password generator',
        'tip' => 'Use a mix of uppercase, numbers, and symbols for maximum security.'
    ],
    'sql-formatter' => [
        'id' => 15,
        'name' => 'SQL Formatter',
        'desc' => 'Beautify and format complex SQL queries.',
        'icon' => 'fa-database',
        'category' => 'developer',
        'keywords' => 'sql beautifier, sql prettifier, format sql, sql query formatter, sql lint',
        'tip' => 'Well-formatted SQL is much easier to debug and maintain.'
    ],
    'yaml-json-converter' => [
        'id' => 16,
        'name' => 'YAML / JSON Converter',
        'desc' => 'Seamlessly convert between YAML and JSON formats.',
        'icon' => 'fa-repeat',
        'category' => 'converters',
        'keywords' => 'yaml to json, json to yaml, yaml converter, json converter, data format',
        'tip' => 'YAML is great for configuration, while JSON is standard for APIs.'
    ],
    'tailwind-grid-generator' => [
        'id' => 17,
        'name' => 'Tailwind Grid Generator',
        'desc' => 'Visually build CSS grids and export Tailwind code.',
        'icon' => 'fa-border-all',
        'category' => 'tailwind',
        'keywords' => 'tailwind grid layout, css grid builder, tailwind grid maker, grid generator',
        'tip' => 'Use col-span and row-span to create complex layouts effortlessly.'
    ],
    'tailwind-flexbox-playground' => [
        'id' => 18,
        'name' => 'Flexbox Playground',
        'desc' => 'Master Flexbox with this interactive visual sandbox.',
        'icon' => 'fa-layer-group',
        'category' => 'tailwind',
        'keywords' => 'css flexbox, tailwind flex, flexbox generator, layout builder, flexbox playground',
        'tip' => 'Flexbox is best for 1D layouts. Use Grid for 2D layouts.'
    ],
    'image-to-base64' => [
        'id' => 19,
        'name' => 'Image to Base64',
        'desc' => 'Convert images to Base64 strings for embedding.',
        'icon' => 'fa-image',
        'category' => 'image',
        'keywords' => 'image to base64, convert image string, image data uri, base64 image',
        'tip' => 'Base64 images increase file size by ~33% but save HTTP requests.'
    ],
    'image-compressor' => [
        'id' => 20,
        'name' => 'Image Compressor',
        'desc' => 'Compress PNG/JPG images locally in your browser.',
        'icon' => 'fa-compress-arrows-alt',
        'category' => 'image',
        'keywords' => 'compress jpg, optimize png, reduce image size, image optimizer, tiny png',
        'tip' => 'WebP format usually offers superior compression over JPEG and PNG.'
    ],
    'image-cropper' => [
        'id' => 21,
        'name' => 'Image Cropper',
        'desc' => 'Crop and resize images to exact dimensions.',
        'icon' => 'fa-crop-simple',
        'category' => 'image',
        'keywords' => 'crop image, resize image, photo editor, online crop, image trimmer',
        'tip' => 'Cropping before compressing can save even more file size.'
    ],
    'flip-image' => [
        'id' => 22,
        'name' => 'Flip Image',
        'desc' => 'Flip images horizontally or vertically.',
        'icon' => 'fa-arrows-left-right',
        'category' => 'image',
        'keywords' => 'mirror image, flip photo, horizontal flip, vertical flip, reflect image',
        'tip' => 'Mirroring images can create interesting symmetrical effects.'
    ],
    'image-inverter' => [
        'id' => 23,
        'name' => 'Image Inverter',
        'desc' => 'Invert the colors of any image instantly.',
        'icon' => 'fa-circle-half-stroke',
        'category' => 'image',
        'keywords' => 'invert colors, photo negative, reverse colors, image effects',
        'tip' => 'Inverting a black and white image creates a negative effect.'
    ],
    'add-borders' => [
        'id' => 24,
        'name' => 'Add Borders',
        'desc' => 'Add custom colored borders to your images.',
        'icon' => 'fa-border-all',
        'category' => 'image',
        'keywords' => 'image border, add photo frame, picture border, css border',
        'tip' => 'Adding a white border can make your screenshots pop on dark backgrounds.'
    ],
    'image-to-ascii' => [
        'id' => 25,
        'name' => 'Image to ASCII',
        'desc' => 'Convert images into ASCII art text.',
        'icon' => 'fa-font',
        'category' => 'image',
        'keywords' => 'image to text, ascii art generator, picture to ascii, retro art',
        'tip' => 'Works best with high-contrast images and simple shapes.'
    ],
    'image-pixelator' => [
        'id' => 26,
        'name' => 'Image Pixelator',
        'desc' => 'Pixelate images for a retro effect or censorship.',
        'icon' => 'fa-chess-board',
        'category' => 'image',
        'keywords' => 'pixelate image, censor image, 8bit image, retro effect, blur image',
        'tip' => 'Increase pixel size to hide sensitive information in screenshots.'
    ],
    'image-watermark' => [
        'id' => 27,
        'name' => 'Image Watermark',
        'desc' => 'Add text or image watermarks to protect your work.',
        'icon' => 'fa-copyright',
        'category' => 'image',
        'keywords' => 'add watermark, copyright image, protect photo, logo watermark',
        'tip' => 'Adjust transparency to make the watermark subtle but visible.'
    ],
    'split-image' => [
        'id' => 28,
        'name' => 'Split Image',
        'desc' => 'Slice an image into grids or rows/columns.',
        'icon' => 'fa-table-cells-large',
        'category' => 'image',
        'keywords' => 'image slicer, instagram grid, split photo, tile image, image splitter',
        'tip' => 'Great for creating Instagram grid layouts.'
    ],
    'merge-image' => [
        'id' => 29,
        'name' => 'Merge Images',
        'desc' => 'Combine multiple images into one instantly.',
        'icon' => 'fa-object-group',
        'category' => 'image',
        'keywords' => 'combine images, join photos, stitch images, image merger, layout photos',
        'tip' => 'Merge screenshots vertically to create a long scrolling image.'
    ],
    'jwt-decoder' => [
        'id' => 30,
        'name' => 'JWT Decoder',
        'desc' => 'Decode JSON Web Tokens to view header and payload.',
        'icon' => 'fa-shield-alt',
        'category' => 'developer',
        'keywords' => 'jwt viewer, decode jwt, json web token, jwt debugger, jwt inspector',
        'tip' => 'Paste a JWT verify its contents. We decode it strictly client-side.'
    ]
];
