<?php


namespace AppBundle\Entity\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);
        $serviceName = $response->getResourceOwner()->getName();

        if (null === $user) { // if null just create new user and set its properties
            $user = new User();

            $user->setUsername($response->getUsername());
            $user->setRealName($response->getRealName());
            $user->setEmail($userEmail);
            $user->setPassword('');
            $user->setEnabled(true);

            $setter = 'set' . ucfirst($serviceName) . 'Id';

            $idPath = $response->getPath('resource_owner_id');
            $user->$setter($response->getResponse()[$idPath]);//update user id
        }
        // else update props of existing user
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        $user->$setter($response->getAccessToken());//update access token

        $user->setProfilePicture($response->getProfilePicture());

        return $user;
    }
}