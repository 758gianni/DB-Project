<?php if (isset($tableColumns, $tableRows) && is_array($tableColumns) && is_array($tableRows)): ?>
    <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="font-semibold text-lg text-neutral-800"><?php echo htmlspecialchars($tableTitle ?? 'Results'); ?></h3>

            <?php if (!empty($tableRefreshFormId)): ?>
                <button type="submit" form="<?php echo htmlspecialchars($tableRefreshFormId); ?>" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                    <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                        <path d="M16 16h5v5" />
                    </svg>

                    <?php echo htmlspecialchars($tableRefreshLabel ?? 'Refresh'); ?>
                </button>
            <?php endif; ?>
        </div>

        <div class="max-w-full overflow-x-auto">
            <table class="min-w-full">
                <thead class="border-b border-neutral-200">
                    <tr>
                        <?php foreach ($tableColumns as $column): ?>
                            <th class="px-6 py-2 whitespace-nowrap first:pl-0">
                                <div class="flex items-center">
                                    <p class="font-medium text-base text-neutral-600 uppercase"><?php echo htmlspecialchars($column); ?></p>
                                </div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($tableRows as $row): ?>
                        <tr class="border-b border-neutral-100 last:border-b-0">
                            <?php foreach ($row as $value): ?>
                                <td class="px-6 py-2 whitespace-nowrap first:pl-0">
                                    <div class="col-span-4 flex items-center">
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars((string)$value); ?></p>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="font-semibold text-lg text-neutral-800 capitalize"><?php echo htmlspecialchars($_POST['table'] ?? 'Table Name'); ?></h3>

            <button type="submit" form="table-form" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                    <path d="M16 16h5v5" />
                </svg>

                Refresh
            </button>
        </div>

        <div class="max-w-full overflow-x-auto">
            <table class="min-w-full">
                <?php include 'components/table-head.php'; ?>
                <?php include 'components/table-body.php'; ?>
            </table>
        </div>
    </div>
<?php endif; ?>