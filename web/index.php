<?php

	if (isset($_POST['submit'])) {
		define('XML_FILE', '../res/values/strings.xml');

		$xmlData = file_get_contents(XML_FILE);

		$appUrl = $_POST['app-url'];
		$appName = $_POST['app-name'];

		$dom = new DOMDocument();
		$dom->loadXML($xmlData);
		
		foreach ($dom->documentElement->childNodes as $node) {
			if ($node->nodeType == 1 ) {
				if ($node->nodeValue == 'APP_NAME') {
					$node->nodeValue = $appName;
				}
				if ($node->nodeValue == 'APP_URL') {
					$node->nodeValue = $appUrl;
				}
			}
		}

		file_put_contents(XML_FILE, $dom->saveXML());

		$cmd = '../release.sh';

		shell_exec($cmd);

		$xmlData = file_get_contents(XML_FILE);

		$dom->loadXML($xmlData);
		foreach ($dom->documentElement->childNodes as $node) {
			if ($node->nodeType == 1 ) {
				if ($node->nodeValue == $appName) {
					$node->nodeValue = 'APP_NAME';
				}
				if ($node->nodeValue == $appUrl) {
					$node->nodeValue = 'APP_URL';
				}
			}
		}

		file_put_contents(XML_FILE, $dom->saveXML());

		$file = '../bin/Nebula-release.apk';

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}

	} else {
?>
<!DOCTYPE html>
<html>
<head>
	<title>Nebulae</title>
</head>
<body>
	<div id="form_container">
		<h1>Nebula</h1>
		<form method="post" action="">						
			<label class="description" for="app-url">Website </label>
			<input id="app-url" name="app-url" class="element text medium" type="text" maxlength="255" value=""/> 
			<p class="guidelines" id="guide_1">
				<small>Please enter the URL of your website or application</small>
			</p> 
			<label class="description" for="app-name">Application Name </label>
			<input id="app-name" name="app-name" class="element text medium" type="text" maxlength="255" value=""/> 
			<p class="guidelines" id="guide_2">
				<small>Please enter the desired name for your app.</small>
			</p>
			<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</form>	
	</div>
</body>
</html>
<?php
	}
?>

	