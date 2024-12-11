<?php

require __DIR__ . "/../Logs/loginSystem.php";
class Agent {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Add an agent
    public function addAgent($agent_name, $agent_uname, $agent_pass) {
        $stmt = $this->conn->prepare("INSERT INTO agents (agent_name, agent_uname, agent_pass) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $agent_name, $agent_uname, $agent_pass);
        return $stmt->execute();
    }

    // Edit an agent
    public function editAgent($id, $agent_name, $agent_uname, $agent_pass) {
        $stmt = $this->conn->prepare("UPDATE agents SET agent_name=?, agent_uname=?, agent_pass=? WHERE id=?");
        $stmt->bind_param("sssi", $agent_name, $agent_uname, $agent_pass, $id);
        return $stmt->execute();
    }

    // Delete an agent
    public function deleteAgent($id) {
        $stmt = $this->conn->prepare("DELETE FROM agents WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get all agents
    public function getAllAgents() {
        $result = $this->conn->query("SELECT * FROM agents");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Get a specific agent by ID
    public function getAgentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM agents WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;  // Return null if no result is found
    }
}
?>
