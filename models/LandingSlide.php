<?php
// models/LandingSlide.php
// Interacts with `landing_slides` table for the entry landing page www.phichai.ac.th /home

class LandingSlide {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Retrieves all landing slides ordered by display order
     * @param bool $onlyActive If true, returns only active slides
     * @return array
     */
    public function getAll($onlyActive = false) {
        try {
            $sql = "SELECT * FROM landing_slides";
            
            if ($onlyActive) {
                $sql .= " WHERE status = 'active'";
            }
            
            $sql .= " ORDER BY display_order ASC, id DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                if (isset($row['image_url'])) {
                    $row['image_url'] = clean_db_url($row['image_url']);
                }
            }
            return $rows;
        } catch (PDOException $e) {
            error_log("Landing database query error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieves a single landing slide by ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM landing_slides WHERE id = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
            if ($row && isset($row['image_url'])) {
                $row['image_url'] = clean_db_url($row['image_url']);
            }
            return $row;
        } catch (PDOException $e) {
            error_log("Landing details query error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Inserts a new landing slide
     * @param array $data keys: title, image_url, display_order, status
     * @return bool
     */
    public function create($data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO landing_slides (title, image_url, display_order, status) 
                                        VALUES (:title, :image_url, :display_order, :status)");
            return $stmt->execute([
                'title' => $data['title'] ?? null,
                'image_url' => $data['image_url'],
                'display_order' => (int)($data['display_order'] ?? 0),
                'status' => $data['status'] ?? 'active'
            ]);
        } catch (PDOException $e) {
            error_log("Create landing slide error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates an existing landing slide
     * @param int $id
     * @param array $data keys: title, (optional) image_url, display_order, status
     * @return bool
     */
    public function update($id, $data) {
        try {
            $sql = "UPDATE landing_slides SET title = :title, display_order = :display_order, status = :status";
            $params = [
                'id' => $id,
                'title' => $data['title'] ?? null,
                'display_order' => (int)($data['display_order'] ?? 0),
                'status' => $data['status'] ?? 'active'
            ];
            
            if (isset($data['image_url'])) {
                $sql .= ", image_url = :image_url";
                $params['image_url'] = $data['image_url'];
            }
            
            $sql .= " WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Update landing slide error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a landing slide
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM landing_slides WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Delete landing slide error: " . $e->getMessage());
            return false;
        }
    }
}
