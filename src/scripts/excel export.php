<?php
// Clear any previous output
ob_end_clean();
// I assume you already have your $result
$num_fields = mysql_num_fields($result);

// Fetch MySQL result headers
$headers = array();
$headers[] = "[Row]";
for ($i = 0; $i < $num_fields; $i++) {
    $headers[] = strtoupper(mysql_field_name($result , $i));
}

// Filename with current date
$current_date = date("y/m/d");
$filename = "MyFileName" . $current_date . ".csv";

// Open php output stream and write headers
$fp = fopen('php://output', 'w');
if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Pragma: no-cache');
    header('Expires: 0');
    echo "Title of Your CSV File\n\n";
    // Write mysql headers to csv
    fputcsv($fp, $headers);
    $row_tally = 0;
    // Write mysql rows to csv
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $row_tally = $row_tally + 1;
        echo $row_tally.",";
        fputcsv($fp, array_values($row));
    }
    die;
}
?>