CREATE TABLE `employee` (
    `employee_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `personal_details` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `age` TINYINT UNSIGNED,
    `gender` ENUM('Male', 'Female', 'Other') NOT NULL,
    `address` VARCHAR(500),
    `city` VARCHAR(255),
    `state` VARCHAR(255),
    `zip_code` VARCHAR(20),
    `phone_number` VARCHAR(20),
    FOREIGN KEY (`employee_id`) REFERENCES `employee`(`employee_id`)
);

CREATE TABLE `additional_details` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT NOT NULL,
    `email` VARCHAR(255) UNIQUE,
    `emergency_contact` VARCHAR(255),
    `relationship` VARCHAR(100),
    FOREIGN KEY (`employee_id`) REFERENCES `employee`(`employee_id`)
);
