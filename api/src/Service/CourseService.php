<?php
namespace Src\Service;

use Src\Database\Database;
use Src\Model\Course;

class CourseService {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAllCourses($categoryId = null,$courseId = null) {
        // Start the query to select all courses, with category information
        $query = "SELECT courses.*, categories.name AS category_name 
                  FROM courses 
                  LEFT JOIN categories ON courses.category_id = categories.id"; // Perform a LEFT JOIN with categories
        
        // If a category ID is provided, filter by category
        if ($categoryId) {
            $query .= " WHERE courses.category_id = :category_id";
        }
        if($courseId){
            $query .= " WHERE courses.course_id = :course_id";
        }
        
        // Prepare the SQL query
        $stmt = $this->db->prepare($query);
        
        // If a category ID is provided, bind it to the statement
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId);
        }
        if ($courseId) {
            $stmt->bindParam(':course_id', $courseId);
        }
        
        // Execute the query
        $stmt->execute();
        
        // Initialize an array to store the courses
        $courses = [];
        
        // Fetch all rows and store them in the courses array
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            // You can now access the category name via $row['category_name']
            $courses[] = $row;
        }
        
        // Return the array of courses
        return $courses;
    }
    
    

    // Get a course by its ID
    public function getCourseById($course_id) {
        // Prepare the SQL query to fetch a course by its ID
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        
        // Fetch the row as an associative array
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        // If a course is found, return a Course object
        if ($row) {
            return array(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['preview'],
                $row['main_category_name'],
                $row['created_at'],
                $row['updated_at'],
                $row['category_id']
            );
        }
        
        // Return null if no course is found
        return null;
    }
}
