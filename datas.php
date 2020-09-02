<!DOCTYPE HTML>
<!--
	Hielo by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "amandine";
	$dbname = "articles";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>

<html>
	<head>
		<title>Blog Amanidne</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

        <!-- Header -->
        <header id="header" class="alt">
        <!-- Nav -->
        <div id="menu">
            <nav id = "sidebar">
                <ul id="links">
                    <li><a href="index.php">Acceuil</a></li>
                    <li><a href="#">Sujets</a></li>
                    <li><a href="#">Recherche approfondie</a></li>
                    <li><a href="#" class="active">Gestion des données</a></li>
                    <li><a href="elements.html">Elements</a></li>
                </ul>
            </nav>
        </div>
        </header>

		<!-- Banner -->
		<section class="banner full">
				<article>
					<img src="images/bg.jpg" alt="" />
					<div class="inner">
						<header>
							<p>A free responsive web site template by <a href="https://templated.co">TEMPLATED</a></p>
							<h2>Hielo</h2>
						</header>
					</div>
				</article>
			</section>
		<!-- One -->
		<section id="one" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">
						<div>
							<div id="form">
								<h1 id="titleForm">Création d'un libellé</h1>
								<form id = "subform" name = "subform" method="post">
									<div><label for="libName">Libelle</label>
									<input type="text" placeholder="Libelle" id="libName" name="libName" required></div>
									</br>
									<div><label for="category">Catgeory</label>
									<input type="text" placeholder="Category" id="category" name="category" required></div>
									</br>
									<input type="submit" value="Creer"/>
								</form>
							</div>
							<?php //Create libelle
										if(isset($_POST['libName']) && trim($_POST['libName']) != '')
										{
											if(isset($_POST['category']) && trim($_POST['category']) != '')
											{
												$stmt = $conn->prepare("INSERT INTO Libelle (label, category) VALUES (?, ?)");
												$stmt->bind_param("ss", $label, $catego);
												
												$label = $_POST['libName'];
												$catego = $_POST['category'];
												$stmt->execute();

												$stmt->close();
											}
										}
									?>
							</br>
							</br>
							<div class="inner" id="form">
								<header>
								<h1 id="titleForm">Création d'un article</h1>
									<form enctype="multipart/form-data" method="post">
										<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
										<div>
											<label for="titre">Titre: </label>
											<input type="text" name="titre" required><br>
										</div><div>
											<label for="description">Description: </label>
											<input type="text" name="description" id="description" required><br>
										</div><div>
											<label for="image">Chemin de l'image : </label>
											<input type="file" name="image"><br>
										</div><br><div>
											<label for="content">Article: </label>
											<input type="file" name="content" required><br>
										</div><br><div>
											<label for="libelle">Libellés: </label>
											<select size=1 name="labels">
											<?php	//Liste déroulante
												$sql = "SELECT label from Libelle";
												$rst = $conn->query($sql);

												if (!$rst)
												{
													echo "Lecture impossible";
												}
												else
												{
													while($row = $rst->fetch_assoc()) 
													{
														$lib=$row["label"];
														echo "<option value= '$lib'> $lib</option><br>";
													}
												}
											?>
											</select>
										</div><br><div>
											<label for="author">Autheur: </label>
											<input type="text" name="author" required><br>
										</div>
										</br><input type="submit"/>
									</form>
									<?php	
										//Image upload
										if(isset($_FILES['image']) && trim($_FILES['image']['name']) != '')
										{
											$uploadFolder = 'images/upload/';
											$fileName = basename($_FILES['image']['name']);
											$maxSize = 2000000;
											$size = filesize($_FILES['image']['tmp_name']);
											$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.JPG', '.JPEG');
											$extension = strrchr($_FILES['image']['name'], '.'); 
											//Début des vérifications de sécurité...
											if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
											{
												$erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
											}
											if($size>$maxSize)
											{
												$erreur = 'Le fichier est trop gros...';
											}
											if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
											{
												//On formate le nom du fichier ici...
												$fileName = strtr($fileName, 
													'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
													'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
												$fileName = preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);

												$temp = explode(".", $fileName);
												$fileName = round(microtime(true)) . '.' . end($temp);

												if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadFolder . $fileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
												{
													echo 'Upload de l\'image effectué avec succès !';
												}
												else //Sinon (la fonction renvoie FALSE).
												{
													echo 'Echec de l\'upload de \'image !';
												}
											}
											else
											{
												echo $erreur;
											}

											//UPLOAD ARTICLE PDF
											if(isset($_FILES['content']) && trim($_FILES['content']['name']) != '')
											{
												$uploadFolder = 'articles/';
												$pdfName = basename($_FILES['content']['name']);
												$maxSize = 5000000;
												$size = filesize($_FILES['content']['tmp_name']);
												$extensions = array('.pdf');
												$extension = strrchr($_FILES['content']['name'], '.'); 
												//Début des vérifications de sécurité...
												if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
												{
													$erreur = 'Vous devez uploader un fichier de type pdf';
												}
												if($size>$maxSize)
												{
													$erreur = 'Le fichier est trop gros...';
												}
												if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
												{
													//On formate le nom du fichier ici...
													$pdfName = strtr($pdfName, 
														'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
														'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
													$pdfName = preg_replace('/([^.a-z0-9]+)/i', '-', $pdfName);
	
													$temp = explode(".", $pdfName);
													$pdfName = round(microtime(true)) . '.' . end($temp);
	
													if(move_uploaded_file($_FILES['content']['tmp_name'], $uploadFolder . $pdfName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
													{
														echo 'Upload du pdf effectué avec succès !';
													}
													else //Sinon (la fonction renvoie FALSE).
													{
														echo 'Echec de l\'upload du pdf !';
													}
												}
												else
												{
													echo $erreur;
												}
											}
										}
										// prepare and bind

										if(isset($_POST['titre']) && trim($_POST['titre']) != '')
										{
											$stmt = $conn->prepare("INSERT INTO Article (title, descrip, label, img_path, content, author, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?)");
											$stmt->bind_param("sssssss", $title, $descrip, $label, $img_path, $content, $author, $date_creation);

											// set parameters and execute
											$title = $_POST["titre"];
											$descrip = $_POST["description"];
											$label = $_POST["labels"];
											$img_path = $fileName;
											$content = $pdfName; 
											$author = $_POST["author"];
											$date_creation = date('Y-m-d');

											$stmt->execute();
											$stmt->close();
										}
									?>
									<?php
										$conn->close();
									?>
								</header>
							</div>
					</div>
				</div>
			</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://www.facebook.com/Amandinee.FORTIER" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.instagram.com/amandine.fortier/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
					</ul>
				</div>
				<div class="copyright">
					&copy; Untitled. All rights reserved.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>