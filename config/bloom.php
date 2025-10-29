<?php

return [
    // Array of email addresses to receive lead notifications
    'notification_emails' => env('BLOOM_NOTIFICATION_EMAILS')
        ? explode(',', env('BLOOM_NOTIFICATION_EMAILS'))
        : [
            // 'info@bloomdigitmedia.com',
            // 'agharayetseyi@bloomdigitmedia.com',
            'davidaremu@bloomdigitmedia.com',
        ],
];
