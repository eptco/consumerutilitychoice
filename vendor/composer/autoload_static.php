<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f740d32c9c90eae889c4089fbec392a
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'bccfaf6207f67190a92f35585e9a78b2' => __DIR__ . '/..' . '/twilio/sdk/Services/Twilio.php',
    );

    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'XeroPHP\\' => 8,
        ),
        'U' => 
        array (
            'UAParser\\' => 9,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Yaml\\' => 23,
            'Symfony\\Component\\Finder\\' => 25,
            'Symfony\\Component\\Filesystem\\' => 29,
            'Symfony\\Component\\EventDispatcher\\' => 34,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'Q' => 
        array (
            'Quill\\' => 6,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'F' => 
        array (
            'Firebase\\Token\\' => 15,
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'XeroPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/calcinai/xero-php/src/XeroPHP',
        ),
        'UAParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/ua-parser/uap-php/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Yaml\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/yaml',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Symfony\\Component\\Filesystem\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/filesystem',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Quill\\' => 
        array (
            0 => __DIR__ . '/../..' . '/api/lib/quill',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Firebase\\Token\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/token-generator/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Slim' => 
            array (
                0 => __DIR__ . '/..' . '/slim/slim',
            ),
        ),
        'M' => 
        array (
            'Mailgun\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/mailgun/mailgun-php/tests',
            ),
            'Mailgun' => 
            array (
                0 => __DIR__ . '/..' . '/mailgun/mailgun-php/src',
            ),
        ),
        'G' => 
        array (
            'Guzzle\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/tests',
            ),
            'Guzzle' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/src',
            ),
        ),
    );

    public static $classMap = array (
        'EasyPeasyICS' => __DIR__ . '/..' . '/phpmailer/phpmailer/extras/EasyPeasyICS.php',
        'PHPMailer' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmailer.php',
        'PHPMailerOAuth' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmaileroauth.php',
        'PHPMailerOAuthGoogle' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmaileroauthgoogle.php',
        'POP3' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.pop3.php',
        'SMTP' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.smtp.php',
        'Stripe' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Stripe.php',
        'Stripe_Account' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Account.php',
        'Stripe_ApiConnectionError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApiConnectionError.php',
        'Stripe_ApiError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApiError.php',
        'Stripe_ApiRequestor' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApiRequestor.php',
        'Stripe_ApiResource' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApiResource.php',
        'Stripe_ApplicationFee' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApplicationFee.php',
        'Stripe_ApplicationFeeRefund' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/ApplicationFeeRefund.php',
        'Stripe_AttachedObject' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/AttachedObject.php',
        'Stripe_AuthenticationError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/AuthenticationError.php',
        'Stripe_Balance' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Balance.php',
        'Stripe_BalanceTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/BalanceTransaction.php',
        'Stripe_BitcoinReceiver' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/BitcoinReceiver.php',
        'Stripe_BitcoinTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/BitcoinTransaction.php',
        'Stripe_Card' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Card.php',
        'Stripe_CardError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/CardError.php',
        'Stripe_Charge' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Charge.php',
        'Stripe_Coupon' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Coupon.php',
        'Stripe_Customer' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Customer.php',
        'Stripe_Error' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Error.php',
        'Stripe_Event' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Event.php',
        'Stripe_FileUpload' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/FileUpload.php',
        'Stripe_InvalidRequestError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/InvalidRequestError.php',
        'Stripe_Invoice' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Invoice.php',
        'Stripe_InvoiceItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/InvoiceItem.php',
        'Stripe_List' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/List.php',
        'Stripe_Object' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Object.php',
        'Stripe_Plan' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Plan.php',
        'Stripe_RateLimitError' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/RateLimitError.php',
        'Stripe_Recipient' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Recipient.php',
        'Stripe_Refund' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Refund.php',
        'Stripe_RequestOptions' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/RequestOptions.php',
        'Stripe_SingletonApiResource' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/SingletonApiResource.php',
        'Stripe_Subscription' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Subscription.php',
        'Stripe_Token' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Token.php',
        'Stripe_Transfer' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Transfer.php',
        'Stripe_Util' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Util.php',
        'Stripe_Util_Set' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe/Util/Set.php',
        'ntlm_sasl_client_class' => __DIR__ . '/..' . '/phpmailer/phpmailer/extras/ntlm_sasl_client.php',
        'phpmailerException' => __DIR__ . '/..' . '/phpmailer/phpmailer/class.phpmailer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f740d32c9c90eae889c4089fbec392a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f740d32c9c90eae889c4089fbec392a::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit5f740d32c9c90eae889c4089fbec392a::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit5f740d32c9c90eae889c4089fbec392a::$classMap;

        }, null, ClassLoader::class);
    }
}
