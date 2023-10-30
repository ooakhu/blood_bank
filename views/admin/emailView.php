<?php

    require_once('/Applications/XAMPP/xamppfiles/htdocs/blood_bank/vendor/autoload.php');

    function run($message)
    {
        try {
            $mailchimp = new MailchimpTransactional\ApiClient();
            $mailchimp->setApiKey('md-SpVqs0sERIRo4gJU64R1nQ');
            $response = $mailchimp->messages->send(['message' => $message]);
            print_r($response);
        } catch (Error $e) {
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }

    $message = [
        'from_email' => 'noreply@routeware.space',
        'subject' => 'Hello world',
        'text' => 'Welcome to Mailchimp Transactional!',
        'to' => [
            [
                'email' => 'valerie@routeware.space',
                'type' => 'to'
            ]
        ]
    ];


    run($message);

