<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $hasher;

    public function __construct()
    {
        $this->hasher = new UserPasswordHasher(new PasswordHasherFactory([]));
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ArrayField::new('Roles')->formatValue(function ($value) {
                if (in_array('ROLE_ADMIN', $value)) {
                    return '<span class="material-symbols-outlined">
edit
</span>';
                } elseif (in_array('ROLE_USER', $value)) {
                    return '<span class="material-symbols-outlined">
person
</span>';
                } else{
                    return '';
                }
            }),
            TextField::new('password', 'Password', PasswordType::class, [
                'hash_property_path' => 'password',
                'required' => false,
                'empty_data' => '',
                'autocomplet' => 'new-password',
            ])->onlyOnForms(),
        ];
    }

    public function setUserPassword(User $user): void
    {
        $userRequest = $this->getContext()->getRequest()->get('User');
        if (!empty($userRequest['password'])) {
            $password = $userRequest['password'];
            $user->setPassword($this->hasher->hashPassword($user, $password));
        }
    }
}
