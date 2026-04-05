<?php
require_once __DIR__ . '/db.php';

$title = 'Add New Supplier | DB Project';
$status = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phoneNumbers = trim($_POST['phoneNumbers'] ?? '');

    if ($name === '' || $email === '') {
        $status = 'error';
        $message = 'Please fill in both name and email.';
    } else {
        $stmt = $conn->prepare('INSERT INTO suppliers (name, email_address) VALUES (?, ?)');

        if (!$stmt) {
            $status = 'error';
            $message = 'Unable to prepare supplier insert.';
        } elseif (!$stmt->bind_param('ss', $name, $email) || !$stmt->execute()) {
            $status = 'error';
            $message = 'Error saving supplier: ' . $stmt->error;
        } else {
            $supplierId = $stmt->insert_id;
            $stmt->close();

            if ($phoneNumbers !== '') {
                $phoneStmt = $conn->prepare('INSERT INTO supplier_phone_number (phone_num, supp_id) VALUES (?, ?)');

                if ($phoneStmt) {
                    $phoneList = preg_split('/[\r\n,]+/', $phoneNumbers);

                    foreach ($phoneList as $phoneNumber) {
                        $phoneNumber = trim($phoneNumber);

                        if ($phoneNumber === '') {
                            continue;
                        }

                        $phoneStmt->bind_param('si', $phoneNumber, $supplierId);
                        $phoneStmt->execute();
                    }

                    $phoneStmt->close();
                }
            }

            $status = 'success';
            $message = 'Supplier added successfully.';
            $_POST = [];
        }
    }
}
?>
<?php include 'components/head.php'; ?>

<body class="h-screen flex flex-row bg-neutral-50 overflow-hidden">
    <?php include 'components/sidebar.php'; ?>

    <main class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
        <?php include 'components/header.php'; ?>

        <div class="p-4 md:p-6 pb-20 md:pb-6">
            <div class="w-full p-4 sm:p-6 rounded-2xl border border-neutral-200 bg-white overflow-hidden">
                <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h3 class="font-semibold text-lg text-neutral-800">Add New Supplier</h3>

                    <button type="reset" form="add-supplier-form" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                        <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 21H8a2 2 0 0 1-1.42-.587l-3.994-3.999a2 2 0 0 1 0-2.828l10-10a2 2 0 0 1 2.829 0l5.999 6a2 2 0 0 1 0 2.828L12.834 21" />
                            <path d="m5.082 11.09 8.828 8.828" />
                        </svg>

                        Clear Form
                    </button>
                </div>

                <?php if ($status === 'success'): ?>
                    <div class="select-none mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php elseif ($status === 'error'): ?>
                    <div class="select-none mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form id="add-supplier-form" action="" method="post" class="max-w-full overflow-x-auto mb-6 grid grid-cols-2 gap-4">
                    <div class="col-span-1 w-full flex flex-col gap-2">
                        <label for="name" class="font-medium text-sm">Name</label>

                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" placeholder="ex. John Doe" class="h-11 w-full px-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />
                    </div>

                    <div class="col-span-1 w-full flex flex-col gap-2">
                        <label for="emailAddress" class="font-medium text-sm">Email Address</label>

                        <input type="email" id="emailAddress" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="ex. johndoe@mail.com" class="h-11 w-full px-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden" required />
                    </div>

                    <div class="col-span-2 w-full flex flex-col gap-2">
                        <label for="phoneNumbers" class="font-medium text-sm">Phone Numbers</label>

                        <textarea id="phoneNumbers" name="phoneNumbers" rows="6" placeholder="ex. +1 (234) 567-8901, +9 (876) 543-9210" class="w-full p-2.5 rounded-lg border border-gray-200 bg-white text-sm text-gray-800 placeholder:text-gray-400 transition-all duration-300 ease-in-out focus:border-blue-400 focus:ring-transparent focus:ring-0 focus:outline-hidden"></textarea>
                    </div>

                    <div class="col-span-1 w-full flex flex-col gap-2">
                        <div>
                            <button type="submit" class="select-none cursor-pointer h-11 px-3.5 py-2 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white font-medium text-sm text-gray-600 transition-all duration-300 ease-in-out hover:bg-gray-50 hover:text-gray-800">
                                <svg class="size-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                                </svg>

                                Save Supplier
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

<?php mysqli_close($conn); ?>

</html>