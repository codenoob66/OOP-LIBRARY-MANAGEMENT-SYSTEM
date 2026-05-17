<h2>Available Books</h2>

<?php if (empty($books)): ?>
    <p>No books available right now.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Available</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book->getTitle()) ?></td>
                    <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                    <td><?= $book->getAvailableCopies() ?></td>
                    <td>
                        <form method="POST" action="?action=borrow&book_id=<?= $book->getId() ?>" style="display:inline;">
                            <button type="submit" class="btn btn-sm">Borrow</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<h2 style="margin-top: 2rem;">My Borrowed Books</h2>

<?php if (empty($borrowedBooks)): ?>
    <p>You haven&rsquo;t borrowed any books.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($borrowedBooks as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book->getTitle()) ?></td>
                    <td><?= htmlspecialchars($book->getAuthor()) ?></td>
                    <td>
                        <form method="POST" action="?action=return&book_id=<?= $book->getId() ?>" style="display:inline;">
                            <button type="submit" class="btn btn-sm btn-danger">Return</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
