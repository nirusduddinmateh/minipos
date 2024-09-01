<?php
class Model
{
    private $conn;
    private $table;

    // Constructor to initialize the database connection and table
    public function __construct($db, $table)
    {
        $this->conn = $db;
        $this->table = $table;
    }

    // Create a new record
    public function create($data)
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO " . $this->table . " ($fields) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // Read records with optional conditions, ordering, and pagination
    public function read($conditions = [], $orderBy = '', $joins = [], $limit = null, $offset = null)
    {
        $query = "SELECT * FROM " . $this->table;

        // Add JOIN clauses
        if (!empty($joins)) {
            foreach ($joins as $join) {
                $query .= " " . $join['type'] . " JOIN " . $join['table'] . " ON " . $join['on'];
            }
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . $this->buildConditions($conditions);
        }

        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }

        /*if (!is_null($limit)) {
            $query .= " LIMIT :limit";
            if (!is_null($offset)) {
                $query .= " OFFSET :offset";
            }
        }*/

        $stmt = $this->conn->prepare($query);

        foreach ($conditions as $key => $value) {
            if (is_array($value)) {
                switch (strtolower($value[0])) {
                    case 'like':
                        $stmt->bindValue(":$key", $value[1]);
                        break;
                    case 'in':
                        foreach ($value[1] as $index => $inValue) {
                            $stmt->bindValue($index + 1, $inValue);
                        }
                        break;
                    case 'between':
                        $stmt->bindValue(1, $value[1]);
                        $stmt->bindValue(2, $value[2]);
                        break;
                }
            } else {
                $stmt->bindValue(":$key", $value);
            }
        }

        /*if (!is_null($limit)) {
            $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        }
        if (!is_null($offset)) {
            $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);
        }*/

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single record by conditions (e.g., ID)
    public function readOne($conditions)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->buildConditions($conditions) . " LIMIT 1";
        $stmt = $this->conn->prepare($query);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a record
    public function update($data, $conditions)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = :$key";
        }
        $updateString = implode(", ", $updates);

        $query = "UPDATE " . $this->table . " SET $updateString WHERE " . $this->buildConditions($conditions);
        $stmt = $this->conn->prepare($query);

        // Bind parameters for updating data
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Bind parameters for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // Delete a record
    public function delete($conditions)
    {
        $query = "DELETE FROM " . $this->table . " WHERE " . $this->buildConditions($conditions);
        $stmt = $this->conn->prepare($query);

        // Bind parameters for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    // Helper function to build query conditions
    private function buildConditions($conditions)
    {
        $conditionArray = [];
        foreach ($conditions as $key => $value) {
            // Handle complex conditions
            if (is_array($value)) {
                switch (strtolower($value[0])) {
                    case 'like':
                        $conditionArray[] = "$key LIKE :$key";
                        break;
                    case 'in':
                        // Handle the IN clause
                        $placeholders = implode(', ', array_fill(0, count($value[1]), '?'));
                        $conditionArray[] = "$key IN ($placeholders)";
                        break;
                    case 'between':
                        // Handle the BETWEEN clause
                        $conditionArray[] = "$key BETWEEN ? AND ?";
                        break;
                    // Add more cases as needed
                    default:
                        $conditionArray[] = "$key = :$key";
                }
            } else {
                // Handle simple equality condition
                $conditionArray[] = "$key = :$key";
            }
        }
        return implode(" AND ", $conditionArray);
    }


    // Count total records (useful for pagination)
    public function count($conditions = [])
    {
        $query = "SELECT COUNT(*) FROM " . $this->table;

        if (!empty($conditions)) {
            $query .= " WHERE " . $this->buildConditions($conditions);
        }

        $stmt = $this->conn->prepare($query);

        // Bind parameters for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
