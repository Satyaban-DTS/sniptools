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
    ]
];
