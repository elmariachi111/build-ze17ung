<?php

namespace AppBundle\Entity\Security;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_users")
 */
//repositoryClass="AppBundle\Repository\UserRepository"
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="real_name", type="string", nullable=true)
     */
    protected $realName;

    /**
     * @var string
     * @ORM\Column(name="github_id", type="string", nullable=true)
     */
    protected $githubId;

    /**
     * @var string
     * @ORM\Column(name="github_access_token", type="string", nullable=true)
     */
    protected $githubAccessToken;

    /**
     * @var string
     * @ORM\Column(name="profile_picture", type="string", nullable=true)
     */
    protected $profilePicture;

    /**
     * @return string
     */
    public function getGithubId(): string
    {
        return $this->githubId;
    }

    /**
     * @param string $githubId
     */
    public function setGithubId(string $githubId)
    {
        $this->githubId = $githubId;
        return $this;
    }

    /**
     * @return string
     */
    public function getGithubAccessToken(): string
    {
        return $this->githubAccessToken;
    }

    /**
     * @param string $githubAccessToken
     */
    public function setGithubAccessToken(string $githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture(string $profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    }



}