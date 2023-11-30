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
    city VARCHAR(100)
);
-- Table for product categories
CREATE TABLE Categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(255) NOT NULL
);
INSERT INTO Categories (category_name)
VALUES ('Category 1'),
    ('Category 2'),
    ('Category 3');
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
    hidden BOOLEAN DEFAULT FALSE NOT NULL,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
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
        'REF001',
        'image1.jpg',
        '123456789001',
        'Product 1',
        10.99,
        15.99,
        '2.00',
        'Product 1 description',
        5,
        100,
        1
    ),
    (
        'REF002',
        'image2.jpg',
        '123456789002',
        'Product 2',
        12.99,
        18.99,
        '3.00',
        'Product 2 description',
        5,
        80,
        1
    ),
    (
        'REF003',
        'image3.jpg',
        '123456789003',
        'Product 3',
        8.99,
        12.99,
        '1.50',
        'Product 3 description',
        10,
        120,
        2
    ),
    -- Add more records as needed
    (
        'REF004',
        'image4.jpg',
        '123456789004',
        'Product 4',
        14.99,
        22.99,
        '4.00',
        'Product 4 description',
        3,
        50,
        2
    ),
    (
        'REF005',
        'image5.jpg',
        '123456789005',
        'Product 5',
        9.99,
        14.99,
        '2.50',
        'Product 5 description',
        8,
        90,
        1
    ),
    (
        'REF006',
        'image6.jpg',
        '123456789006',
        'Product 6',
        11.99,
        17.99,
        '2.50',
        'Product 6 description',
        6,
        70,
        3
    ),
    (
        'REF007',
        'image7.jpg',
        '123456789007',
        'Product 7',
        16.99,
        24.99,
        '5.00',
        'Product 7 description',
        4,
        60,
        3
    ),
    (
        'REF008',
        'image8.jpg',
        '123456789008',
        'Product 8',
        13.99,
        19.99,
        '3.50',
        'Product 8 description',
        7,
        110,
        1
    ),
    (
        'REF009',
        'image9.jpg',
        '123456789009',
        'Product 9',
        15.99,
        21.99,
        '4.50',
        'Product 9 description',
        2,
        40,
        2
    ),
    (
        'REF010',
        'image10.jpg',
        '123456789010',
        'Product 10',
        18.99,
        28.99,
        '6.00',
        'Product 10 description',
        5,
        80,
        3
    ),
    -- Continue adding more records
    (
        'REF011',
        'image11.jpg',
        '123456789011',
        'Product 11',
        20.99,
        32.99,
        '7.00',
        'Product 11 description',
        3,
        55,
        1
    ),
    (
        'REF012',
        'image12.jpg',
        '123456789012',
        'Product 12',
        9.99,
        15.99,
        '2.00',
        'Product 12 description',
        6,
        95,
        2
    ),
    (
        'REF013',
        'image13.jpg',
        '123456789013',
        'Product 13',
        11.99,
        16.99,
        '2.50',
        'Product 13 description',
        4,
        75,
        3
    ),
    (
        'REF014',
        'image14.jpg',
        '123456789014',
        'Product 14',
        14.99,
        22.99,
        '4.00',
        'Product 14 description',
        8,
        120,
        1
    ),
    -- Add more records as needed
    (
        'REF015',
        'image15.jpg',
        '123456789015',
        'Product 15',
        16.99,
        24.99,
        '5.00',
        'Product 15 description',
        5,
        60,
        2
    ),
    (
        'REF016',
        'image16.jpg',
        '123456789016',
        'Product 16',
        13.99,
        18.99,
        '3.00',
        'Product 16 description',
        7,
        85,
        3
    ),
    (
        'REF017',
        'image17.jpg',
        '123456789017',
        'Product 17',
        12.99,
        19.99,
        '3.50',
        'Product 17 description',
        3,
        45,
        1
    ),
    (
        'REF018',
        'image18.jpg',
        '123456789018',
        'Product 18',
        10.99,
        15.99,
        '2.00',
        'Product 18 description',
        4,
        70,
        2
    ),
    (
        'REF019',
        'image19.jpg',
        '123456789019',
        'Product 19',
        17.99,
        26.99,
        '6.00',
        'Product 19 description',
        6,
        100,
        3
    ),
    (
        'REF020',
        'image20.jpg',
        '123456789020',
        'Product 20',
        15.99,
        21.99,
        '4.50',
        'Product 20 description',
        2,
        35,
        1
    ),
    -- Continue adding more records
    (
        'REF021',
        'image21.jpg',
        '123456789021',
        'Product 21',
        11.99,
        16.99,
        '2.50',
        'Product 21 description',
        5,
        80,
        2
    ),
    (
        'REF022',
        'image22.jpg',
        '123456789022',
        'Product 22',
        14.99,
        22.99,
        '4.00',
        'Product 22 description',
        8,
        110,
        3
    ),
    (
        'REF023',
        'image23.jpg',
        '123456789023',
        'Product 23',
        16.99,
        24.99,
        '5.00',
        'Product 23 description',
        4,
        65,
        1
    ),
    (
        'REF024',
        'image24.jpg',
        '123456789024',
        'Product 24',
        13.99,
        19.99,
        '3.50',
        'Product 24 description',
        6,
        90,
        2
    ),
    -- Add more records as needed
    (
        'REF025',
        'image25.jpg',
        '123456789025',
        'Product 25',
        12.99,
        18.99,
        '3.00',
        'Product 25 description',
        3,
        50,
        3
    ),
    (
        'REF026',
        'image26.jpg',
        '123456789026',
        'Product 26',
        9.99,
        14.99,
        '2.50',
        'Product 26 description',
        7,
        75,
        1
    ),
    (
        'REF027',
        'image27.jpg',
        '123456789027',
        'Product 27',
        17.99,
        26.99,
        '6.00',
        'Product 27 description',
        5,
        95,
        2
    ),
    (
        'REF028',
        'image28.jpg',
        '123456789028',
        'Product 28',
        15.99,
        21.99,
        '4.50',
        'Product 28 description',
        4,
        60,
        3
    ),
    (
        'REF029',
        'image29.jpg',
        '123456789029',
        'Product 29',
        20.99,
        32.99,
        '7.00',
        'Product 29 description',
        6,
        85,
        1
    ),
    (
        'REF030',
        'image30.jpg',
        '123456789030',
        'Product 30',
        18.99,
        28.99,
        '6.00',
        'Product 30 description',
        2,
        40,
        2
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
    order_id INT,
    product_id INT,
    quantity INT,
    unit_price DECIMAL(10, 2),
    total_price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);
-- Table for client states (assuming admin can manage client states)
CREATE TABLE ClientStates (
    client_state_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    state ENUM('Validated', 'Cancelled', 'Other'),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);
-- Table for order states (assuming admin can manage order states)
CREATE TABLE OrderStates (
    order_state_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    state ENUM('Validated', 'Cancelled', 'Other'),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);
-- Table for product popularity
CREATE TABLE ProductPopularity (
    product_id INT PRIMARY KEY,
    popularity_count INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
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
        'User City'
    ),
    (
        'User1',
        'user1@test.com',
        'user123',
        'user',
        FALSE,
        'Inactive User',
        '111222333',
        'Inactive Address',
        'Inactive City'
    );