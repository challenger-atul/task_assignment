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
            $groupid = $this -> getgroupid($taskid);
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
          $groupid = $this -> getgroupid($taskid);
          if($groupid)
            $add = "OR groupid = :groupid";
          else
            $add = "";
           $stmt = $this->db->prepare("DELETE FROM tasks WHERE taskid = :taskid $add");
           $stmt->bindparam(":taskid", $taskid);
           if($groupid)
              $stmt -> bindparam(":groupid", $groupid);
           $stmt->execute();
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
        if($stmt -> rowCount() > 0)
          return $taskRow;
        else
          return null;
    }
    public function getAllTasks()
    {
        $stmt = $this->db->prepare("SELECT * FROM tasks");
        $stmt->execute();
        $taskRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $taskRows;
    }
    public function getUserList()
    {
        $stmt = $this->db->prepare("SELECT user_id, user_fname, user_lname FROM users");
        $stmt->execute();
        $taskRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $taskRows;
    }
    public function getMyTasks($profid)
    {
      $stmt = $this->db->prepare("SELECT * FROM tasks WHERE prof_id=:profid  ORDER BY taskid ASC");
      $stmt->bindparam(":profid", $profid);
      $stmt -> execute();
      $taskRows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
      return $taskRows;
    }
    public function getgroupid($taskid)
    {
      try
      {
        $stmt = $this -> db -> prepare("SELECT * FROM tasks WHERE taskid = :taskid");
          $stmt->bindparam(":taskid", $taskid);
          $stmt->execute();
          $taskRow = $stmt -> fetch(PDO::FETCH_ASSOC);
          $groupid = $taskRow['groupid'];
          return $groupid;
      }
      catch(PDOException $e)
      {
        echo $e -> getMessage();
      } 
    }

}
?>