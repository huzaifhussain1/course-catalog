<?php
namespace Src\Controller;

use Src\Service\CategoryService;

class CategoryController {
    private $categoryService;

    public function __construct() {
        $this->categoryService = new CategoryService();
    }

    public function getCategories() {
        $categories = $this->categoryService->getAllCategories();
        echo json_encode($categories);
    }

}
