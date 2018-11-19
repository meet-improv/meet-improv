<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\OpenDate;
use Faker\Test\Provider\Collection;
use Symfony\Component\Security\Core\Security;

class OpenDateVoter extends Voter
{
    
    const OPENDATE_VIEW = "OPENDATE_VIEW";
    
    
    
    private $security;
    
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [ self::OPENDATE_VIEW])
            && $subject instanceof OpenDate;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var OpenDate $opendate */
        $opendate = $subject;
        
        
        
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::OPENDATE_VIEW:
                
                // An OpenDate is visible if public or by the admins of the owner and the admins of the invited
                
                if($opendate->isPublic() && $this->security->isGranted(ContributorVoter::EDIT_CONTRIBUTOR, $opendate->getOwner())){
                    return true;
                }else{
                   
                    foreach ($opendate->getInvitedContributors()->getValues() as $invitedContributor){
                        if($this->security->isGranted(ContributorVoter::EDIT_CONTRIBUTOR, $invitedContributor)){
                            return true;
                        }
                    }

                }
                    
                
                
                
                break;
                
        }

        return false;
    }
}
