CREATE
DATABASE IF NOT EXISTS vloln1;
USE
vloln1;

CREATE TABLE surveys
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    comments   TEXT,
    consent    TINYINT(1) NOT NULL,
    interests  VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
