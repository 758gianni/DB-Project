<?php
$title = 'Budget Projection | DB Project';
require_once __DIR__ . '/db.php';

$baseYear = 2022;
$tableRows = [];
$formSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';
$errorMessage = '';

if ($formSubmitted) {
    $years = (int)($_POST['years'] ?? 0);
    $rate = (float)($_POST['rate'] ?? 0) / 100;

    if ($years > 0 && $rate >= 0) {
        $sql = "
            SELECT COALESCE(SUM(op.qty * p.price), 0) AS total
            FROM orders o
            JOIN order_part op ON o._id = op.order_id
            JOIN parts p ON op.part_id = p._id
            WHERE YEAR(o.`when`) = ?
        ";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $baseYear);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $baseTotal = (float)($result['total'] ?? 0);

            for ($i = 1; $i <= $years; $i++) {
                $year = $baseYear + $i;
                $projected = $baseTotal * pow(1 + $rate, $i);

                $tableRows[] = [
                    $year,
                    '$' . number_format($projected, 2),
                ];
            }

            $stmt->close();
        } else {
            $errorMessage = 'Unable to prepare the budget projection query.';
        }
    } else {
        $errorMessage = 'Invalid input.';
    }
}

include 'components/head.php';
?>

<body class="h-screen flex flex-row bg-neutral-50 overflow-hidden">
    <?php include 'components/sidebar.php'; ?>

    <main class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
        <?php include 'components/header.php'; ?>

        <div class="p-4 md:p-6 pb-20 md:pb-6 flex flex-col gap-6">
            <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h3 class="font-semibold text-lg text-neutral-800">Budget Projection</h3>

                    <button type="reset" form="budget-projection-form" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                        <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21" />
                            <path d="m5.082 11.09 8.828 8.828" />
                        </svg>

                        Clear Form
                    </button>
                </div>

                <form id="budget-projection-form" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                    <div class="flex flex-col gap-2">
                        <label for="numYears" class="font-medium text-sm">Number of Years</label>

                        <input type="number" id="numYears" name="years" value="<?php echo htmlspecialchars($_POST['years'] ?? ''); ?>" placeholder="ex. 5" class="h-11 w-full px-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="inflationRate" class="font-medium text-sm">Inflation Rate</label>

                        <div class="relative">
                            <input type="number" id="inflationRate" name="rate" value="<?php echo htmlspecialchars($_POST['rate'] ?? ''); ?>" placeholder="ex. 2" class="h-11 w-full pl-2.5 pr-12 py-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />

                            <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2">
                                <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="19" x2="5" y1="5" y2="19" />
                                    <circle cx="6.5" cy="6.5" r="2.5" />
                                    <circle cx="17.5" cy="17.5" r="2.5" />
                                </svg>
                            </span>
                        </div>
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
                No projections were generated.
            </div>
            <?php else: ?>
            <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h3 class="font-semibold text-lg text-neutral-800">Projected Budget</h3>
                </div>

                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b border-neutral-200">
                            <tr>
                                <th class="px-6 py-2 whitespace-nowrap first:pl-0">
                                    <div class="flex items-center">
                                        <p class="font-medium text-base text-neutral-600 uppercase">Year</p>
                                    </div>
                                </th>
                                <th class="px-6 py-2 whitespace-nowrap first:pl-0">
                                    <div class="flex items-center">
                                        <p class="font-medium text-base text-neutral-600 uppercase">Projected Total</p>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($tableRows as $row): ?>
                            <tr class="border-b border-neutral-100 last:border-b-0">
                                <td class="px-6 py-2 whitespace-nowrap first:pl-0">
                                    <div class="col-span-4 flex items-center">
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars((string)$row[0]); ?></p>
                                    </div>
                                </td>
                                <td class="px-6 py-2 whitespace-nowrap first:pl-0">
                                    <div class="col-span-4 flex items-center">
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars((string)$row[1]); ?></p>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</body>

<?php mysqli_close($conn); ?>

</html>