<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\GenericResourceOwner;

/**
 * @property array $response
 * @property string $uid
 */
class MicrosoftResourceOwner extends GenericResourceOwner
{
    /**
     * Image url
     *
     * @var string
     */
    protected $imageurl;

    /**
     * Get user id
     *
     * @return string
     */
    public function getId()
    {
        return $this->resourceOwnerId;
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->response['emails']['preferred'] ?: null;
    }

    /**
     * Get user firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->response['first_name'] ?: null;
    }

    /**
     * Get user imageurl
     *
     * @return string
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }

    /**
     * Set user imageurl
     *
     * @return string
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    /**
     * Get user lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->response['last_name'] ?: null;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->response['name'] ?: null;
    }

    /**
     * Get user urls
     *
     * @return string
     */
    public function getUrls()
    {
        return isset($this->response['link']) ? $this->response['link'].'/cid-'.$this->resourceOwnerId : null;
    }
}
