<?php

$html = <<<HTML
<html>
<head>
	<link rel="stylesheet" href="/wp-content/rocket-test-data/styles/lazyload_css_background_images.css">
	<link rel="stylesheet" href="https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css">
</head>
<body></body>
</html>
HTML;

$html_filtered = <<<HTML
<html>
<head>
	<link rel="stylesheet" href="example.org/css">
	<link rel="stylesheet" href="example.org/css2">
</head>
<body></body>
</html>
HTML;


return [
    'noHtmlFieldShouldReturnSame' => [
        'config' => [
			'data' => [

				'css_files' => [
					'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css',
					'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css',
				]
			],
			'has' => [],
			'resolve' => [],
			'content' => [],
			'extract' => [],
			'rule_format' => [],
			'cache_set' => [],
			'cache_get' => [],
			'generate_url' => [],
			'json_set' => [],
		],
        'expected' => [
			'css_files' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css',
				'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css',
			]
		]
    ],
	'noCSSFieldShouldReturnSame' => [
		'config' => [
			'data' => [
				"html" => $html,
			],
			'has' => [],
			'resolve' => [],
			'extract' => [],
			'rule_format' => [],
			'content' => [],
			'cache_set' => [],
			'cache_get' => [],
			'generate_url' => [],
			'json_set' => [],
		],
		'expected' => [
			"html" => $html,
		]
	],
	'shouldReturnAsExpect' => [
		'config' => [
			'data' => [
				"html" => $html,
				'css_files' => [
					'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css',
					'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css',
				]
			],
			'has' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css' => false,
				'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css' => true,
			],
			'resolve' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css' => '/path/wp-content/rocket-test-data/styles/lazyload_css_background_images.css'
			],
			'extract' => [
				'content1' => [
					'selector' => [
						[
							'url' => 'url'
						]
					]
				]
			],
			'rule_format' => [
				[
					'tag' => [
						[
							'url' => 'url',
							'hash' => 'hash',
						]
					],
					'content' => 'content1',
					'new_content' => 'content',
					'formatted_urls' => [
						'formatted_urls1',
						'formatted_urls2',
						'formatted_urls3'
					],
				],
			],
			'content' => [
				'/path/wp-content/rocket-test-data/styles/lazyload_css_background_images.css' => 'content1'
			],
			'cache_set' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css' => [
					'content' => 'content',
					'output' => true
				]
			],
			'json_set' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css.json' => json_encode([
					'formatted_urls1',
					'formatted_urls2',
					'formatted_urls3'
				])
			],
			'cache_get' => [
				'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css.json' => json_encode([
					[
						'selector' => 'selector',
						'style' => 'placeholder'
					]
				]),
			],
			'generate_url' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css' => 'example.org/css',
				'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css' => 'example.org/css2',
			],
		],
		'expected' => [
			"html" => $html_filtered,
			'css_files' => [
				'/wp-content/rocket-test-data/styles/lazyload_css_background_images.css',
				'https://new.rocketlabsqa.ovh/wp-content/rocket-test-data/styles/lazyload_css_background_images.min.css',
			],
			'lazyloaded_images' => [
				'formatted_urls1',
				'formatted_urls2',
				'formatted_urls3',
				[
					'selector' => 'selector',
					'style' => 'placeholder'
				]
			]
		]
	],

];