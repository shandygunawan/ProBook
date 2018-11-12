<?php
	class Database {
		private $db;
		private $bookTable = "Book";
		private $userTable = "User";
		private $reviewTable = "BookOrder";
		private $orderTable = "BookOrder";
		private $userPicPath = "/asset/user_img/";
		private $bookPicPath = "/asset/book_img/";

		// =========================================================
		// 						HELPER FUNCTION
		// =========================================================

		private function containMatch($string) {
			return '%'.trim($string).'%';
		}
		private function prepareQuery($query) {
			return $this->db->prepare($query);
		}
		private function runQuery($query, $param_binding) {
			try {
				$stmt = $this->prepareQuery($query);
				// $stmt->execute(array_values((array)$param_binding));
				$stmt->execute(((array)$param_binding));
				$result = $stmt->fetchAll(PDO::FETCH_OBJ);
				return $result;
			} catch (PDOException $e) {
				die("Failed to run query: " . $e->getMessage());
			}		
		}

		// =========================================================
		// 						CONSTRUCTOR
		// =========================================================

		public function __construct($url, $username, $password, $db_name) {
			$dsn = "mysql:host=$url;dbname=$db_name;charset=utf8";

			try {
				$this->db = new PDO($dsn, $username, $password);
				// echo "Success: A proper connection to MySQL was made! <br>";
			} catch (PDOException $e) {
				echo "Error";
			}
		}

		// =========================================================
		// 						CREATE
		// =========================================================

		// Create new user assuming it is not exists yet
		public function addNewUser($user) {
			$query = "INSERT INTO $this->userTable VALUES ('', :Name, :Username, :Email, :Password, :Address, :PhoneNumber, :PicturePath);";
			$this->runQuery($query, $user);
		}

		// Add new order
		public function addOrder($order) {
			$query = "INSERT INTO $this->orderTable VALUES ('', :UserID, :BookID, :OrderDate, :Amount, :Score, :Comment);";
			$this->runQuery($query, $order);
		}

		// =========================================================
		// 						READ
		// =========================================================

		// Get user's ID from username
		public function getUserIDByUsername($username){
			$query = "SELECT UserID FROM user WHERE Username = '".$username."';";

			return $this->runQuery($query, [$username]);
		}

		// get user's password from username
		public function getPasswordByUsername($username){
			$query = "SELECT Password FROM user WHERE Username = '".$username."';";

			return $this->runQuery($query, [$username]);
		}

		public function getUserIDByEmail($email) {
			$query = "SELECT UserID FROM user WHERE Email = '".$email."';";

			return $this->runQuery($query, [$email]);
		}

		// get user's email from username
		public function getEmailByUsername($username){
			$query = "SELECT Email FROM user WHERE Username = '".$username."';";

			return $this->runQuery($query, [$username]);	
		}

		// Get data of user with user ID
		public function getUserByID($user_id) {
			$query = "SELECT * FROM $this->userTable WHERE UserID = ?;";
			
			return $this->runQuery($query, [$user_id]);
		}

		// Find book with ID
		public function findBookByID($book_id) {
			$query = "SELECT BookTable.BookID, BookName, PicturePath, Author, Synopsis, COALESCE(AVG(Score), 0) as AverageRating, COALESCE(COUNT(Score), 0) as Voters FROM ((SELECT * FROM BOOK WHERE BookID = :BookID) as BookTable LEFT JOIN BookOrder ON BookTable.BookID = BookOrder.BookID);";

			$temp = new stdClass;
			$temp->BookID = $book_id;

			return $this->runQuery($query, $temp);
		}

		// Find book with contains match of title
		public function findBookByTitle($title) {
			$query = "SELECT BookTable.BookID, BookName, PicturePath, Author, Synopsis, COALESCE(AVG(Score), 0) as AverageRating, COALESCE(COUNT(Score), 0) as Voters FROM ((SELECT * FROM BOOK WHERE BookName LIKE :BookName) as BookTable LEFT JOIN BookOrder ON BookTable.BookID = BookOrder.BookID) GROUP BY BookTable.BookID;";

			// Modify query string to contain match
			$title = $this->containMatch($title);
			$temp = new stdClass;
			$temp->BookName = $title;

			return $this->runQuery($query, $temp);
		}

		// Get review, reviewer's username, and user's picture 
		public function getReviewOnBook($book_id) {
			$query = "SELECT Username, PicturePath, Comment, Score FROM (SELECT * FROM (SELECT * FROM $this->orderTable WHERE Comment IS NOT NULL) as o NATURAL JOIN (SELECT BookID, BookName FROM $this->bookTable WHERE BookID = ?) as b) as bo NATURAL JOIN $this->userTable";
			
			return $this->runQuery($query, [$book_id]);
		}

		public function getBookOrder($user_id) {
			$query = "SELECT OrderID, BookID, BookName, PicturePath, Amount, Comment, OrderDate FROM $this->orderTable NATURAL JOIN $this->bookTable WHERE UserID = ? ORDER BY OrderDate DESC, OrderID DESC";
			
			return $this->runQuery($query, [$user_id]);	
		}

		// =========================================================
		// 						UPDATE
		// =========================================================

		public function updateUserData ($user) {
			$query = "UPDATE $this->userTable SET name = :Name, username = :Username, email = :Email, password = :Password, address = :Address, phonenumber = :PhoneNumber, picturepath = :PicturePath WHERE userid = :UserID";

			return $this->runQuery($query, $user);	
		}

		public function updateReview ($review) {
			$query = "UPDATE $this->reviewTable SET score = :Score, Comment = :Comment WHERE OrderID = :OrderID";

			return $this->runQuery($query, $review);	
		}

		// =========================================================
		// 						DELETE
		// =========================================================
	}
?>