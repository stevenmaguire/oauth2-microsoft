<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class MicrosoftResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new resource owner.
     *
     * @param array  $response
     */
    public function __construct(array $response = array())
    {
        $this->response = $response;
    }

    /**
     * Get user id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->response['id'] ?: null;
    }

    /**
     * Get user email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->response['mail'] ?: null;
    }

    /**
     * Get user principal name
     *
     * @return string|null
     */
    public function getPrincipalName()
    {
        return $this->response['userPrincipalName'] ?: null;
    }

    /**
     * @deprecated will be removed in 3.0. Use getGivenName() instead.
     *
     * Get user first name
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->getGivenName();
    }

    /**
     * Get user given name (first name)
     *
     * @return string|null
     */
    public function getGivenName()
    {
        return $this->response['givenName'] ?: null;
    }

    /**
     * @deprecated will be removed in 3.0. Use getSurname() instead.
     *
     * Get user lastname
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->getSurname();
    }

    /**
     * Get user surname
     *
     * @return string|null
     */
    public function getSurname()
    {
        return $this->response['surname'] ?: null;
    }

    /**
     * @deprecated will be removed in 3.0. Use getDisplayName() instead.
     *
     * Get user name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getDisplayName();
    }

    /**
     * Get user name
     *
     * @return string|null
     */
    public function getDisplayName()
    {
        return $this->response['displayName'] ?: null;
    }

    /**
     * @deprecated will be removed in 3.0.
     *
     * Get user urls
     *
     * @return string|null
     */
    public function getUrls()
    {
        return null;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response + [
            'first_name' => $this->response['givenName'],
            'last_name' => $this->response['surname'],
            'name' => $this->response['displayName'],
            'link' => null
        ];
    }
}
