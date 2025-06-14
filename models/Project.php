<?php
require_once 'db.php';

class Project {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // Insert a new document record (one file per record)
    public function addProject($data, $filePath) {
        $sql = "INSERT INTO projects 
                (section, type_of_document, source_of_information, author,  description, file_path, creation_date, vote_count, rating, published)
                VALUES (:section, :type_of_document, :source_of_information, :author, :description, :file_path, NOW(), 0, 0, :published)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':section'              => $data['section'],
            ':type_of_document'     => $data['type_of_document'],
            ':source_of_information'=> $data['source_of_information'],
            ':author'               => $data['author'],
            ':description'          => $data['description'],
            ':file_path'            => $filePath,
            ':published'            => isset($data['published']) ? 1 : 0
        ]);
    }

    // Retrieve all document records with optional filters and sorting.
    public function getAllProjects($filters = [], $sort_by = 'creation_date', $sort_order = 'DESC') {
        // Updated allowedColumns, removed 'location'
        $allowedColumns = ['id', 'section', 'type_of_document', 'source_of_information', 'author', 'description', 'creation_date', 'rating', 'vote_count'];
        if (!in_array($sort_by, $allowedColumns)) {
            $sort_by = 'creation_date';
        }
        $sort_order = strtoupper($sort_order) === 'ASC' ? 'ASC' : 'DESC';
    
        $sql = "SELECT * FROM projects WHERE 1=1";
        $params = [];
    
        if (!empty($filters['search'])) {
            // Search in description, id, author, or creation date (formatted as DD/MM/YYYY)
            $sql .= " AND (
                description ILIKE :search 
                OR CAST(id AS TEXT) ILIKE :search 
                OR author ILIKE :search 
                OR TO_CHAR(creation_date, 'DD/MM/YYYY') ILIKE :search
            )";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['section'])) {
            $sql .= " AND section = :section";
            $params[':section'] = $filters['section'];
        }
    
        $sql .= " ORDER BY $sort_by $sort_order LIMIT 100";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Retrieve a single project by its id.
    public function getProjectById($id) {
        $sql = "SELECT * FROM projects WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // First-time star rating update.
    public function updateStarRating($projectId, $stars) {
        $sql = "SELECT rating, vote_count FROM projects WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $projectId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $currentRating = (float)$result['rating'];
            $voteCount = (int)$result['vote_count'];
            $newVoteCount = $voteCount + 1;
            $newRating = (($currentRating * $voteCount) + $stars) / $newVoteCount;
            $updateSql = "UPDATE projects SET rating = :rating, vote_count = :vote_count WHERE id = :id";
            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute([
                ':rating' => $newRating,
                ':vote_count' => $newVoteCount,
                ':id' => $projectId
            ]);
        }
    }

    // Change existing star rating.
    public function changeStarRating($projectId, $oldStar, $newStar) {
        $sql = "SELECT rating, vote_count FROM projects WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $projectId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $currentRating = (float)$result['rating'];
            $voteCount = (int)$result['vote_count'];
            if ($voteCount > 0) {
                $newRating = (($currentRating * $voteCount) - $oldStar + $newStar) / $voteCount;
                $updateSql = "UPDATE projects SET rating = :rating WHERE id = :id";
                $updateStmt = $this->pdo->prepare($updateSql);
                $updateStmt->execute([
                    ':rating' => $newRating,
                    ':id' => $projectId
                ]);
            }
        }
    }
}
