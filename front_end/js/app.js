document.addEventListener('DOMContentLoaded', function () {
    
    // Fetch courses for a selected category
    function fetchCoursesByCategory(categoryId) {
        fetch(`http://api.cc.localhost/courses?category_id=${categoryId}`)
            .then(response => response.json())
            .then(courses => {
                renderCourses(courses);
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
            }); 
    }

    // Function to render the courses to HTML
    function renderCourses(courses) {
        const coursesContainer = document.getElementById('courses-list');
        coursesContainer.innerHTML = ''; // Clear previous courses

        if (courses.length > 0) {
            courses.forEach(course => {
                const courseHTML = createCourseHTML(course);
                coursesContainer.innerHTML += courseHTML;
            });
        } else {
            coursesContainer.innerHTML = '<p>No courses found for this category.</p>';
        }
    }

    // Fetch all courses by default when the page loads
    fetchCoursesByCategory();

    // Fetch categories initially
    fetchCategories();
});



// Fetch categories from the API
fetch('http://api.cc.localhost/categories')
    .then(response => response.json())
    .then(categories => {
        // Organize categories into a tree structure
        const categoryTree = buildCategoryTree(categories);

        // Render the category tree in HTML
        renderCategoryTree(categoryTree);
    })
    .catch(error => {
        console.error('Error fetching categories:', error);
    });

// Function to build a tree from the category list based on parent-child relationship
function buildCategoryTree(categories) {
    const categoryMap = {};

    // Create a map of categories by their id
    categories.forEach(category => {
        categoryMap[category.id] = category;
        category.children = [];
    });

    const categoryTree = [];

    // Assign children to each category based on the parent_id
    categories.forEach(category => {
        if (category.parent_id) {
            // If a parent_id exists, push the category to its parent's children array
            categoryMap[category.parent_id].children.push(category);
        } else {
            // If there's no parent_id, it's a root category
            categoryTree.push(category);
        }
    });

    return categoryTree;
}

// Function to render the category tree to HTML
function renderCategoryTree(categoryTree) {
    const categoryTreeContainer = document.getElementById('category-tree');

    categoryTree.forEach(category => {
        const categoryHTML = createCategoryHTML(category);
        categoryTreeContainer.innerHTML += categoryHTML;
    });
}

// Function to create HTML structure for a category (including its children)
function createCategoryHTML(category) {
    let html = `<h6><a href="#" onclick="fetchCoursesByCategory('${category.id}')">${category.name} <span class="text-muted">(${category.course_count})</span></a></h6>`;
    if (category.children.length > 0) {
        html += '<ul class="list-unstyled ps-3">';
        category.children.forEach(childCategory => {
            html += `<li>${createCategoryHTML(childCategory)}</li>`;
        });
        html += '</ul>';
    }
    return html;
}

// Function to fetch courses by category ID and render them
function fetchCoursesByCategory(categoryId) {
    fetch(`http://api.cc.localhost/courses?category_id=${categoryId}`)
        .then(response => response.json())
        .then(courses => {
            renderCourses(courses);
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });
}

// Function to render the courses to HTML
function renderCourses(courses) {
    const coursesContainer = document.getElementById('courses-list');
    coursesContainer.innerHTML = ''; // Clear previous courses

    if (courses.length > 0) {
        courses.forEach(course => {
            const courseHTML = createCourseHTML(course);
            coursesContainer.innerHTML += courseHTML;
        });
    } else {
        coursesContainer.innerHTML = '<p>No courses found for this category.</p>';
    }
}


function createCourseHTML(course, col = 4) {
    let description = course.description;
    
    if (col === 4 && description.length > 200) {
      description = description.substring(0, 200) + '... ';
    }
  
    return `
      <div class="col-md-${col}">
        <div class="card course-card position-relative" onclick="handleCourseClick('${course.course_id}')">
          <span class="badge bg-secondary badge-position">${course.category_name}</span>
          <img src="${course.image_preview}" class="card-img-top" alt="${course.category_name}">
          <div class="card-body">
            <h6 class="card-title">${course.title}</h6>
            <p class="card-text text-muted">${description}</p>
          </div>
        </div>
      </div>
    `;
  }
 

// Function to handle course card click event and fetch course details
function handleCourseClick(courseId) {
    console.log(`Course clicked: ${courseId}`);
    // You can fetch more details about the course or show a modal with course details
    fetchCourseDetails(courseId);
}

// Function to fetch course details by course ID and display them
function fetchCourseDetails(courseId) {
    fetch(`http://api.cc.localhost/courses?course_id=${courseId}`)
        .then(response => response.json())
        .then(course => {
            displayCourseDetails(course);
        })
        .catch(error => {
            console.error('Error fetching course details:', error);
        });
}

// Function to display the course details (you can use a modal or a new section)
function displayCourseDetails(courses) {
    const coursesContainer = document.getElementById('courses-list');
    coursesContainer.innerHTML = ''; 
    if (courses.length > 0) {
        courses.forEach(course => {
            const courseHTML = createCourseHTML(course,12);
            coursesContainer.innerHTML += courseHTML;
        });
    } else {
        coursesContainer.innerHTML = '<p>No courses found for this category.</p>';
    }
}