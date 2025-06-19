CREATE TABLE accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    amount INT NOT NULL DEFAULT 0,
    currency VARCHAR(3) NOT NULL DEFAULT 'BRL',
    type VARCHAR(50) NOT NULL,
    description VARCHAR(255),
    user_id INT NOT NULL,
    bank_id INT NOT NULL,
    agency VARCHAR(20) NOT NULL,
    account VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_bank_id (bank_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 