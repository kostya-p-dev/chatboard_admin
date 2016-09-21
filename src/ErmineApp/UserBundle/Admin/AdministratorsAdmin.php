<?php

namespace ErmineApp\UserBundle\Admin;

use ErmineApp\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class AdministratorsAdmin
 * @package ErmineApp\UserBundle\Admin
 */
class AdministratorsAdmin extends Admin
{
    protected $baseRouteName = 'admin_vendor_bundlename_adminclassname';

    protected $baseRoutePattern = 'managers';

    /*Is Admin*/
    public function createQuery($context = 'list')
    {
        $query = $this->getModelManager()->createQuery($this->getClass(), 'u');

        $isAdmin = $this->isGranted('ROLE_SUPER_ADMIN');
        if ($isAdmin) {
            $query
                ->andWhere('u.role = :role ')
                ->setParameter('role', 'ROLE_SUPER_ADMIN')
            ;
        }

        return $query;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', null, ['required' => true])
            ->add('role', 'choice', [
                'choices'   => ['ROLE_SUPER_ADMIN' => 'Admin'],
                'label' => 'Role',
                'data' => 'Administrator',
            ])
        ;

        /*If is new Admin*/
        if ($this->getSubject()->getId() === null) {
            $formMapper
                ->add('NewPassword', 'password', [
                    'label' => 'Password'
                ])
            ;
        }else{
            $formMapper
                ->add('NewPassword', 'password', [
                    'label' => 'Password',
                    'required' => false
                ])
            ;
        }
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('created')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->add('role', 'string', ['lable' => 'Role', 'template' => 'ErmineAppAdminBundle:Administrators:ListImgField.html.twig'])
            ->add('created')

            ->add('_action', 'actions', [
                'actions' => [
                    'edit'   => [],
                    'delete' => []
                ]
            ])
        ;
    }


    public function prePersist($object) {

        /** @var  User $object */
        $newPass = $object
            ->getNewPassword();

        if(strlen($newPass) > 0){
            $encoder = $this->getConfigurationPool()->getContainer()->get('security.password_encoder');
            $encoded = $encoder->encodePassword($object, $newPass);

            $object
                ->setPassword($encoded)
                ->setRole('ROLE_SUPER_ADMIN')
                ->setName($object->getUsername())
                ->setStatus('1')
                ->setFbid('')
                ->setCreated(new \DateTime('now'))
                ->setLogin('1')
                ->setStatus('1')
                ->setLanStatus('1')
                ->setIsOnline('0')
            ;
        }
    }

    public function preUpdate($object) {
        $newPass = $object
            ->getNewPassword();
        if(strlen($newPass) > 0){
            $encoder = $this->getConfigurationPool()->getContainer()->get('security.password_encoder');
            $encoded = $encoder->encodePassword($object, $newPass);
            $object->setPassword($encoded);
        }
    }
}