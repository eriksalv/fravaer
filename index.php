<!DOCTYPE html>
<html>
	<head>
        <!-- Digital lyd, Opphavsrett (231-235), Internett (www, html, tcp-ip, http)-->
		<title>Fravær</title>
		<meta charset='utf-8'>
        <link rel="stylesheet" href="fravaer.css">
	
	</head>
	
	<body>
		<?php
		//vi starter med å opprette en kobling mot databasen
		$tilkobling = mysqli_connect("localhost", "root", "", "fravaer"); 
		
		//skjekk om koblingen fungerer
		if ($tilkobling->connect_error){
			die("Noe gikk galt: " . $tilkobling -> connect_error);
		}
		else {
		//	echo "Koblingen virker perfekt. </br>";
		}
			
        $tilkobling->set_charset("utf8");
        
        //Legger inn dataene som blir fylt inn i "Legg inn ny elev" skjemaet
        if(isset($_POST["sendinn_elev"])) {
			
			$fornavn = $_POST["fornavn"];
			$etternavn = $_POST["etternavn"]; 
			
			$sql = "INSERT INTO elev (fornavn, etternavn)
					VALUES ('$fornavn', '$etternavn')";
            
            //Notifikasjon som forteller om dataene er lagt inn eller ikke
			if($tilkobling->query($sql)) { ?>
			
				<div class='alert'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Spørringen ble gjennomført. <?php echo "$fornavn $etternavn er lagt inn i databasen";?></p>
				</div>
			<?php
			
			} else { ?>
			
				<div class='alert2'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Noe gikk galt</p>
				</div>
			<?php
            }
        }
        //henter dataene, som er nødvendig for å slette riktig fravær, fra slette-skjemaet lenger nede
        elseif(isset($_POST["slett_elev"])) {
            $slett_elev = $_POST["slett_elev"];
            $slett_aarsak = $_POST["slett_aarsak"];
				
			//Lager SQL-spørring som sletter riktig fravær. Det er viktig at både elevnummer og aarsak_id er spesifisert.
			$sql = "DELETE FROM fravaer WHERE elevnummer='$slett_elev' AND aarsak_id='$slett_aarsak'";
			
			if($tilkobling->query($sql)) { ?>			
				<div class='alert'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Fraværet har blitt slettet</p>
				</div>
			<?php
			} else { ?>			
				<div class='alert2'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Noe gikk galt</p>
				</div>
			<?php
			}
        }
		?>

        <div id="wrapper">
            <header>
                <div class="img"></div>
            </header>
            <nav>
                <a href="fravaer.php">Registrer Fravær eller legg inn nye Årsaker</a>
            </nav>
            <main>
                 <!-- Jeg lager et skjema for å legge til nye elever på samme side -->
                 <div id="insert">
                    <h2>Legg til en ny elev</h2>
                    <form class="insert" method="POST">
                        <label for="fornavn">Fornavn</label>
                        <input type="text" name="fornavn" placeholder="Elevens fornavn...">

                        <label for="etternavn">Etternavn</label>
                        <input type="text" name="etternavn" placeholder="Elevens etternavn...">

                        <input type="submit" name="sendinn_elev" value="Send inn">
                    </form>
                </div>
                <div id="main">
                <?php
                    //henter ut data fra elev-tabellen, og starter en while-løkke for å vise dataene
                    $sql1 = "SELECT fornavn, etternavn, elev.elevnummer, SUM(antall_timer) AS total
                            FROM elev, fravaer
                            WHERE elev.elevnummer = fravaer.elevnummer
                            GROUP BY elev.elevnummer";
                    $resultat1 = $tilkobling->query($sql1);

                    while($rad1 = $resultat1->fetch_assoc()) {
                        $fornavn = $rad1["fornavn"];
                        $etternavn = $rad1["etternavn"];
                        $elevnummer = $rad1["elevnummer"];
                        $totalfravaer = $rad1["total"];
                        
                        //starter en div som skal inneholde alt som tilhører én elev
                        echo "<div class='boks1'>";
                        echo "<div class='dropdown'>";
                        echo "<h3>$fornavn $etternavn</h3>";
                        echo "<div class='sum'>Totalt fravær: $totalfravaer time(r)</div>";
                        echo "</div>";

                        /*Setter opp en ny sql-spørring for å få ut fraværs-dataen som skal brukes i en ny while-løkke.
                        Jeg bruker elevnummer-variabelen som jeg hentet fra forrige sql-spørring, til å bare få data for den eleven*/
                        $sql2 = "SELECT elevnummer, fravaer.aarsak_id, aarsak_tekst, dato, antall_timer
                                FROM fravaer, aarsak
                                WHERE fravaer.aarsak_id = aarsak.aarsak_id AND elevnummer = $elevnummer";
                        $resultat2 = $tilkobling->query($sql2);

                        //Jeg setter opp en ny while-løkke på innsiden av den andre løkken
                        while($rad2 = $resultat2->fetch_assoc()) {
                            $elevnummer = $rad2["elevnummer"];
                            $aarsak_id = $rad2["aarsak_id"];
                            $aarsak_tekst = $rad2["aarsak_tekst"];
                            $dato = $rad2["dato"];
                            $antall_timer = $rad2["antall_timer"];

                            /*Jeg lager nå et skjema som skal kunne slette fraværet.
                            Samtidig skal fraværet komme opp når man trykker på en elev (dette gjør jeg i css)*/
                            echo "<div class='skjult'>";
                            echo "<form method='POST'>";
                            echo "<div>";
                            echo "<label for='slett_elev'>$antall_timer time(r) $dato</label>";
                            echo "<input type='hidden' name='slett_elev' value='$elevnummer'>";
                            echo "<label for='slett_aarsak'>Årsak: $aarsak_tekst</label>";
                            echo "<input type='hidden' name='slett_aarsak' value='$aarsak_id'>";
                            echo "<input type='submit' value='slett'>";
                            echo "</div>";
                            echo "</form>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </main>
        </div>
	
	
	
	</body>
	
</html>
	