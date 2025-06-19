CREATE TABLE credit_cards (
    id INT PRIMARY KEY AUTO_INCREMENT,
    holder_id INT NOT NULL,
    brand VARCHAR(50) NOT NULL,
    number VARCHAR(20) NOT NULL,
    limite INT NOT NULL DEFAULT 0,
    closing_date TINYINT NOT NULL CHECK (closing_date >= 1 AND closing_date <= 31),
    due_date TINYINT NOT NULL CHECK (due_date >= 1 AND due_date <= 31),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (holder_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_holder_id (holder_id),
    INDEX idx_brand (brand),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 