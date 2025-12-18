<?php
require_once "conn.php";

/* =========================
   DELETE ALL FILES FIRST
========================= */

// Fetch all records
$sql = "SELECT img, video FROM news";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        // ---------- DELETE IMAGE ----------
        if (!empty($row['img'])) {
            $imgPath = "uploads/images/" . $row['img'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        // ---------- DELETE VIDEO FILE (if stored as file) ----------
        if (!empty($row['video']) && !filter_var($row['video'], FILTER_VALIDATE_URL)) {
            $videoPath = "uploads/videos/" . $row['video'];
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }
    }
}

/* =========================
   DELETE ALL RECORDS
========================= */
$deleteSql = "DELETE FROM news";
$conn->query($deleteSql);

/* =========================
   RESET AUTO INCREMENT
========================= */
$conn->query("ALTER TABLE news AUTO_INCREMENT = 1");

echo "✅ All records and related files deleted successfully.";

$conn->close();
?>
