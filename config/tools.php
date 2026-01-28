<?php
// web/config/tools.php

$tools = [
    'json-formatter' => [
        'id' => 1,
        'name' => 'JSON Formatter',
        'desc' => 'Validate, beautify, and minify your JSON data.',
        'icon' => 'fa-code',
        'category' => 'developer',
        'tip' => 'Formatting JSON helps in debugging complex APIs and data structures.'
    ],
    'word-counter' => [
        'id' => 2,
        'name' => 'Word Counter',
        'desc' => 'Counting words, characters, and reading time in real-time.',
        'icon' => 'fa-file-lines',
        'category' => 'text',
        'tip' => 'Our counter excludes punctuation by default for more accurate word counts.'
    ],
    'case-converter' => [
        'id' => 3,
        'name' => 'Case Converter',
        'desc' => 'Convert text to UPPERCASE, lowercase, CamelCase, etc.',
        'icon' => 'fa-font',
        'category' => 'text',
        'tip' => 'Use CamelCase or PascalCase for programming variable names.'
    ],
    'base64' => [
        'id' => 4,
        'name' => 'Base64 Encoder / Decoder',
        'desc' => 'Securely encode or decode text to Base64 format.',
        'icon' => 'fa-shield-halved',
        'category' => 'converters',
        'tip' => 'Base64 is commonly used to transfer binary data over text-based protocols.'
    ],
    'lorem-ipsum' => [
        'id' => 5,
        'name' => 'Lorem Ipsum Generator',
        'desc' => 'Generate placeholder text for layouts and designs.',
        'icon' => 'fa-paragraph',
        'category' => 'text',
        'tip' => 'Placeholder text helps designers visualize the final layout before the actual copy is ready.'
    ],
    'qr-code' => [
        'id' => 6,
        'name' => 'QR Code Generator',
        'desc' => 'Generate high-quality QR codes for URLs and text.',
        'icon' => 'fa-qrcode',
        'category' => 'developer',
        'tip' => 'Keep your URLs short or use a URL shortener for better QR code scanability.'
    ],
    'uuid-generator' => [
        'id' => 7,
        'name' => 'UUID Generator',
        'desc' => 'Generate secure random UUIDs (v4).',
        'icon' => 'fa-fingerprint',
        'category' => 'developer',
        'tip' => 'UUID v4 is completely random and extremely unlikely to have collisions.'
    ],
    'hash-generator' => [
        'id' => 8,
        'name' => 'Hash Generator',
        'desc' => 'Calculate MD5, SHA-1, SHA-256 hashes of text.',
        'icon' => 'fa-hashtag',
        'category' => 'developer',
        'tip' => 'Hashing is a one-way process. You cannot retrieve the original text from a hash.'
    ],
    'gradient-generator' => [
        'id' => 9,
        'name' => 'Gradient Generator',
        'desc' => 'Create beautiful linear and radial CSS gradients.',
        'icon' => 'fa-palette',
        'category' => 'tailwind',
        'tip' => 'Gradients can add depth and modern feel to your UI designs.'
    ],
    'box-shadow' => [
        'id' => 10,
        'name' => 'Box Shadow Generator',
        'desc' => 'Visualise and generate CSS box-shadow code.',
        'icon' => 'fa-layer-group',
        'category' => 'tailwind',
        'tip' => 'Subtle shadows look more professional than heavy, dark ones.'
    ],
    'tailwind-components' => [
        'id' => 11,
        'name' => 'Tailwind Components',
        'desc' => 'Ready-to-use premium Tailwind CSS components.',
        'icon' => 'fa-wind',
        'category' => 'tailwind',
        'tip' => 'Copy-paste these components to speed up your web development flow.'
    ],
    'css-to-tailwind' => [
        'id' => 12,
        'name' => 'CSS to Tailwind',
        'desc' => 'Magic converter from standard CSS to Tailwind utility classes.',
        'icon' => 'fa-wand-magic-sparkles',
        'category' => 'tailwind',
        'tip' => 'Not all CSS can be mapped to Tailwind, but we cover the most common layout and style properties.'
    ],
    'url-encoder' => [
        'id' => 13,
        'name' => 'URL Encoder / Decoder',
        'desc' => 'Safely encode or decode URLs and parameters.',
        'icon' => 'fa-link',
        'category' => 'developer',
        'tip' => 'Encoding ensures that special characters in URLs don\'t break web requests.'
    ],
    'password-generator' => [
        'id' => 14,
        'name' => 'Password Generator',
        'desc' => 'Generate secure, random passwords instantly.',
        'icon' => 'fa-key',
        'category' => 'developer',
        'tip' => 'Use a mix of uppercase, numbers, and symbols for maximum security.'
    ],
    'sql-formatter' => [
        'id' => 15,
        'name' => 'SQL Formatter',
        'desc' => 'Beautify and format complex SQL queries.',
        'icon' => 'fa-database',
        'category' => 'developer',
        'tip' => 'Well-formatted SQL is much easier to debug and maintain.'
    ],
    'yaml-json-converter' => [
        'id' => 16,
        'name' => 'YAML / JSON Converter',
        'desc' => 'Seamlessly convert between YAML and JSON formats.',
        'icon' => 'fa-repeat',
        'category' => 'converters',
        'tip' => 'YAML is great for configuration, while JSON is standard for APIs.'
    ],
    'tailwind-grid-generator' => [
        'id' => 17,
        'name' => 'Tailwind Grid Generator',
        'desc' => 'Visually build CSS grids and export Tailwind code.',
        'icon' => 'fa-border-all',
        'category' => 'tailwind',
        'tip' => 'Use col-span and row-span to create complex layouts effortlessly.'
    ],
    'tailwind-flexbox-playground' => [
        'id' => 18,
        'name' => 'Flexbox Playground',
        'desc' => 'Master Flexbox with this interactive visual sandbox.',
        'icon' => 'fa-layer-group',
        'category' => 'tailwind',
        'tip' => 'Flexbox is best for 1D layouts. Use Grid for 2D layouts.'
    ],
    'image-to-base64' => [
        'id' => 19,
        'name' => 'Image to Base64',
        'desc' => 'Convert images to Base64 strings for embedding.',
        'icon' => 'fa-image',
        'category' => 'image',
        'tip' => 'Base64 images increase file size by ~33% but save HTTP requests.'
    ],
    'image-compressor' => [
        'id' => 20,
        'name' => 'Image Compressor',
        'desc' => 'Compress PNG/JPG images locally in your browser.',
        'icon' => 'fa-compress-arrows-alt',
        'category' => 'image',
        'tip' => 'WebP format usually offers superior compression over JPEG and PNG.'
    ],
    'image-cropper' => [
        'id' => 21,
        'name' => 'Image Cropper',
        'desc' => 'Crop and resize images to exact dimensions.',
        'icon' => 'fa-crop-simple',
        'category' => 'image',
        'tip' => 'Cropping before compressing can save even more file size.'
    ],
    'flip-image' => [
        'id' => 22,
        'name' => 'Flip Image',
        'desc' => 'Flip images horizontally or vertically.',
        'icon' => 'fa-arrows-left-right',
        'category' => 'image',
        'tip' => 'Mirroring images can create interesting symmetrical effects.'
    ],
    'image-inverter' => [
        'id' => 23,
        'name' => 'Image Inverter',
        'desc' => 'Invert the colors of any image instantly.',
        'icon' => 'fa-circle-half-stroke',
        'category' => 'image',
        'tip' => 'Inverting a black and white image creates a negative effect.'
    ],
    'add-borders' => [
        'id' => 24,
        'name' => 'Add Borders',
        'desc' => 'Add custom colored borders to your images.',
        'icon' => 'fa-border-all',
        'category' => 'image',
        'tip' => 'Adding a white border can make your screenshots pop on dark backgrounds.'
    ],
    'image-to-ascii' => [
        'id' => 25,
        'name' => 'Image to ASCII',
        'desc' => 'Convert images into ASCII art text.',
        'icon' => 'fa-font',
        'category' => 'image',
        'tip' => 'Works best with high-contrast images and simple shapes.'
    ],
    'image-pixelator' => [
        'id' => 26,
        'name' => 'Image Pixelator',
        'desc' => 'Pixelate images for a retro effect or censorship.',
        'icon' => 'fa-chess-board',
        'category' => 'image',
        'tip' => 'Increase pixel size to hide sensitive information in screenshots.'
    ],
    'image-watermark' => [
        'id' => 27,
        'name' => 'Image Watermark',
        'desc' => 'Add text or image watermarks to protect your work.',
        'icon' => 'fa-copyright',
        'category' => 'image',
        'tip' => 'Adjust transparency to make the watermark subtle but visible.'
    ],
    'split-image' => [
        'id' => 28,
        'name' => 'Split Image',
        'desc' => 'Slice an image into grids or rows/columns.',
        'icon' => 'fa-table-cells-large',
        'category' => 'image',
        'tip' => 'Great for creating Instagram grid layouts.'
    ],
    'merge-image' => [
        'id' => 29,
        'name' => 'Merge Images',
        'desc' => 'Combine multiple images into one instantly.',
        'icon' => 'fa-object-group',
        'category' => 'image',
        'tip' => 'Merge screenshots vertically to create a long scrolling image.'
    ],
    'jwt-decoder' => [
        'id' => 30,
        'name' => 'JWT Decoder',
        'desc' => 'Decode JSON Web Tokens to view header and payload.',
        'icon' => 'fa-shield-alt',
        'category' => 'developer',
        'tip' => 'Paste a JWT verify its contents. We decode it strictly client-side.'
    ]
];
