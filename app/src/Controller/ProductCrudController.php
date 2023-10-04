<?php

namespace App\Controller;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('name', 'app.crud.product.new.name'),
            AssociationField::new('productCategory', 'app.crud.product.new.category')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
            TextareaField::new('description', 'app.crud.product.new.description'),
            IntegerField::new('price', 'app.crud.product.new.price'),
            TextField::new('sku', 'app.crud.product.new.sku'),
            IntegerField::new('quantity', 'app.crud.product.new.quantity'),
            ImageField::new('image', 'app.crud.product.new.image')
                ->setBasePath('/uploads/images/products')
                ->setUploadDir('public/uploads/images/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle(Crud::PAGE_NEW, 'app.crud.product.new.title')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL,
                fn (Action $action) => $action->setIcon('fa fa-eye'));
    }

}
