
CREATE TABLE `crypto_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `invoiceID` varchar(250) NOT NULL,
  `productID` varchar(250) DEFAULT NULL,
  `paymentID` varchar(250) DEFAULT NULL,
  `amount_coin` varchar(250) DEFAULT NULL,
  `amount_paid` varchar(250) DEFAULT NULL,
  `amount` varchar(250) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `txID` varchar(250) DEFAULT NULL,
  `coinLabel` varchar(250) DEFAULT NULL,
  `txConfirmed` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `txDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `processed` int(11) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT '0',
  `expired` int(11) NOT NULL DEFAULT '0',
  `invoiceCreatedDate` varchar(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

