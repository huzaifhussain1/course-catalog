<?php
namespace Src\Service;

use Src\Database\Database;
use Src\Model\Category;

class CategoryService {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAllCategories() {
        $query = "
        SELECT 
            COUNT(co.category_id) AS course_count,
         c.*
        FROM categories c
        Left JOIN courses co ON c.id = co.category_id
        GROUP BY c.id";
        $stmt = $this->db->prepare($query);
        
        if ($stmt->execute()) {
            $categories = [];
            
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $categories[] = $row;
            }
            return $categories; 
        } else {
            return false;
        }
    }

    
}
