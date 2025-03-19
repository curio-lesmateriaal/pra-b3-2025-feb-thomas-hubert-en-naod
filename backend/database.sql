-- Maak database aan als deze nog niet bestaat
CREATE DATABASE IF NOT EXISTS naodmain;
USE naodmain;

-- Maak de taken tabel aan
CREATE TABLE IF NOT EXISTS taken (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titel VARCHAR(255) NOT NULL,
    beschrijving TEXT,
    afdeling VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'todo',
    deadline DATE NOT NULL,
    user VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 