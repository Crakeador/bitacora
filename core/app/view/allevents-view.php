<?php
include_once('../../core/controller/Database.php');

var_dump($_POST);
if(isset($_POST["action"])) //show all events
{
    if($_POST["action"] == "add") // add new event
    {
      $connection = mysqli_connect('localhost','root','','inventiolite') or die(mysqli_error($connection));
      mysqli_query($connection,"INSERT INTO evenement (idcompany, title, start, end, created_at)
                  VALUES (
                  '".mysqli_real_escape_string($connection, $_POST["title"])."',
                  '".mysqli_real_escape_string($connection, date('Y-m-d H:i:s',strtotime($_POST["start"])))."',
                  '".mysqli_real_escape_string($connection, date('Y-m-d H:i:s',strtotime($_POST["end"])))."'");
      header('Content-Type: application/json');
      echo '{"id":"'.mysqli_insert_id($connection).'"}';
      exit;

    	//print "<script>window.location='?view=horario';</script>";
    }
    elseif($_POST["action"] == "update")  // update event
    {
      $events = EventoData::getById($_POST["id"]);
      $events->title = strtoupper($_POST["title"]);
    	$events->start = date("Y-m-d H:i:s", strtotime($_POST["start"]));
      $events->end = date("Y-m-d H:i:s", strtotime($_POST["end"]));
      $user->update();
      // print "<script>window.location='?view=horario';</script>";

    }
    elseif($_POST["action"] == "delete")  // remove event
    {
      $operation = EventoData::getById($_POST["id"]);
      $operation->del();

      print "<script>window.location='index.php?view=$_GET[ref]&product_id=$_GET[pid]';</script>";
    }
}
