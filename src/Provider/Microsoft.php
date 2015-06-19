<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class Microsoft extends AbstractProvider
{
    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = ['wl.basic', 'wl.emails'];

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://login.live.com/oauth20_authorize.srf';
    }

    /**
     * Get access token url to retrieve token
     *
     * @return string
     */
    public function getBaseAccessTokenUrl()
    {
        return 'https://login.live.com/oauth20_token.srf';
    }

    /**
     * Get default scopes
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  string $response
     * @return void
     */
    protected function checkResponse($response)
    {

    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param object $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\UserInterface
     */
    protected function prepareUserDetails(array $response, AccessToken $token)
    {
        $imageUrl = $this->getUserImageUrl($response, $token);

        $email = (isset($response['emails']['preferred'])) ? $response['emails']['preferred'] : null;

        $attributes = [
            'userId' => $response['id'],
            'name' => $response['name'],
            'firstname' => $response['first_name'],
            'lastname' => $response['last_name'],
            'email' => $email,
            'imageurl' => $imageUrl,
            'urls' => $response['link'].'/cid-'.$response['id'],
        ];

        return new User($attributes);
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getUserDetailsUrl(AccessToken $token)
    {
        return 'https://apis.live.net/v5.0/me?access_token='.$token;
    }

    /**
     * Get user image from provider
     *
     * @param  array        $response
     * @param  AccessToken  $token
     *
     * @return array
     */
    protected function getUserImage(array $response, AccessToken $token)
    {
        $url = 'https://apis.live.net/v5.0/'.$response['id'].'/picture';

        $request = $this->getAuthenticatedRequest('get', $url, $token);

        $response = $this->getResponse($request);

        $this->checkResponse($response);

        return $response;
    }

    /**
     * Get user image url from provider, if available
     *
     * @param  array        $response
     * @param  AccessToken  $token
     *
     * @return string
     */
    protected function getUserImageUrl(array $response, AccessToken $token)
    {
        $image = $this->getUserImage($response, $token);

        if (isset($image['url'])) {
            return $image['url'];
        }

        return null;
    }
}
