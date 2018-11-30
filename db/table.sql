DROP TABLE IF EXISTS Buku;
CREATE TABLE Buku (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name TEXT NOT NULL,
	author TEXT NOT NULL,
	synopsis TEXT NOT NULL
);

INSERT INTO Buku VALUES ("", "Test judul", "Test author", "Test synopsis");
