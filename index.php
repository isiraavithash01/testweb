<?php
include 'db.php';

// Fetch all news items from MySQL, newest first
$stmt = $pdo->query("SELECT * FROM news ORDER BY id DESC");
$news_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_stories = count($news_items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest News - NSBM 360</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- External Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<main class="container py-5">
    <!-- Breadcrumb & Header Section -->
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Latest news</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-1">Latest news</h1>
        <p class="text-muted">The stories, achievements and ideas shaping life at NSBM.</p>
    </div>

    <!-- Filter & Search Section -->
    <div class="card p-3 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-lg-4 col-md-12">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search by title or keyword">
                </div>
            </div>
            <div class="col-lg-2 col-md-4">
                <select class="form-select text-muted shadow-none">
                    <option selected>All categories</option>
                    <option value="1">Campus News</option>
                    <option value="2">Academic</option>
                    <option value="3">Clubs</option>
                    <option value="4">Sports</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <select class="form-select text-muted shadow-none">
                    <option selected>Published</option>
                    <option value="1">Draft</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <select class="form-select text-muted shadow-none">
                    <option selected>October 2026</option>
                    <option value="1">September 2026</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-12">
                <button class="btn btn-success w-100 fw-semibold">Search</button>
            </div>
        </div>
    </div>

    <!-- Results Count and Sort -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <span class="text-muted small"><?php echo $total_stories; ?> stories &middot; Showing the latest from across campus</span>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">Sort by:</span>
            <select class="form-select form-select-sm w-auto shadow-none">
                <option selected>Newest first</option>
                <option value="1">Oldest first</option>
            </select>
        </div>
    </div>

    <!-- Cards Grid (Dynamic PHP Loop) -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        <?php foreach ($news_items as $item): ?>
        <div class="col">
            <div class="card h-100">
                <!-- Dynamic Image from uploads folder via Database Path -->
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="card-img-top" alt="News Image">
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <!-- Dynamic Badge Class and Category Text -->
                        <span class="badge <?php echo htmlspecialchars($item['category_badge']); ?> px-2 py-1 rounded">
                            <?php echo htmlspecialchars($item['category']); ?>
                        </span>
                    </div>
                    <!-- Dynamic Title -->
                    <h5 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($item['title']); ?></h5>
                    <!-- Dynamic Summary / Tagline -->
                    <p class="card-text text-muted small flex-grow-1"><?php echo htmlspecialchars($item['summary']); ?></p>
                    <div class="mt-3">
                        <!-- Dynamic Author and Date -->
                        <p class="text-custom-muted mb-2"><?php echo htmlspecialchars($item['author']); ?> &bull; <?php echo htmlspecialchars($item['published_date']); ?></p>
                        <a href="#" class="read-story-link">Read story &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bottom Pagination Section -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pt-3 border-top">
        <span class="text-muted small">Showing 1-6 of <?php echo $total_stories; ?> results</span>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>
                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</main>

<!-- Bootstrap 5 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>