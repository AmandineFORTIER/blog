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
		<title>Blog Amandine</title>
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
						<li><a href="#" class="active">Acceuil</a></li>
						<li><a href="#">Sujets</a></li>
						<li><a href="#">Recherche approfondie</a></li>
						<li><a href="datas.php">Gestion des données</a></li>
						<li><a href="elements.html">Elements</a></li>
					</ul>
				</nav>
			</div>
			</header>



		<!-- Banner -->
			<section class="banner full">
				<article>
					<img src="images/slide01.jpg" alt="" />
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
                        <?php	//Liste déroulante
                            $sql = "SELECT * from Article";
                            $result = $conn->query($sql);

                            if (!$result)
                            {
                                echo "Lecture impossible";
                            }
                            else
                            {
                                while($row = $result->fetch_assoc()) 
                                {
                                    echo "<div>";
                                    echo "<div class='box'>";
                                    echo "<div class='image fit'>";
                                    echo "<img src='images/upload/".$row["img_path"]."' alt='' />";
                                    echo "</div>";
                                    echo "<div class='content'>";
                                    echo "<header class='align-center'>";
                                    echo "<p>".$row["author"]." | ".$row["label"]."</p>";
                                    echo "<h2>".$row["title"]."</h2>";
                                    echo "</header>";
                                    echo "<p>".$row["descrip"]."</p>";
                                    echo "<footer class='align-center'>";
                                    echo "<a href='articles/".$row["content"]."' class='button alt'>Learn More</a>";
                                    echo "</footer>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            }
                            $conn->close();
                        ?>
					</div>
				</div>
			</section>

		<!-- Two -->
			<section id="two" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>Nam vel ante sit amet libero scelerisque facilisis eleifend vitae urna</p>
						<h2>Présentation Amandine</h2>
					</header>
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