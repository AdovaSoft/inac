<?php

// Create connection
$conn = new mysqli($_SERVER['HOST'], $_SERVER['USER'], $_SERVER['PASS'], $_SERVER['DBASE']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM party";
$result = $conn->query($sql);
$dump_arr = [
    [
        'idparty' => 0,
        'title' => 'Office CASH Balance',
        'medium' => 0,
        'balance' => 0.0
    ], [
        'idparty' => 0,
        'title' => 'Office BANK Balance',
        'medium' => 1,
        'balance' => 0.0
    ]
];

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($dump_arr, [
            'idparty' => $row['idparty'],
            'title' => $row['name'] . '\'s CASH Balance',
            'medium' => 0,
            'balance' => 0.0
        ], [
            'idparty' => $row['idparty'],
            'title' => $row['name'] . '\'s BANK Balance',
            'medium' => 1,
            'balance' => 0.0
        ]);
    }
    echo "<pre>";
    foreach ($dump_arr as $item) {
        echo "\"" . $item['idparty'] . "\",\"" . $item['title'] . "\",\"".  $item['medium'] . "\",\"" . $item['balance'] . "\",\n";
    }
} else {
    echo "0 results";
}
$conn->close();
?> 