<?php
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $category_badge = $_POST['category_badge'] ?? '';
    $summary = $_POST['summary'] ?? '';
    $author = $_POST['author'] ?? '';
    $published_date = $_POST['published_date'] ?? '';

   // Handle Image Upload
    if (isset($_FILES['image'])) {
        $fileError = $_FILES['image']['error'];
        
        if ($fileError === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size']; // Check file size in bytes
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            // Limit file size to 5MB (5 * 1024 * 1024 bytes)
            if ($fileSize > 5 * 1024 * 1024) {
                $message = "<div class='alert alert-danger'>Error: Image file is too large. Maximum size allowed is 5MB.</div>";
            } else {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    
                    $uploadFileDir = __DIR__ . '/uploads/';
                    
                    if (!is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0777, true);
                    }
                    
                    $dest_path = $uploadFileDir . $newFileName;
                    $db_path = 'uploads/' . $newFileName;
                    
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $stmt = $pdo->prepare("INSERT INTO news (title, category, category_badge, summary, image_path, author, published_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$title, $category, $category_badge, $summary, $db_path, $author, $published_date]);
                        
                        $message = "<div class='alert alert-success'>News article published successfully! <a href='index.php' class='alert-link'>View Website</a></div>";
                    } else {
                        $message = "<div class='alert alert-danger'>Error: move_uploaded_file() failed. Check folder permissions.</div>";
                    }
                } else {
                    $message = "<div class='alert alert-danger'>Invalid file type. Only JPG, JPEG, PNG, and WEBP allowed.</div>";
                }
            }
        } else {
            $message = "<div class='alert alert-danger'>Upload failed with PHP error code: $fileError</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add News</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- External Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm border-0 rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Admin Panel</h2>
                        <p class="text-muted small mb-0">Publish a new story to NSBM 360</p>
                    </div>
                    <a href="index.php" class="btn btn-outline-success btn-sm fw-semibold">View Live Site &rarr;</a>
                </div>

                <?php echo $message; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Article Title</label>
                        <input type="text" name="title" class="form-control shadow-none" placeholder="e.g., Annual Sports Meet kicks off" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Category Name</label>
                            <select name="category" class="form-select shadow-none" required>
                                <option value="CAMPUS NEWS">CAMPUS NEWS</option>
                                <option value="ACADEMIC">ACADEMIC</option>
                                <option value="CLUBS">CLUBS</option>
                                <option value="SPORTS">SPORTS</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Badge Style Class</label>
                            <select name="category_badge" class="form-select shadow-none" required>
                                <option value="badge-campus">badge-campus (Blue)</option>
                                <option value="badge-academic">badge-academic (Green)</option>
                                <option value="badge-clubs">badge-clubs (Orange)</option>
                                <option value="badge-sports">badge-sports (Purple)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Summary / Description</label>
                        <textarea name="summary" class="form-control shadow-none" rows="3" placeholder="Write a short tagline or summary for the card..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload Image</label>
                        <input type="file" name="image" class="form-control shadow-none" accept="image/*" required>
                        <div class="form-text">Choose an image from your computer (JPG, PNG, WEBP).</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Author / Department</label>
                            <input type="text" name="author" class="form-control shadow-none" value="NSBM 360 Editorial" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Published Date</label>
                            <input type="text" name="published_date" class="form-control shadow-none" value="16 Oct 2026" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-semibold py-2 mt-2">Publish to Website</button>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>