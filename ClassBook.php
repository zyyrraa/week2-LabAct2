<?php
class Book {
    public $title;
    protected $author;
    private $price;

    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function getDetails() {
        return "Title: $this->title, Author: $this->author, Price: $this->price";
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    // magic method to handle calls to non-existent methods, simulating methods overloading
    public function __call($name, $arguments) {
        if ($name === 'updateStock') {
            echo "Stock updated for '$this->title' with arguments: " . implode(', ', $arguments) . "<br>";
        } else {
            echo "Method '$name' not found.<br>";
        }
    }
}

class Library {
    private $books = [];
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addBook(Book $book) {
        $this->books[] = $book;
        echo "Book '$book->title' added to the library.<br>";
    }

    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->title === $title) {
                unset($this->books[$key]);
                echo "Book '$title' removed from the library.<br>";
                return;
            }
        }
        echo "Book '$title' not found in the library.<br>";
    }

    public function listBooks() {
        echo "Books in the library:<br>";
        foreach ($this->books as $book) {
            echo $book->getDetails() . "<br>";
        }
    }
    // Destructor called when the library object is destroyed
    public function __destruct() {
        echo "The library '$this->name' is now closed.<br>";
    }
}

// Create books
$book1 = new Book("The Catcher in the Rye", "J. D. Salinger", 52.99);
$book2 = new Book("1984", "George Orwell", 21.99);

// Create library
$library = new Library("UDD Library");

// Add books to the library
$library->addBook($book1);
$library->addBook($book2);

// Update book price
$book1->setPrice(65.99);
echo $book1->getDetails() . "<br>";

// Attempt to call a non-existent method
$book1->updateStock(50);

// Remove a book
$library->removeBook("1984");

// List books
$library->listBooks();

// Destroy the library
unset($library);
?>