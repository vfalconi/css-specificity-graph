<?php

	if (!isset($_GET['included']))
	{
		$included = true;
	}
	else
	{
		header('Content-type: text/plain');
		$included = false;
	}

	require_once('spec-calc.php');

	$css_contents = file_get_contents('styles.min.css');

	/* 		
		Remove any sourcemaps at the end of the file... because you're including 
		sourcemaps, right?
	*/
	$css_contents = preg_replace('/\/\*([A-Za-z0-9\-\=\.\#\s\!\|\/]+)\*\//', '', $css_contents);

	// Remove comments
	// From: http://stackoverflow.com/questions/1581049/preg-replace-out-css-comments
	$regex = array(
		"`^([\t\s]+)`ism"=>'',
		"`^\/\*(.+?)\*\/`ism"=>"",
		"`([\n\A;]+)\/\*(.+?)\*\/`ism"=>"$1",
		"`([\n\A;\s]+)//(.+?)[\n\r]`ism"=>"$1\n",
		"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism"=>"\n"
	);
	$css_contents = preg_replace(array_keys($regex),$regex,$css_contents);

	/*
	*
	*	Find and remove all media query blocks from the CSS to be graphed
	* From http://stackoverflow.com/questions/14145620/regular-expression-for-media-queries-in-css
	*
	*/

	$mediaBlocks = array();

	$start = 0;
	while (($start = strpos($css_contents, "@", $start)) !== false)
	{
		// stack to manage brackets
		$s = array();

		// get the first opening bracket
		$i = strpos($css_contents, "{", $start);

		// if $i is false, then there is probably a css syntax error
		if ($i !== false)
		{
			// push bracket onto stack
			array_push($s, $css_contents[$i]);

			// move past first bracket
			$i++;

		while (!empty($s))
		{
			// if the character is an opening bracket, push it onto the stack, otherwise pop the stack
			if ($css_contents[$i] == "{")
			{
				array_push($s, "{");
			}
			elseif ($css_contents[$i] == "}")
			{
				array_pop($s);
			}

			$i++;
		}

		// cut the media block out of the css and store
		$mediaBlocks[] = substr($css_contents, $start, ($i - $start));

		// set the new $start to the end of the block
		$start = $i;
		}
	}

	foreach ($mediaBlocks as $key => $block)
	{
		$css_contents = str_replace($block, '', $css_contents);
	}

	/*
	*
	* get selectors by definition
	* from: http://www.bewebmaster.com/228.php
	*
	*/

	$tok = strtok($css_contents, "{}");

	$sarray = array();

	$spos = 0;

	while ($tok !== false)
	{
		$sarray[$spos] = $tok;
		$spos++;
		$tok = strtok('{}');
	}

	$size = count($sarray);

	$selectors = array();
	$styles = array();

	$npos = 0;
	$stl = 0;

	for ($i = 0; $i < $size; $i++)
	{
		if ($i % 2 == 0)
		{
			$selectors[$npos] = $sarray[$i];
			$npos++;
		}
		else
		{
			$sstyles[$stl] = $sarray[$i];
			$stl++;
		}
	}

	/*
	*
	* seperate each selector out, keeping it's position in the cascade associated with it
	*
	*/

	$chart_data = array();

	foreach ($selectors as $position => $group)
	{
		$g_selectors = explode(',', $group);

		foreach ($g_selectors as $k => $v)
		{
			if (trim($v) != '')
			{
				$chart_data[] = array(
					'position' => $position + 1,
					'selector' => $v,
					'score' => calculateSpecificity($v)
				);
			}
		}
	}

	if ($included == false)
	{
		echo json_encode($chart_data);
	}
	

	// TODO: account for !important flags -- include css definitions in chart data?	
	
?>