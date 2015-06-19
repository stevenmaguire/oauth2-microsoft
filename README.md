# Microsoft Provider for OAuth 2.0 Client
[![Latest Version](https://img.shields.io/github/release/stevenmaguire/oauth2-microsoft.svg?style=flat-square)](https://github.com/stevenmaguire/oauth2-microsoft/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/stevenmaguire/oauth2-microsoft/master.svg?style=flat-square)](https://travis-ci.org/stevenmaguire/oauth2-microsoft)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/stevenmaguire/oauth2-microsoft.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevenmaguire/oauth2-microsoft/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/stevenmaguire/oauth2-microsoft.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevenmaguire/oauth2-microsoft)
[![Total Downloads](https://img.shields.io/packagist/dt/stevenmaguire/oauth2-microsoft.svg?style=flat-square)](https://packagist.org/packages/stevenmaguire/oauth2-microsoft)

This package provides Microsoft OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

> The latest release of this package is specifically designed to support Microsoft OAuth 2.0 support when using the OAuth 2.0 Client ~1.0.
> If you area currently using OAuth 2.0 Client < 1.0, that package includes a built-in Microsoft Provider.

## Installation

To install, use composer:

```
composer require stevenmaguire/oauth2-microsoft
```

## Usage

Usage is the same as The League's OAuth client, using `\Stevenmaguire\OAuth2\Client\Provider\Microsoft` as the provider.

### Authorization Code Flow

```php
$provider = new Stevenmaguire\OAuth2\Client\Provider\Microsoft([
    'clientId'          => '{microsoft-client-id}',
    'clientSecret'      => '{microsoft-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url'
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getFirstname());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

#### Managing Scopes and State

Specific `scope` and a custom `state` values may be declared when you request an authorization url from the provider.

```php
$authorizationUrl = $provider->getAuthorizationUrl([
    'state' => 'OPTIONAL CUSTOM CONFIGURED STATE',
    'scope' => ['OPTIONAL', 'SCOPES'] // array or string
]);
```
If neither are defined, the provider will utilize internal defaults.


