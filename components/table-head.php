<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table'];
    $result = $conn->query("SELECT * FROM $table");

    if ($result) {
        echo '<thead class="border-b border-neutral-200">';
            echo "<tr>";
        
            while ($field = $result->fetch_field()) {
                echo '<th class="px-6 py-2 whitespace-nowrap first:pl-0">';
                    echo '<div class="flex items-center">';
                        echo '<p class="font-medium text-base text-neutral-600 uppercase">' . $field->name . '</p>';
                    echo '</div>';
                echo '</th>';
            }

            echo "</tr>";
        echo "</thead>";
    } else {
        echo "Invalid table name.";
    }
}
?>