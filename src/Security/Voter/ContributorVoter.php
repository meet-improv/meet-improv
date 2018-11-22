<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Contributor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Team;

class ContributorVoter extends Voter
{
    const EDIT_CONTRIBUTOR = 'EDIT_CONTRIBUTOR';
    const MANAGE_USER_AS_EDITOR = 'MANAGE_USER_AS_EDITOR';
    
    const CREATE_EVENT_AS_CONTRIBUTOR = 'CREATE_EVENT_AS_CONTRIBUTOR';
    const CREATE_OPENDATE_AS_CONTRIBUTOR = 'CREATE_OPENDATE_AS_CONTRIBUTOR';
    const EDIT_EVENT_AS_CONTRIBUTOR = 'EDIT_EVENT_AS_CONTRIBUTOR';
    const EDIT_OPENDATE_AS_CONTRIBUTOR = 'EDIT_OPENDATE_AS_CONTRIBUTOR';
    
    const INVITE_TO_OPENDATE_AS_CONTRIBUTOR = 'INVITE_TO_OPENDATE_AS_CONTRIBUTOR';
    
    const COMMENT_EVENT_AS_CONTRIBUTOR = 'REPLY_TO_EVENT_AS_CONTRIBUTOR';
    const COMMENT_OPENDATE_AS_CONTRIBUTOR = 'REPLY_TO_OPENDATE_AS_CONTRIBUTOR';
    
    

    
    
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT_CONTRIBUTOR, self::MANAGE_USER_AS_EDITOR])
            && $subject instanceof Contributor;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }


        // you know $subject is a Post object, thanks to supports
        /** @var Contributor $contributor */
        $contributor = $subject;
        
        
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT_CONTRIBUTOR:
                
                if($contributor->getType() == Contributor::TYPE_TEAM && !is_null($contributor->getTroupe())){
                    /** @var Team $contributor */
                    return $contributor->getAdmins()->contains($user) or $contributor->getTroupe()->getAdmins()->contains($user);
                }else{
                    /** @var Contributor $contributor */
                    return $contributor->getAdmins()->contains($user);
                }
                
                
                break;
            case self::MANAGE_USER_AS_EDITOR:
                
                if($contributor->getType() == Contributor::TYPE_TEAM && !is_null($contributor->getTroupe()) ){
                    /** @var Team $contributor */
                    return $contributor->getSuperAdmins()->contains($user) or $contributor->getTroupe()->getSuperAdmins()->contains($user);
                }else{
                    /** @var Contributor $contributor */
                    return $contributor->getSuperAdmins()->contains($user);
                }
                
                
                break;

        }

        return false;
    }
}
