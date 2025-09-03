CREATE TABLE IF NOT EXISTS `shop` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
);

INSERT INTO `shop` 
    (`name`)
VALUES
     ('Boba_store');
  


CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int,
  `price` int,
  `category` text,  
  `item_name` text,
  `item_image` text,  
  PRIMARY KEY (`id`)
);
INSERT INTO `items` 
    (`shop_id`, `price`, `category`, `item_name`, `item_image`)
VALUES
  (1, 6, 'boba', 'Rose Milk Tea', 'rose.jpg'),
  (1, 6, 'boba', 'Earl Grey Milk Tea', 'earl.jpg'),
  (1, 6, 'boba', 'Caramel Milk Tea', 'caramel.jpg'),
  (1, 7, 'boba', 'Strawberry Milk Tea', 'strawberry.jpg'),
  (1, 6, 'boba', 'Thai Milk Tea', 'thai.jpg'),
  (1, 7, 'boba', 'Matcha', 'macha.jpg'),
  (1, 6, 'boba', 'Jasmine Milk Tea', 'jasmine.jpg'),
  (1, 6, 'boba', 'Taro', 'taro.jpg'),
  (1, 7, 'snack', 'Popcorn Chicken', 'chicken.jpg'),
  (1, 6, 'snack', 'French Fries', 'fries.jpeg'),
  (1, 7, 'snack', 'Lobster Balls', 'lobster.jpeg'),
  (1, 6, 'snack', 'Chicken Pot-Stickers', 'pot.jpeg'),
  (1, 5, 'smoothie', 'Strawberry Smoothie', 'strawberrysm.jpg'),
  (1, 5, 'smoothie', 'Banana Smoothie', 'banana.jpg'),
  (1, 5, 'smoothie', 'Chocolate Smoothie', 'chocolate.jpg'),
  (1, 5, 'smoothie', 'Mango Smoothie', 'mango.jpg');

  
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shop_id` int,
  `user_name` varchar(15),
  `password` varchar(64),
  `real_pass` varchar(20),
  PRIMARY KEY (`id`)
);
INSERT INTO `admin` 
    (`shop_id`, `user_name`, `password`, `real_pass`)
VALUES
     (1, 'zoya', '$2y$10$LnsE6om1IAEsACUZsWnOC.PEMlcIGDNUiMGBMlCqbb.7SzvpKx4lq', 'password'),
      (2, 'richard','$2y$10$LnsE6om1IAEsACUZsWnOC.PEMlcIGDNUiMGBMlCqbb.7SzvpKx4lq', 'password'),
     (3, 'riti', '$2y$10$LnsE6om1IAEsACUZsWnOC.PEMlcIGDNUiMGBMlCqbb.7SzvpKx4lq', 'password');


CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15),
  `password` varchar(64),
  `real_pass` varchar(20),
  PRIMARY KEY (`id`)
);
INSERT INTO `customer` 
    (`user_name`, `password`, `real_pass`)
VALUES
     ('blablab','$2y$10$wevI/TfHziZxV5yium92be.RVrWjNRWnRAkN5XT9lzeM1yG4NS9fe', 'password'),
      ('yayay', '$2y$10$wevI/TfHziZxV5yium92be.RVrWjNRWnRAkN5XT9lzeM1yG4NS9fe', 'password'),
     ('coolcool', '$2y$10$wevI/TfHziZxV5yium92be.RVrWjNRWnRAkN5XT9lzeM1yG4NS9fe', 'password');

CREATE TABLE IF NOT EXISTS `purchased` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int,
  `item_id` int,
  `topping` int,
  `bought` text,
  PRIMARY KEY (`id`)
);