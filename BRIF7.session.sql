-- Create a new database
DROP DATABASE IF EXISTS electronacerv3;
CREATE DATABASE electronacerv3;
USE electronacerv3;
-- Table for users (combined)
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    verified BOOLEAN DEFAULT FALSE,
    full_name VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    address VARCHAR(255),
    disabled BOOLEAN DEFAULT FALSE NOT NULL,
    city VARCHAR(100)
);
-- Table for product categories
CREATE TABLE Categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL,
    imag_category varchar(255) NOT NULL,
    is_disabled BOOLEAN DEFAULT FALSE NOT NULL
);
INSERT INTO Categories (category_name, imag_category, is_disabled)
VALUES ('Laptops', 'ac2.jpg', FALSE),
    ('Phones', 'ac3.jpg', FALSE),
    ('Electromenager', 'rab3a.jpg', FALSE),
    ('Consoles', 'tlata.png', FALSE);
-- Table for products
CREATE TABLE Products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    reference VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    barcode VARCHAR(255) NOT NULL,
    label VARCHAR(255) NOT NULL,
    purchase_price DECIMAL(10, 2) NOT NULL,
    final_price DECIMAL(10, 2) NOT NULL,
    price_offer VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    min_quantity INT NOT NULL,
    stock_quantity INT NOT NULL,
    category_id INT,
    disabled BOOLEAN DEFAULT FALSE NOT NULL,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);
-- Table for orders
CREATE TABLE Orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    send_date DATETIME,
    delivery_date DATETIME,
    total_price DECIMAL(10, 2),
    order_status ENUM('Pending', 'Validated', 'Cancelled') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);
-- Table for order details (products in an order)
CREATE TABLE OrderDetails (
    order_detail_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10, 2),
    total_price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);
-- Add your sample data for users
INSERT INTO Users (
        username,
        email,
        password,
        role,
        verified,
        full_name,
        phone_number,
        address,
        disabled,
        city
    )
VALUES (
        'Admin',
        'admin@test.com',
        'admin123',
        'admin',
        TRUE,
        'Admin User',
        '123456789',
        'Admin Address',
        0,
        'Admin City'
    ),
    (
        'User',
        'user@test.com',
        'user123',
        'user',
        TRUE,
        'Regular User',
        '987654321',
        'User Address',
        0,
        'User City'
    ),
    (
        'User1',
        'user1@test.com',
        'user123',
        'user',
        FALSE,
        'User1 User',
        '111222333',
        'User1 Address',
        0,
        'User1 City'
    );
-- Insert 30 product demo records
INSERT INTO Products (
        reference,
        image,
        barcode,
        label,
        purchase_price,
        final_price,
        price_offer,
        description,
        min_quantity,
        stock_quantity,
        category_id
    )
VALUES(
        '1',
        'a1.jpg',
        '0000',
        'Lenovo Laptop 1',
        5000,
        9000,
        '8000',
        'laptop bonne état',
        5,
        12,
        1
    ),
    (
        '2',
        'a2.jpg',
        '0000',
        'Lenovo Laptop 2',
        5000,
        9500,
        '9000',
        'laptop bonne état',
        5,
        4,
        1
    ),
    (
        '3',
        'a3.jpg',
        '0000',
        'Lenovo Laptop 3',
        5000,
        8900,
        '8000',
        'laptop bonne état',
        5,
        15,
        1
    ),
    -- Add more records as needed
    (
        '4',
        'a4.jpg',
        '0000',
        'Lenovo Laptop 4',
        5000,
        8800,
        '7000',
        'laptop bonne état',
        5,
        1,
        1
    ),
    (
        '5',
        'b1.jpg',
        '0000',
        'Phone 1',
        500,
        1300,
        '1000',
        'Phone bonne état',
        5,
        3,
        2
    ),
    (
        '6',
        'b2.jpg',
        '0000',
        'Phone 2',
        500,
        1400,
        '1000',
        'Phone bonne état',
        5,
        3,
        2
    ),
    (
        '7',
        'b3.jpg',
        '0000',
        'Phone 3',
        1000,
        2100,
        '2000',
        'Phone bonne état',
        5,
        3,
        2
    ),
    (
        '8',
        'b4.jpg',
        '0000',
        'Phone 4',
        2000,
        3000,
        '2000',
        'Phone bonne état',
        5,
        10,
        2
    ),
    (
        '9',
        'c1.jpg',
        '0000',
        'Refrigerateur 1',
        10000,
        18900,
        '15000',
        'Refrigerateur bonne état',
        5,
        6,
        3
    ),
    (
        '10',
        'c2.jpg',
        '0000',
        'Pack 1',
        10000,
        30000,
        '26000',
        'Refrigerateur bonne état',
        5,
        1,
        3
    ),
    -- Continue adding more records
    (
        '11',
        'c3.jpg',
        '0000',
        'Pack 2',
        12000,
        31000,
        '25000',
        'Refrigerateur bonne état',
        5,
        2,
        3
    ),
    (
        '12',
        'c4.jpg',
        '0000',
        'Lave-vaisselle',
        2000,
        4000,
        '3000',
        'Lave-vaisselle bonne état',
        5,
        99,
        3
    ),
    (
        '13',
        'd1.jpg',
        '0000',
        'PlayStation 5',
        500,
        2,
        '2',
        'PlayStation 5 bonne état',
        5,
        1,
        4
    ),
    (
        '14',
        'd2.jpg',
        '0000',
        'PS5 Controller',
        200,
        600,
        '555',
        'Manetta bonne état',
        5,
        20,
        4
    ),
    -- Add more records as needed
    (
        '15',
        'd3.jpg',
        '0000',
        'Xbox One',
        500,
        2,
        '2',
        'Xbox bonne état',
        5,
        1,
        4
    );