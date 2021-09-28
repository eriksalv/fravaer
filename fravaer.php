<!DOCTYPE html>
<html>
	<head>
        <!-- Digital lyd, Opphavsrett (231-235), Internett (www, html, tcp-ip, http)-->
		<title>Fravær og Årsaker</title>
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
        
        //henter og sender dataene fra skjemaet lenger nede
        if(isset($_POST["send_fravaer"])) {
			
			$dato = $_POST["dato"];
			$antall_timer = $_POST["antall_timer"];
            $aarsak_id = $_POST["lstAarsak_id"]; 
            $elevnummer = $_POST["lstElevnummer"];
			
			$sql = "INSERT INTO fravaer (elevnummer, aarsak_id, dato, antall_timer)
					VALUES ('$elevnummer', '$aarsak_id', '$dato', '$antall_timer')";
					
			if($tilkobling->query($sql)) { ?>
			
				<div class='alert'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Spørringen ble gjennomført. Fraværet er registrert</p>
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
        elseif(isset($_POST["send_aarsak"])) {
			
			$aarsak_tekst = $_POST["aarsak_tekst"];
			
			$sql = "INSERT INTO aarsak (aarsak_tekst)
					VALUES ('$aarsak_tekst')";
					
			if($tilkobling->query($sql)) { ?>
			
				<div class='alert'>
					<span onclick="this.parentElement.style.display='none';">&times;</span>
					<p>Spørringen ble gjennomført. Årsaken er lagt inn</p>
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
				<a href="index.php">Gå Tilbake</a>
            </nav>
            <main>
                <!-- lager først et skjema for å registrere fravær -->
                <div id="insert">
                    <h2>Registrer Fravær</h2>
                    <form method="POST">
                        <label for="dato">Dato (ÅÅÅÅ-MM-DD)</label>
                        <input type="text" name="dato" placeholder="Dato...">

                        <label for="antall_timer">Antall timer</label>
                        <input type="number" name="antall_timer" placeholder="Antall timer...">

                        <?php
                            //henter data fra aarsak-tabellen og lager en dropdown-meny for å velge årsak
                            $sql1 = "SELECT * FROM aarsak";
                            $datasett1 = $tilkobling->query($sql1);

                            echo "<label for='lstAarsak_id'>Årsak</label>";
                            echo "<select name='lstAarsak_id' id='lstAarsak_id'>";

                            while($rad1 = $datasett1->fetch_assoc()) {
                                $aarsak_tekst = $rad1["aarsak_tekst"];
                                $aarsak_id = $rad1["aarsak_id"];

                                echo "<option value='$aarsak_id'>$aarsak_tekst</option>";
                            }
                            echo "</select>";
    
                            //henter data fra elev-tabellen og lager en dropdown-meny for å velge elev
                            $sql2 = "SELECT * FROM elev";
                            $datasett2 = $tilkobling->query($sql2);

                            echo "<label for='lstElevnummer'>Elev</label>";
                            echo "<select name='lstElevnummer' id='lstElevnummer'>";

                            while($rad2 = $datasett2->fetch_assoc()) {
                                $fornavn = $rad2["fornavn"];
                                $etternavn = $rad2["etternavn"];
                                $elevnummer = $rad2["elevnummer"];

                                echo "<option value='$elevnummer'>$fornavn $etternavn</option>";
                            }
                            echo "</select>";
                        ?>
                        <input type="submit" name="send_fravaer" value="Send inn">
                    </form>
                </div>
                <!-- Lager nå et nytt skjema for å registrere nye årsaker -->
                <div id="aarsak">
                    <h2>Legg inn en ny Årsak</h2>
                    <form method="POST">
                        <label for="aarsak_tekst">Årsak</label>
                        <input type="text" name="aarsak_tekst" placeholder="Årsak...">

                        <input type="submit" name="send_aarsak" value="Send inn">
                    </form>
                </div>
            </main>
		</div>
	
	
	
	</body>
	
</html>
	