<?php

define('DATA_FILE', __DIR__ . '/data/courses.json');

// Basic Router
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Load existing data
function loadCourses() {
    if (!file_exists(DATA_FILE)) return [];
    return json_decode(file_get_contents(DATA_FILE), true) ?? [];
}

// Save data
function saveCourses($courses) {
    file_put_contents(DATA_FILE, json_encode($courses, JSON_PRETTY_PRINT));
}

// JSON response
function respond($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Routing Logic
if ($uri == '/courses' && $method == 'GET') {
    $courses = loadCourses();
    respond($courses);
}

elseif (preg_match('#^/courses/([\w\-]+)$#', $uri, $matches) && $method == 'GET') {
    $courseId = $matches[1];
    $courses = loadCourses();
    foreach ($courses as $course) {
        if ($course['id'] === $courseId) {
            respond($course);
        }
    }
    respond(["error" => "Course not found"], 404);
}

elseif ($uri == '/courses' && $method == 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!isset($input['title']) || !isset($input['description'])) {
        respond(["error" => "Missing fields"], 400);
    }

    $courses = loadCourses();
    $newCourse = [
        'id' => uniqid(),
        'title' => $input['title'],
        'description' => $input['description']
    ];
    $courses[] = $newCourse;
    saveCourses($courses);
    respond($newCourse, 201);
}

else {
    respond(["error" => "Endpoint not found"], 404);
}
