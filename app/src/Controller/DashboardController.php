<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle($this->translator->trans('app.title'))
            ->setLocales(['en', 'pl']);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud(
            'app.menu.products.title',
            'fas fa-list',
            Product::class
        )->setController(ProductCrudController::class);
        yield MenuItem::linkToCrud(
            'app.menu.categories.title',
            'fas fa-list',
            ProductCategory::class
        )->setController(ProductCategoryCrudController::class);
    }
}
