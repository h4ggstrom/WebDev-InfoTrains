<article>
	<h3>Select language</h3>
	<a href="?lang=fr&amp;style=<?php echo $Style; ?>">
		<img src="image/francais.jpg" alt="francais" class="lang"/>
	</a>
	<a href="?lang=en&amp;style=<?php echo $Style; ?>">
		<img src="image/anglais.jpg" alt="english" class="lang"/>
	</a>
</article>

<article>
    <h3>Enter a URL:</h3>
    
    <form method="post">
        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required="required"/>
        <button type="submit">Extract</button>
    </form>

    <?php
    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the URL from the form
        $url = $_POST['url'];

        // Call the function to extract information
        $result = extraireInformationsURL($url);

        // Display the results in an HTML table
        echo '<h2>Results:</h2>';
        echo "<table class=\"td8\">\n";
        foreach ($result as $key => $value) {
            echo "<tr>\n";
            echo '<th>' . htmlspecialchars($key) . "</th>\n";
            echo '<td>' . htmlspecialchars($value) . "</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
    }
    ?>
</article>

<article>
	<h3>Exercice 2</h3>
    <?php
        // Get the octal value from the URL
        $octalFromURL = isset($_GET['octal']) ? $_GET['octal'] : '';

        // Use the function with the specified octal value
        $result = octalToRwx($octalFromURL);

        // Display the result
        echo "<p>Octal Value: $octalFromURL</p>";
        echo "<p>Corresponding Permissions: $result</p>\n";
    ?>
    
	<p>Press 'Test' to try.</p>
    <a href="?octal=751">test</a>
</article>

	<article>
			<h3>table</h3>
			
			<?php
			
				$size = isset($_GET['size']) ? intval($_GET['size']) : 10;

				// Appeler la fonction avec la taille spécifiée
				echo multiplicationTable($size,$size);
			
			?>
			
			<p>Press 'Test' to try.</p>
			<a href="?size=12" >test</a>
		
		</article>