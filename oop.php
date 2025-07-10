<?php

class Library
{
    public $books = [];
    public $members = [];

    public function __construct($books = [], $members = [])
    {
        $this->books = $books;
        $this->members = $members;
    }

    public function showAllAvailableBooks()
    {
        $borrowedBooks = [];
        
        // Collect all borrowed books' ISBNs
        foreach ($this->members as $member)
        {
            foreach ($member->borrowedBooks as $book)
            {
                $borrowedBooks[] = $book->getISBN(); // Compare by ISBN instead of author
            }
        }

        // Display available books
        echo 'Available books are:<br>';
        foreach ($this->books as $book)
        {
            if (!in_array($book->getISBN(), $borrowedBooks)) {
                echo "- {$book->getTitle()} (Author: {$book->getAuthor()})<br>";
            }
        }
    }
}

abstract class Person
{
    abstract public function getName();
    abstract public function getID();
}


class Book
{
    private $title;
    private $author;
    private $ISBN;

    public function __construct($title, $author, $ISBN)
    {
        $this->title = $title;
        $this->author = $author;
        $this->ISBN = $ISBN;
    }

    // Getter methods
    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getISBN()
    {
        return $this->ISBN;
    }
}


class Member extends Person
{
    public $name;
    public $id;
    public $borrowedBooks = [];
    public $borrowLimits;

    public function __construct($name, $id, $borrowLimits)
    {
        $this->name = $name;
        $this->id = $id;
        $this->borrowLimits = $borrowLimits;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getID()
    {
        return $this->id;
    }

    public function borrowBooks(Book $book)
    {
        if (count($this->borrowedBooks) < $this->borrowLimits) {
            $this->borrowedBooks[] = $book;
            echo "{$this->getName()} borrowed {$book->getTitle()}.<br>";
        } else {
            echo "{$this->getName()} has reached the borrowing limit of {$this->borrowLimits} books.<br>";
        }
    }

    public function returnBook(Book $book)
    {
        foreach ($this->borrowedBooks as $index => $borrowedBook)
        {
            if ($borrowedBook->getISBN() === $book->getISBN())
            {
                unset($this->borrowedBooks[$index]);
                $this->borrowedBooks = array_values($this->borrowedBooks); // Re-index array
                echo "{$this->getName()} returned the book: {$book->getTitle()} by {$book->getAuthor()}.<br>";
                return;
            }
        }
        echo "{$this->getName()} did not borrow the book: {$book->getTitle()}.<br>";
    }

    public function showAllBorrowedBooks()
    {
        if (empty($this->borrowedBooks))
        {
            echo "{$this->getName()} has not borrowed any books.<br>";
        }
        else
        {
            echo "{$this->getName()} has borrowed the following books:<br>";
            foreach ($this->borrowedBooks as $book)
            {
                echo "- {$book->getTitle()} by {$book->getAuthor()}<br>";
            }
        }
    }
}

class Student extends Member
{
    // Borrow limit is fixed at 3
    public function __construct($name, $id)
    {
        parent::__construct($name, $id, 3); // Call parent constructor with limit 3
    }
}

class Teacher extends Member
{
    // Borrow limit is fixed at 5
    public function __construct($name, $id)
    {
        parent::__construct($name, $id, 5); // Call parent constructor with limit 5
    }
}

// Testing

$book1 = new Book('1984', 'George Orwell', '123456');
$book2 = new Book('Brave New World', 'Aldous Huxley', '654321');
$book3 = new Book('To Kill a Mockingbird', 'Harper Lee', '789012');
$book4 = new Book('The Great Gatsby', 'F. Scott Fitzgerald', '111213');

$library = new Library([$book1, $book2, $book3, $book4]);

$student = new Student('John Doe', 1);
echo "{$student->name} (ID: {$student->id})<br>";
$student->borrowBooks($book1);
$student->borrowBooks($book2);
$student->borrowBooks($book3); // Student reaches limit here
$student->borrowBooks(new Book('Moby Dick', 'Herman Melville', '141516')); // This will show limit reached
$student->showAllBorrowedBooks();
$student->returnBook($book1);

$teacher = new Teacher('Jane Smith', 2);
$teacher->borrowBooks($book4);

$library->showAllAvailableBooks();