<?php

class Task
{
    private $db;
    function __construct($DB_con)
    {
      $this -> db = $DB_con;
    }
    public function addTask($studid, $profid, $task_desc)
    {
       try
       {
           $stmt = $this->db->prepare("INSERT INTO tasks(stud_id, prof_id, task_desc, status) VALUES(:studid, :profid, :task_desc, 0)");
           $stmt->bindparam(":studid", $studid);
           $stmt->bindparam(":profid", $profid);
           $stmt->bindparam(":task_desc", $task_desc);
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e -> getMessage();
       }    
    }
    public function completeTask($taskid)
    {
        try
        {
            $stmt = $this -> db -> prepare("SELECT * FROM tasks WHERE taskid = :taskid");
            $stmt->bindparam(":taskid", $taskid);
            $stmt->execute();
            $taskRow = $stmt -> fetch(PDO::FETCH_ASSOC);
            $groupid = $taskRow['groupid'];
            if($groupid)
              $add = "OR groupid = :groupid";
            else
              $add = "";
             $stmt = $this->db->prepare("UPDATE tasks SET status = 1 WHERE taskid = :taskid $add");
             $stmt->bindparam(":taskid", $taskid);
             if($groupid)
                $stmt -> bindparam(":groupid", $groupid);
             $stmt->execute();

           return $stmt; 
        }
        catch(PDOException $e)
        {
           echo $e -> getMessage();
        }
    }
    public function deleteTask($taskid)
    {
       try
       {
           $stmt = $this->db->prepare("DELETE FROM tasks WHERE taskid = :taskid");
           $stmt->bindparam(":taskid", $taskid);
           $stmt->execute();
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e -> getMessage();
       }    
    }
    public function getCurrentTask($studid)
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks WHERE stud_id=:studid AND status = 0");
        $stmt->bindparam(":studid", $studid);
        $stmt->execute();
        $taskRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $taskRow;
    }
    public function getAllTasks()
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks");
        $stmt->execute();
        $taskRows=$stmt->fetchAll();
        return $taskRows;
    }
}
?>