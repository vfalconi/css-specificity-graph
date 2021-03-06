<?php
	require_once('analyze-css.php');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CSS Specificity Graph</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./assets/styles.css" rel="stylesheet" />
</head>

<body>
	<div class="graph-container">
		<svg class="chart"></svg>
	</div>
	<div class="table-container">
		<table id="specTable" class="spec-table">
			<thead>
				<tr>
					<th class="spec-table-header">Position</th>
					<th class="spec-table-header">Selector</th>
					<th class="spec-table-header">Score</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($chart_data as $index => $row_data)
					{
						echo '<tr data-selector-position="' . $row_data['position'] . '" data-selector-selector="' . $row_data['selector'] . '" data-selector-score="' . $row_data['score'] . '">
							<td class="spec-table-cell">' . $row_data['position'] . '</td>
							<td class="spec-table-cell">' . $row_data['selector'] . '</td>
							<td class="spec-table-cell">' . $row_data['score'] . '</td>
						</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<script src="./assets/lib/d3/d3.v3.min.js"></script>
	<script src="./assets/scripts.js"></script>
</body>
</html>
