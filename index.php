<?php $title = 'Dashboard | DB Project'; ?>
<?php include 'db.php'; ?>
<?php include 'components/head.php'; ?>

<body class="h-screen flex flex-row bg-neutral-50 overflow-hidden">
    <?php include 'components/sidebar.php'; ?>

    <main class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
        <?php include 'components/header.php'; ?>

        <div class="p-4 md:p-6 pb-20 md:pb-6">
            <form id="table-form" method="post" class="mb-6 flex items-center justify-start gap-4">
                <div class="relative">
                    <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2">
                        <svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </span>

                    <input type="search" id="search" name="table" value="<?php echo htmlspecialchars($_POST['table'] ?? ''); ?>" placeholder="Search or type command..." required class="h-11 w-full xl:w-[430px] pl-12 pr-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" />
                </div>

                <button type="submit" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                    <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v18" />
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M3 9h18" />
                        <path d="M3 15h18" />
                    </svg>

                    Show Table
                </button>

                <button type="button" onclick="window.location.href='index.php'" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                    <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21" />
                        <path d="m5.082 11.09 8.828 8.828" />
                    </svg>

                    Clear Form
                </button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $table = $_POST['table'];
                $result = $conn->query("SELECT * FROM $table");

                if ($result) {
                    include 'components/table.php';
                } else {
                    echo "Invalid table name.";
                }
            }
            ?>
        </div>
    </main>
</body>

<?php mysqli_close($conn); ?>

</html>