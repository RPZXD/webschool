<?php
// scratch/migrate_landing_slides.php
// Creates `landing_slides` table and seeds default slides

require_once dirname(__DIR__) . '/config/database.php';

try {
    $db = Database::connect();
    
    // Create landing_slides table
    $db->exec("CREATE TABLE IF NOT EXISTS `landing_slides` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) DEFAULT NULL,
      `image_url` VARCHAR(255) NOT NULL,
      `display_order` INT NOT NULL DEFAULT 0,
      `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    echo "Table 'landing_slides' created or already exists.<br>";
    
    // Check if table is empty, if so, seed default slides
    $stmt = $db->query("SELECT COUNT(*) FROM `landing_slides`");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $db->exec("INSERT INTO `landing_slides` (`title`, `image_url`, `display_order`, `status`) VALUES
        ('ข่าวสาร 1', 'images/budget02.png', 1, 'active'),
        ('ข่าวสาร 2', 'images/budget.png', 2, 'active')");
        echo "Default landing slides seeded successfully.<br>";
    } else {
        echo "Table already has records. Seeding skipped.<br>";
    }
    
    echo "Migration completed successfully!<br>";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
    exit(1);
}
