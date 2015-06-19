<?php namespace Stevenmaguire\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\UserInterface;

class User implements UserInterface
{
    /**
     * User email
     *
     * @var string
     */
    protected $email;

    /**
     * User firstname
     *
     * @var string
     */
    protected $firstname;

    /**
     * User imageurl
     *
     * @var string
     */
    protected $imageurl;

    /**
     * User lastname
     *
     * @var string
     */
    protected $lastname;

    /**
     * User name
     *
     * @var string
     */
    protected $name;

    /**
     * User userId
     *
     * @var string
     */
    protected $userId;

    /**
     * User urls
     *
     * @var string
     */
    protected $urls;

    /**
     * Create new user
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        array_walk($attributes, [$this, 'mergeAttribute']);
    }

    /**
     * Attempt to merge individual attributes with user properties
     *
     * @param  mixed   $value
     * @param  string  $key
     *
     * @return void
     */
    private function mergeAttribute($value, $key)
    {
        $method = 'set'.ucfirst($key);

        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    /**
     * Get user email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set user email
     *
     * @param  string $email
     *
     * @return this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get user firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set user firstname
     *
     * @param  string $firstname
     *
     * @return this
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
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
     * @param  string $imageurl
     *
     * @return this
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
        return $this->lastname;
    }

    /**
     * Set user lastname
     *
     * @param  string $lastname
     *
     * @return this
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set user name
     *
     * @param  string $name
     *
     * @return this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get user userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set user userId
     *
     * @param  string $userId
     *
     * @return this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get user urls
     *
     * @return string
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set user urls
     *
     * @param  string $urls
     *
     * @return this
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;

        return $this;
    }
}
