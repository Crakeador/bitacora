<?php
header('Content-Type: application/json');

// Use the existing database connection details from your project
$host = '127.0.0.1';
$dbname = 'bitacora';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:dbname=$dbname;host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Return an empty array or an error message if the connection fails
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// FullCalendar automatically sends 'start' and 'end' GET parameters
// We use these to only fetch events within the current view for efficiency.
// We assume the table is named 'events' for now. I will provide the SQL for it later.
$query = "SELECT id, title, start, end, color FROM events WHERE start >= ? AND end <= ?";

try {
    $stmt = $pdo->prepare($query);
    
    // Bind the start and end parameters from FullCalendar's request
    $stmt->execute([$_GET['start'], $_GET['end']]);
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the events as JSON
    echo json_encode($result);

} catch (PDOException $e) {
    // In case of a query error, return an empty array.
    // You might want to log the error `$e->getMessage()` instead of showing it.
    echo json_encode(['error' => 'Could not fetch events.']);
}
?>