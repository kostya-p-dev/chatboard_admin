<?php

namespace ErmineApp\UserBundle\Admin;

use ErmineApp\UserBundle\Entity\User;
use ErmineApp\UserBundle\Entity\UserFiles;
use ErmineApp\UserBundle\Entity\UserFilesRepository;
use ErmineApp\UserBundle\Entity\UserRepository;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use ErmineApp\FilesBundle\Service\FilesManager;

class UserAdmin extends Admin
{

    /*Is Admin*/
    public function createQuery($context = 'list')
    {
        $query = $this->getModelManager()->createQuery($this->getClass(), 'u');
        $query
            ->andWhere('u.role <> :role ')
            ->setParameter('role', 'ROLE_SUPER_ADMIN')
        ;
        return $query;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setTemplate('edit', 'ErmineAppAdminBundle:User:edit_form.html.twig');

        $formMapper
            ->add('name')
            ->add('about')
            ->add('email', 'email', array('required' =>  true))
            ->add('age')
            ->add('phone')
        ;

        /*Files*/
        $formMapper
            ->add('imgFile0', 'file', array('label' => 'Picture', 'required' =>  true, 'attr' => array('style' => 'border: 0px; padding: 0;')))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('email')
            ->add('img')
            ->add('created')
            ->add('phone')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', 'text', ['editable' => true])
            ->add('Email')
            ->add('created')
            ->add('phone')
            ->add('Image', 'string', ['template' => 'ErmineAppAdminBundle:User:ListImgField.html.twig'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => [],
                    'edit'   => [],
//                    'delete' => []
                ]
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('img')
            ->add('id')
            ->add('name')
            ->add('age')
            ->add('About')
            ->add('Email')
            ->add('created')
            ->add('gender','boolean')
            ->add('phone')
        ;
    }

    public function postUpdate($object) {
        $this->manageFileUpload($object);
    }

    public function prePersist($object){
        $date = new \DateTime('now');

        /**@var  User $object*/
        $object
            ->setCreated($date)
            ->setRole('ROLE_USER')
        ;
    }

    public function postPersist($object){
        $this->manageFileUpload($object);
    }


    /**
     * @param mixed $object
     */
//    public function postPersist($object){
//    }


    public function manageFileUpload(User $object) {
        /** @var FilesManager $fileManager */
        $fileManager = $this->getConfigurationPool()->getContainer()->get('files_manager');

        /** @var UserRepository $userRepo */
        $userRepo = $this->getConfigurationPool()->getContainer()->get('app_user_repository');

        /** @var UserFilesRepository $userFilesRepo */
        $userFilesRepo = $this->getConfigurationPool()->getContainer()->get('app_user_files_repository');

        $files = [];
        if(!is_null($object->getImgFile0())) $files[0] = $object->getImgFile0();

        /* OLD FILES */
        /** @var UserFiles $oldFile */
        $oldFiles = $object->getUserfiles();
        if(count($oldFiles) > 0){
            foreach($oldFiles as $key => $oldFile){
                if(is_object($oldFile) && isset($files[$key])){

                    /* UPDATE */
                    if(!$fileEntity = $fileManager->uploadFile($object, $files[$key], $oldFile)){
                        $this->getRequest()->getSession()->getFlashBag()->add("error", "Wrong file type, please select again");
                        break; /*FormatError*/
                    }
                    unset($files[$key]);

                }
//                elseif(is_object($oldFile) && in_array($key, $removeFilesIndex )){
//
//                    /* REMOVE */
//                    $filesManager->removeUserFile($oldFile);
//                    $object->removeUserfile($oldFile);
//                    $userFilesRepo->remove($oldFile);
//                    unset($files[$key]);
//                }
            }
        }



        foreach($files as $key => $newFile) {
            if(!$fileEntity = $fileManager->uploadFile($object, $newFile)){
                 $this->getRequest()->getSession()->getFlashBag()->add("error", "Wrong file type, please select again");
            }elseif(is_object($fileEntity)){
                $fileEntity
                    ->setUser($object);
                $userFilesRepo->save($fileEntity);
            }
        }
    }
}