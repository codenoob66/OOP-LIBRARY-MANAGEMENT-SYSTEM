<?php
require '../bootstrap.php';

$user = $authService->getCurrentUser();

// ─── POST: Form submissions ───────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'login':
            $result = $authService->login(
                $_POST['name'] ?? '',
                $_POST['password'] ?? ''
            );
            if ($result === null) {
                $_SESSION['error'] = 'Invalid username or password.';
                header('Location: ?action=login');
            } else {
                header('Location: index.php');
            }
            exit;

        case 'register':
            $result = $authService->register(
                $_POST['name'] ?? '',
                $_POST['password'] ?? ''
            );
            if ($result === null) {
                $_SESSION['error'] = 'Username already taken.';
                header('Location: ?action=register');
            } else {
                $_SESSION['message'] = 'Registration successful! Please log in.';
                header('Location: ?action=login');
            }
            exit;

        case 'borrow':
            if (!$user) {
                header('Location: ?action=login');
                exit;
            }
            $bookId = (int)($_GET['book_id'] ?? 0);
            $book = null;
            foreach ($borrowService->getAllBooks() as $b) {
                if ($b->getId() === $bookId) {
                    $book = $b;
                    break;
                }
            }
            if ($book === null || !$borrowService->borrowBook($user, $book)) {
                $_SESSION['error'] = 'Could not borrow that book.';
            } else {
                $_SESSION['message'] = 'Book borrowed!';
            }
            header('Location: index.php');
            exit;

        case 'return':
            if (!$user) {
                header('Location: ?action=login');
                exit;
            }
            $bookId = (int)($_GET['book_id'] ?? 0);
            $book = null;
            foreach ($borrowService->getAllBooks() as $b) {
                if ($b->getId() === $bookId) {
                    $book = $b;
                    break;
                }
            }
            if ($book === null || !$borrowService->returnBook($user, $book)) {
                $_SESSION['error'] = 'Could not return that book.';
            } else {
                $_SESSION['message'] = 'Book returned!';
            }
            header('Location: index.php');
            exit;

        case 'add_book':
            if (!$user || $user->getRole() !== 'admin') {
                header('Location: index.php');
                exit;
            }
            $result = $adminService->addBook(
                $user,
                $_POST['author'] ?? '',
                $_POST['title'] ?? '',
                (int)($_POST['available_copies'] ?? 0)
            );
            if (!$result) {
                $_SESSION['error'] = 'Failed to add book.';
            } else {
                $_SESSION['message'] = 'Book added!';
            }
            header('Location: index.php');
            exit;

        case 'logout':
            $authService->logOut();
            header('Location: ?action=login');
            exit;

        default:
            header('Location: index.php');
            exit;
    }
}

// ─── GET: Logout (simple link) ────────────────────────────────────────
$action = $_GET['action'] ?? '';

if ($action === 'logout') {
    $authService->logOut();
    header('Location: ?action=login');
    exit;
}

// ─── GET: Guest guard ─────────────────────────────────────────────────
if (!$user && !in_array($action, ['login', 'register'])) {
    header('Location: ?action=login');
    exit;
}

// ─── GET: Flash messages ──────────────────────────────────────────────
$error   = $_SESSION['error']   ?? null;
$message = $_SESSION['message'] ?? null;
unset($_SESSION['error'], $_SESSION['message']);

// ─── GET: View dispatch ───────────────────────────────────────────────
switch ($action) {
    case 'login':
        $view  = 'views/login.php';
        $title = 'Login';
        break;

    case 'register':
        $view  = 'views/register.php';
        $title = 'Register';
        break;

    default:
        $books = $borrowService->getAllBooks();
        if ($user->getRole() === 'admin') {
            $view  = 'views/admin-dashboard.php';
            $title = 'Admin Dashboard';
        } else {
            $borrowedBooks = $borrowService->getBorrowedBooksByUser($user);
            $view  = 'views/user_dashboard.php';
            $title = 'My Dashboard';
        }
}

ob_start();
include $view;
$content = ob_get_clean();

include 'views/layout.php';
