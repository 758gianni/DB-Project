<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $table = $_POST['table'];
        $result = $conn->query("SELECT * FROM $table");

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";

                foreach ($row as $value) {
                    echo "<td class='px-6 py-2 whitespace-nowrap first:pl-0'>";
                        echo "<div class='col-span-4 flex items-center'>";
                            echo "<p class='text-sm text-gray-600'>$value</p>";
                        echo "</div>";
                    echo "</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "Invalid table name.";
        }
    }
?>