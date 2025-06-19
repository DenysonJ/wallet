CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    source_account_type ENUM('account', 'credit_card') NOT NULL,
    source_account_id INT NOT NULL,
    amount INT NOT NULL,
    date TIMESTAMP NOT NULL,
    description VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    type ENUM('EXPENSE', 'INCOME', 'TRANSFER') NOT NULL,
    recurring BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_source_account (source_account_type, source_account_id),
    INDEX idx_date (date),
    INDEX idx_category (category),
    INDEX idx_type (type),
    INDEX idx_recurring (recurring)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 