<?php

	function calculateSpecificity($selector)
	{
		$result ='';
		$score = array(
			'a' => 0,
			'b' => 0,
			'c' => 0
		);

		$parts = array();

		/*
		*	This array follows the assumption of @keeganstreet's JS module, 'that selectors
			matching the preceding regular expressions have been removed'.
		*/

		$selectorTypes = array(
			'attribute' => array(
				'pattern' => '/(\[[^\]]+\])/',
				'type' => 'b'
			),
			'id' => array(
				'pattern' => '/(#[^\s\+>~\.\[:]+)/',
				'type' => 'a'
			),
			'class' => array(
				'pattern' => '/(\.[^\s\+>~\.\[:]+)/',
				'type' => 'b'
			),
			'pseudoElement' => array(
				'pattern' => '/(::[^\s\+>~\.\[:]+|:first-line|:first-letter|:before|:after)/',
				'type' => 'c'
			),
			// A regex for pseudo classes with brackets - :nth-child(), :nth-last-child(), :nth-of-type(), :nth-last-type(), :lang()
			'pseudoClassWithBrackets' => array(
				'pattern' => '/(:[\w-]+\([^\)]*\))/',
				'type' => 'b'
			),
			// A regex for other pseudo classes, which don't have brackets
			'pseudoClass' => array(
				'pattern' => '/(:[^\s\+>~\.\[:]+)/',
				'type' => 'b'
			),
			'element' => array(
				'pattern' => '/([^\s\+>~\.\[:]+)/',
				'type' => 'c'
			),
		);

		// Remove `:not()` pseudo-class but leave the selector it negated
		$selector = preg_replace('/:not\(([^\)]*)\)/', '$1', $selector);

		$count = 0;
		foreach ($selectorTypes as $type => $data)
		{
			$count = preg_match_all($data['pattern'], $selector, $matches);

			for ($i = 0; $i < $count; $i++)
			{
				$score[$data['type']]++;
				$selector = trim(preg_replace($data['pattern'], '', $selector, 1));
			}
		}

		return $score['a'] . $score['b'] . $score['c'];
	}
?>