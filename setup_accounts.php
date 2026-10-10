
<?php
require "db.php";

$accounts = [
    ["admin@example.com", "BlueSky@2026", "admin"],
    ["staff@example.com", "BlueSky@2026", "staff"]
];

$sql = "INSERT INTO users (email, password, role)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        password = VALUES(password),
        role = VALUES(role)";

$stmt = $conn->prepare($sql);

foreach ($accounts as $account) {
    $hashedPassword = password_hash(
        $account[1],
        PASSWORD_DEFAULT
    );

    $stmt->execute([
        $account[0],
        $hashedPassword,
        $account[2]
    ]);
}

echo "Accounts and password hashes updated successfully!";
?>
