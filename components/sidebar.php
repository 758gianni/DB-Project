<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

<aside class="no-scrollbar fixed top-0 left-0 z-9999 h-screen w-[290px] flex flex-col border-r border-gray-200 bg-white overflow-y-auto transition-all duration-300 ease-in-out xl:static xl:translate-x-0">
    <div class="h-20 w-full mb-4 px-5 flex items-center justify-center border-gray-200 xl:border-b bg-white">
        <a href="index.php" class="select-none cursor-pointer flex items-center justify-center gap-2">
            <svg class="size-6 stroke-2 text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <ellipse cx="12" cy="5" rx="9" ry="3" />
                <path d="M3 5V19A9 3 0 0 0 21 19V5" />
                <path d="M3 12A9 3 0 0 0 21 12" />
            </svg>

            <h3 class="font-bold text-base text-gray-800 uppercase">Database Project</h3>
        </a>
    </div>

    <ul class="w-full mb-6 px-5 flex flex-col gap-1">
        <li>
            <a href="index.php" class="select-none cursor-pointer w-full px-4 py-3 inline-flex items-center justify-start gap-2 <?= $currentPage == 'index.php' ? 'text-blue-500' : 'text-gray-800' ?> transition-all duration-300 ease-in-out hover:opacity-80">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z" fill="currentColor" />
                </svg>

                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="add-new-supplier.php" class="select-none cursor-pointer w-full px-4 py-3 inline-flex items-center justify-start gap-2 <?= $currentPage == 'add-new-supplier.php' ? 'text-blue-500' : 'text-gray-800' ?> transition-all duration-300 ease-in-out hover:opacity-80">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>

                <span>Add New Supplier</span>
            </a>
        </li>

        <li>
            <a href="annual-parts-expenses.php" class="select-none cursor-pointer w-full px-4 py-3 inline-flex items-center justify-start gap-2 <?= $currentPage == 'annual-parts-expenses.php' ? 'text-blue-500' : 'text-gray-800' ?> transition-all duration-300 ease-in-out hover:opacity-80">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 18H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5" />
                    <path d="m16 19 3 3 3-3" />
                    <path d="M18 12h.01" />
                    <path d="M19 16v6" />
                    <path d="M6 12h.01" />
                    <circle cx="12" cy="12" r="2" />
                </svg>

                <span>Annual Parts Expenses</span>
            </a>
        </li>

        <li>
            <a href="budget-projection.php" class="select-none cursor-pointer w-full px-4 py-3 inline-flex items-center justify-start gap-2 <?= $currentPage == 'budget-projection.php' ? 'text-blue-500' : 'text-gray-800' ?> transition-all duration-300 ease-in-out hover:opacity-80">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 17h3v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-3a3.16 3.16 0 0 0 2-2h1a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-1a5 5 0 0 0-2-4V3a4 4 0 0 0-3.2 1.6l-.3.4H11a6 6 0 0 0-6 6v1a5 5 0 0 0 2 4v3a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1z" />
                    <path d="M16 10h.01" />
                    <path d="M2 8v1a2 2 0 0 0 2 2h1" />
                </svg>

                <span>Budget Projection</span>
            </a>
        </li>
    </ul>
</aside>