<?php
namespace Src\Controller;

use Src\Service\CourseService;

class CourseController {
    private $courseService;

    public function __construct() {
        $this->courseService = new CourseService();
    }

    // Get all courses
    public function getCourses() {
        if(isset($_GET['category_id'])){
            $categoryId = (isset($_GET['category_id']) && $_GET['category_id'] != 'undefined') ? $_GET['category_id'] : null;
            $courses = $this->courseService->getAllCourses($categoryId);
        }
        elseif(isset($_GET['course_id'])){
            $courseId = (isset($_GET['course_id']) && $_GET['course_id'] != 'undefined') ? $_GET['course_id'] : null;
            $courses = $this->courseService->getAllCourses(null,$courseId);
        }
        echo json_encode($courses);
    }

    // Get course by ID
    public function getCourseById($id) {
        $course = $this->courseService->getCourseById($id);
        if ($course) {
            echo json_encode($course);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
        }
    }
}
