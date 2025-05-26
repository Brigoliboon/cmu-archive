-- Create accesslevel table
CREATE TABLE IF NOT EXISTS accesslevel (
    AccessLevelID INT PRIMARY KEY,
    LevelName VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert access levels
INSERT IGNORE INTO accesslevel (AccessLevelID, LevelName) VALUES
(1, 'Visitors'),
(2, 'Students'),
(3, 'Faculty/Staff'),
(4, 'Dean'),
(5, 'President');

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50),
    last_name VARCHAR(50) NOT NULL,
    extension VARCHAR(10),
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    AccessLevelID INT NOT NULL DEFAULT 1, -- Default to Visitors
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (AccessLevelID) REFERENCES accesslevel(AccessLevelID),
    INDEX idx_email (email),
    INDEX idx_username (username),
    INDEX idx_role (role),
    INDEX idx_accesslevel (AccessLevelID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create default admin user
INSERT INTO users (
    username,
    password,
    first_name,
    last_name,
    email,
    role,
    AccessLevelID -- Assign President level to admin
) VALUES (
    'admin',
    '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewYpR0NxKxqQJQHy', -- password: admin123
    'System',
    'Administrator',
    'admin@example.com',
    'admin',
    5 -- President level
); 