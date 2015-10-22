<?php namespace Arcanys\SSOAuthBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class SSOUserProvider implements UserProviderInterface
{
    protected $config;
    protected $doctrine;
    protected $class;

    public function __construct($config,$doctrine){
        $this->config = $config;
        $this->doctrine = $doctrine;
        $this->class = $this->config['user_provider']['class'];
    }

    public function loadUserByUsername($userData)
    {
        if(is_array($userData)){
            $user = $this->doctrine->getRepository($this->class)->findOneByUsername($userData['username']);
        }else{
            $user = $this->doctrine->getRepository($this->class)->findOneByUsername($userData);
        }

        $new = false;
        if (!$user) {
            $user = new $this->class();
            $new = true;
        }
        if(isset($userData['username']))
            $user->setUsername($userData['username']);
        if(isset($userData['email']))
            $user->setEmail($userData['email']);
        if(isset($userData['firstname']))
            $user->setFirstname($userData['firstname']);
        if(isset($userData['lastname']))
            $user->setLastname($userData['lastname']);
        if(isset($userData['roles']))
            $user->setRoles($userData['roles']);
        
       if($new){
           $this->doctrine->getManager()->persist($user);
       }
        
        $this->doctrine->getManager()->flush();
        
        return $user;

    }

    public function refreshUser(UserInterface $user)
    {
        // throw new UnsupportedUserException();
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        $interfaces = class_implements($class);
        return in_array($this->class,$interfaces);
    }

}
