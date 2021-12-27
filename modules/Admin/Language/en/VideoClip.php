<?php

declare(strict_types=1);

/**
 * @copyright  2021 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

return [
    'list' => [
        'title' => 'Video clips',
        'status' => [
            'label' => 'Status',
            'queued' => 'queued',
            'queued_hint' => 'Clip is waiting to be processed.',
            'pending' => 'pending',
            'pending_hint' => 'Clip will be generated shortly.',
            'running' => 'running',
            'running_hint' => 'Clip is being generated.',
            'failed' => 'failed',
            'failed_hint' => 'Clip could not be generated: script failure.',
            'passed' => 'passed',
            'passed_hint' => 'Clip was generated successfully!',
        ],
        'clip' => 'Clip',
        'duration' => 'Duration',
    ],
    'title' => 'Video clip: {videoClipLabel}',
    'download_clip' => 'Download clip',
    'create' => 'New video clip',
    'go_to_page' => 'Go to clip page',
    'delete' => 'Delete clip',
    'logs' => 'Job logs',
    'form' => [
        'title' => 'New video clip',
        'params_section_title' => 'Video clip parameters',
        'clip_title' => 'Clip title',
        'format' => [
            'label' => 'Choose a format',
            'landscape' => 'Landscape',
            'landscape_hint' => 'With a 16:9 ratio, landscape videos are great for PeerTube, Youtube and Vimeo.',
            'portrait' => 'Portrait',
            'portrait_hint' => 'With a 9:16 ratio, portrait videos are great for TikTok, Youtube shorts and Instagram stories.',
            'squared' => 'Squared',
            'squared_hint' => 'With a 1:1 ratio, squared videos are great for Mastodon, Facebook, Twitter and LinkedIn.',
        ],
        'theme' => 'Select a theme',
        'start_time' => 'Start at',
        'duration' => 'Duration',
        'submit' => 'Create video clip',
    ],
];
