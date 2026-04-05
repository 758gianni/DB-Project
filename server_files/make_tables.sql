CREATE TABLE IF NOT EXISTS parts (
    _id INT NOT NULL,
    price DOUBLE(10, 2),
    description VARCHAR(50),
    PRIMARY KEY (_id)
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS suppliers (
    _id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(200),
    PRIMARY KEY (_id)
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS supplier_phone_number (
    _id INT NOT NULL AUTO_INCREMENT,
    phone_num VARCHAR(20) NOT NULL UNIQUE,
    supp_id INT NOT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (supp_id) REFERENCES suppliers(_id) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS orders (
    _id INT NOT NULL AUTO_INCREMENT,
    supp_id INT NOT NULL,
    `when` DATE NOT NULL,
    PRIMARY KEY (_id),
    FOREIGN KEY (supp_id) REFERENCES suppliers(_id) ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS order_part (
    order_id INT NOT NULL,
    part_id INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (order_id, part_id),
    FOREIGN KEY (order_id) REFERENCES orders(_id) ON DELETE CASCADE,
    FOREIGN KEY (part_id) REFERENCES parts(_id) ON DELETE CASCADE
) ENGINE = INNODB;
