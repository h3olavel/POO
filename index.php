<?php

include 'conexion.php';

$pdo=new Conexion();

if($_SERVER['REQUEST_METHOD']=='GET')
{
	if(isset($_GET['id']))
	{
		$sql=$pdo->prepare("SELECT * FROM usuarios WHERE :id");
		$sql->bindValue(':id',$_GET['id']);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header ("http/1.1 200 OK");
		echo json_encode($sql->fetchAll());
		exit;
	}
	else
	{
		$sql=$pdo->prepare("SELECT * FROM usuarios");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header ("http/1.1 200 OK");
		echo json_encode($sql->fetchAll());
		exit;
	}
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$sql="INSERT INTO usuarios (id, nombre, email) VALUES (:id,:nombre,:email)";
	$stmt=$pdo->prepare($sql);	
	$stmt->bindValue(':id',$_POST['id']);
	$stmt->bindValue(':nombre',$_POST['nombre']);
	$stmt->bindValue(':email',$_POST['email']);

	$stmt->execute();
	$idPost=$pdo->lastInsertId();
	
	if($idPost)
	{
		header ("http/1.1 200 OK");
		echo json_encode("complet");
		exit;
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
		$sql = "DELETE FROM usuarios WHERE id = :id";
		
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		
		header("HTTP/1.1 200 OK");
		echo json_encode("complet");
		exit;
	} else {
		header("HTTP/1.1 400 Bad Request");
		echo json_encode("ID no proporcionado");
		exit;
	}
}


/*header ("HTTP/1.1 400 Bad REQUEST_METHOD")*/
?>
