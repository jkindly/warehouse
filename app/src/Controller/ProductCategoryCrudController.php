<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name'),
        ];

        $productsField = AssociationField::new('products')
            ->autocomplete()
            ->setFormTypeOption('by_reference', false);

        if (Crud::PAGE_DETAIL === $pageName) {
            $productsField->setTemplatePath('product_category/product_list.html.twig');
        }

        $fields[] = $productsField;

        return $fields;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_INDEX, 'app.crud.product_category.index.title')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL,
                fn (Action $action) => $action->setIcon('fa fa-eye'));
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (false === $entityInstance instanceof ProductCategory) {
            throw new \RuntimeException('This controller can only manage instances of the ProductCategory class.');
        }

        $entityInstance->removeAllProducts();

        parent::deleteEntity($entityManager, $entityInstance);
    }
}
