<?php
$title = 'Annual Parts Expenses | DB Project';
require_once __DIR__ . '/db.php';

$tableTitle = 'Annual Expenses';
$tableColumns = [];
$tableRows = [];
$formSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$errorMessage = '';

if ($formSubmitted) {
    $start = (int)($_POST['start_year'] ?? 0);
    $end = (int)($_POST['end_year'] ?? 0);

    if ($start <= 0 || $end <= 0 || $start > $end) {
        $errorMessage = 'Enter a valid year range.';
    } else {
        $sql = "
            SELECT YEAR(o.`when`) AS year, SUM(op.qty * p.price) AS total
            FROM orders o
            JOIN order_part op ON o._id = op.order_id
            JOIN parts p ON op.part_id = p._id
            WHERE YEAR(o.`when`) BETWEEN ? AND ?
            GROUP BY YEAR(o.`when`)
            ORDER BY year
        ";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ii', $start, $end);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $tableRows[] = [
                    $row['year'],
                    '$' . number_format((float)$row['total'], 2),
                ];
            }

            $tableColumns = ['Year', 'Total'];
            $stmt->close();
        } else {
            $errorMessage = 'Unable to prepare the annual expenses query.';
        }
    }
}
?>
<?php include 'components/head.php'; ?>

<body class="h-screen flex flex-row bg-neutral-50 overflow-hidden">
    <?php include 'components/sidebar.php'; ?>

    <main class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
        <?php include 'components/header.php'; ?>

        <div class="p-4 md:p-6 pb-20 md:pb-6 space-y-6">
            <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h3 class="font-semibold text-lg text-neutral-800">Annual Parts Expenses</h3>

                    <button type="reset" form="annual-expenses-form" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                        <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21" />
                            <path d="m5.082 11.09 8.828 8.828" />
                        </svg>

                        Clear Form
                    </button>
                </div>

                <form id="annual-expenses-form" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                    <div class="flex flex-col gap-2">
                        <label for="startYear" class="font-medium text-sm">Start Year</label>
                        <input type="number" id="startYear" name="start_year" placeholder="ex. 2020" class="h-11 w-full px-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="endYear" class="font-medium text-sm">End Year</label>
                        <input type="number" id="endYear" name="end_year" placeholder="ex. 2026" class="h-11 w-full px-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <div>
                            <button type="submit" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                                <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M7 10h10" />
                                    <path d="M7 14h10" />
                                </svg>

                                Calculate
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($formSubmitted): ?>
            <?php if ($errorMessage !== ''): ?>
            <div class="select-none w-full rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
            <?php elseif (empty($tableRows)): ?>
            <div class="select-none w-full rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                No expenses were found for the selected range.
            </div>
            <?php else: ?>
            <?php
                $tableRefreshFormId = 'annual-expenses-form';
                $tableRefreshLabel = 'Recalculate';
                include 'components/table.php';
            ?>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

<?php mysqli_close($conn); ?>

</html>