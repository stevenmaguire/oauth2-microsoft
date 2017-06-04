<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;

class Microsoft extends AbstractProvider
{
    /**
     * Default scopes
     *
     * @var array
     */
    public $defaultScopes = ['wl.basic', 'wl.emails'];

    /**
     * Base url for authorization.
     *
     * @var string
     */
    protected $urlAuthorize = 'https://login.live.com/oauth20_authorize.srf';

    /**
     * Base url for access token.
     *
     * @var string
     */
    protected $urlAccessToken = 'https://login.live.com/oauth20_token.srf';

    /**
     * Base url for resource owner.
     *
     * @var string
     */
    protected $urlResourceOwnerDetails = 'https://apis.live.net/v5.0/me';

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->urlAuthorize;
    }

    /**
     * Get access token url to retrieve token
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->urlAccessToken;
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
     * @param  ResponseInterface $response
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'])) {
            throw new IdentityProviderException(
                (isset($data['error']['message']) ? $data['error']['message'] : $response->getReasonPhrase()),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return MicrosoftResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new MicrosoftResourceOwner($response);

        $imageUrl = $this->getUserImageUrl($response, $token);

        return $user->setImageurl($imageUrl);
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $uri = new Uri($this->urlResourceOwnerDetails);

        return (string) Uri::withQueryValue($uri, 'access_token', (string) $token);
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

        return json_decode((string) $response->getBody(), true);
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
