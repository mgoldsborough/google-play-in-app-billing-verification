android-market-license-verification
===================================
A simple PHP library for verifying responses from the Google Play In-App billing service. By verifying responses signed using public-key cryptography you can check whether a user has genuinely purchased your application.

You can use this library to validate market responses before allowing a user to download files from your server or access restricted content. It is PEAR compliant (PSR-0) and can easily be integrated with your server-side applications.

The only requirements for this library are PHP compiled with OpenSSL support, and a PHP version of 4.0.4 or higher. PHP5 works too. If you want to run the unit tests you will need PHPUnit 3.5 or later.

Original repo: http://code.google.com/p/android-market-license-verification/
